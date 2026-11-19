<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\PackageCategory;
use App\Models\Payment;
use App\Models\TourPackage;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TourPackageController extends Controller
{
    public function index(Request $request): View
    {
        $query = TourPackage::with(['destination', 'category'])
            ->where('is_active', true)
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('departure_city', 'like', "%{$search}%")
                    ->orWhereHas('destination', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($cq) use ($request) {
                $cq->where('slug', $request->category);
            });
        }

        if ($request->filled('destination')) {
            $query->where('destination_id', $request->destination);
        }

        if ($request->filled('budget')) {
            $budget = (float) $request->budget;
            $query->where('starting_price', '<=', $budget);
        }

        if ($request->filled('duration')) {
            $duration = (int) $request->duration;
            if ($duration === 3) {
                $query->where('duration_days', '<=', 4);
            } elseif ($duration === 7) {
                $query->whereBetween('duration_days', [5, 7]);
            } elseif ($duration === 10) {
                $query->where('duration_days', '>=', 8);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        if ($sort === 'price_asc') {
            $query->orderBy('starting_price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('starting_price', 'desc');
        } elseif ($sort === 'duration_desc') {
            $query->orderBy('duration_days', 'desc');
        } else {
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        $packages = $query->paginate(12)->withQueryString();
        $categories = PackageCategory::where('is_active', true)->get();
        $destinations = Destination::where('is_active', true)->get();

        return view('pages.packages.index', compact('packages', 'categories', 'destinations'));
    }

    public function show(string $slug): View
    {
        $package = TourPackage::with(['destination', 'category', 'itineraries', 'departures'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPackages = TourPackage::where('id', '!=', $package->id)
            ->where('type', $package->type)
            ->where('is_active', true)
            ->where('status', 'published')
            ->take(3)
            ->get();

        $isWishlisted = Auth::check() ? Wishlist::where('user_id', Auth::id())->where('package_id', $package->id)->exists() : false;

        return view('pages.packages.show', compact('package', 'relatedPackages', 'isWishlisted'));
    }

    public function bookForm(string $slug): View
    {
        $package = TourPackage::with(['departures', 'destination'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();
        $customer = $user ? $user->customer : null;

        return view('pages.packages.book', compact('package', 'user', 'customer'));
    }

    public function submitBooking(Request $request, string $slug): RedirectResponse
    {
        $package = TourPackage::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => 'required|string|max:25',
            'departure_date' => 'required|date|after_or_equal:today',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:10',
            'infants' => 'nullable|integer|min:0|max:5',
            'coupon_code' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'advance_payment_method' => 'required|string|in:upi,card,netbanking,pay_later',
        ]);

        return DB::transaction(function () use ($package, $validated) {
            $adults = (int) $validated['adults'];
            $children = (int) ($validated['children'] ?? 0);
            $infants = (int) ($validated['infants'] ?? 0);

            $unitAdultPrice = (float) ($package->discount_price ?: $package->adult_price);
            $unitChildPrice = (float) $package->child_price;
            $unitInfantPrice = (float) $package->infant_price;

            $sellingAmount = ($adults * $unitAdultPrice) + ($children * $unitChildPrice) + ($infants * $unitInfantPrice);

            $discountAmount = 0.00;
            if (! empty($validated['coupon_code'])) {
                $coupon = Coupon::where('code', strtoupper($validated['coupon_code']))->first();
                if ($coupon && $coupon->isValid($sellingAmount)) {
                    $discountAmount = $coupon->calculateDiscount($sellingAmount);
                    $coupon->increment('used_count');
                }
            }

            $taxable = max(0, $sellingAmount - $discountAmount);
            $taxAmount = round($taxable * 0.05, 2); // 5% GST
            $totalAmount = $taxable + $taxAmount;

            // Find or create customer
            $customer = null;
            if (Auth::check()) {
                $customer = Auth::user()->customer;
            }

            if (! $customer) {
                $customer = Customer::firstOrCreate(
                    ['email' => $validated['customer_email']],
                    [
                        'customer_code' => 'CUST-'.date('Y').'-'.rand(1000, 9999),
                        'name' => $validated['customer_name'],
                        'phone' => $validated['customer_phone'],
                        'status' => 'active',
                    ]
                );
            }

            $bookingNumber = 'BK-'.date('Y').'-'.strtoupper(Str::random(6));

            $paidAmount = 0.00;
            $paymentStatus = 'unpaid';
            $bookingStatus = 'pending_payment';

            if ($validated['advance_payment_method'] !== 'pay_later') {
                $paidAmount = round($totalAmount * 0.25, 2); // 25% advance
                $paymentStatus = 'partially_paid';
                $bookingStatus = 'confirmed';
            }

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'customer_id' => $customer->id,
                'user_id' => Auth::id(),
                'service_type' => 'package',
                'package_id' => $package->id,
                'departure_date' => $validated['departure_date'],
                'return_date' => Carbon::parse($validated['departure_date'])->addDays($package->duration_days)->toDateString(),
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'selling_amount' => $sellingAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'balance_amount' => $totalAmount - $paidAmount,
                'supplier_cost' => round($sellingAmount * 0.70, 2),
                'expected_profit' => round($sellingAmount * 0.30, 2),
                'booking_status' => $bookingStatus,
                'payment_status' => $paymentStatus,
                'notes' => $validated['special_requests'] ?? null,
            ]);

            // Create lead record for CRM visibility
            $lead = Lead::create([
                'lead_number' => 'LEAD-'.date('Y').'-'.rand(1000, 9999),
                'customer_id' => $customer->id,
                'name' => $validated['customer_name'],
                'email' => $validated['customer_email'],
                'phone' => $validated['customer_phone'],
                'destination' => $package->destination ? $package->destination->name : $package->title,
                'category' => 'package_booking',
                'priority' => 'high',
                'status' => 'converted',
                'budget' => $totalAmount,
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'travel_start_date' => $validated['departure_date'],
                'notes' => "Online package booking #{$bookingNumber}",
            ]);

            LeadActivity::create([
                'lead_id' => $lead->id,
                'type' => 'status_change',
                'summary' => "Booking Confirmed: {$bookingNumber}",
                'details' => "Customer created direct online booking for package '{$package->title}' with 25% advance.",
            ]);

            if ($paidAmount > 0) {
                Payment::create([
                    'payment_number' => 'PAY-'.date('Y').'-'.strtoupper(Str::random(6)),
                    'booking_id' => $booking->id,
                    'customer_id' => $customer->id,
                    'amount' => $paidAmount,
                    'payment_method' => $validated['advance_payment_method'],
                    'transaction_id' => 'TXN-'.strtoupper(Str::random(10)),
                    'reference_number' => 'REF-'.strtoupper(Str::random(8)),
                    'payment_date' => now()->toDateString(),
                    'type' => 'advance',
                    'status' => 'completed',
                    'notes' => '25% online advance deposit',
                ]);
            }

            return redirect()->route('customer.dashboard')
                ->with('success', "Congratulations! Your booking #{$bookingNumber} has been recorded successfully. Our team has dispatched your booking receipt.");
        });
    }

    public function checkCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->get('code', '')));
        $amount = (float) $request->get('amount', 0);

        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->isValid($amount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or expired promotional coupon code.',
            ]);
        }

        $discount = $coupon->calculateDiscount($amount);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'description' => $coupon->description,
            'message' => "Coupon '{$code}' applied successfully! You save ₹".number_format($discount, 2),
        ]);
    }

    public function toggleWishlist(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to save packages to your wishlist.'], 401);
        }

        $packageId = (int) $request->package_id;
        $existing = Wishlist::where('user_id', Auth::id())->where('package_id', $packageId)->first();

        if ($existing) {
            $existing->delete();

            return response()->json(['success' => true, 'saved' => false, 'message' => 'Package removed from your wishlist.']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'package_id' => $packageId,
        ]);

        return response()->json(['success' => true, 'saved' => true, 'message' => 'Package saved to your wishlist!']);
    }
}
