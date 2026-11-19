<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\TourPackage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Quotation::with(['customer', 'package', 'creator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.quotations.index', compact('quotations'));
    }

    public function create(Request $request): View
    {
        $selectedLead = $request->filled('lead_id') ? Lead::find($request->lead_id) : null;

        if ($selectedLead && ! $selectedLead->customer_id && (! empty($selectedLead->email) || ! empty($selectedLead->phone))) {
            $customer = Customer::firstOrCreate(
                ['email' => $selectedLead->email ?: ($selectedLead->phone.'@guest.bharattravel.com')],
                [
                    'customer_code' => 'CUST-'.date('Y').'-'.rand(1000, 9999),
                    'name' => $selectedLead->name,
                    'phone' => $selectedLead->phone,
                    'status' => 'active',
                ]
            );
            $selectedLead->update(['customer_id' => $customer->id]);
            $selectedLead->refresh();
        }

        $customers = Customer::orderBy('name')->get();
        $packages = TourPackage::where('is_active', true)->where('status', 'published')->get();
        $leads = Lead::whereIn('status', ['new', 'contacted', 'interested', 'follow_up'])->get();

        return view('admin.quotations.create', compact('customers', 'packages', 'leads', 'selectedLead'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (! $request->filled('customer_id') && $request->filled('lead_id')) {
            $lead = Lead::find($request->lead_id);
            if ($lead) {
                $customer = Customer::firstOrCreate(
                    ['email' => $lead->email ?: ($lead->phone.'@guest.bharattravel.com')],
                    [
                        'customer_code' => 'CUST-'.date('Y').'-'.rand(1000, 9999),
                        'name' => $lead->name,
                        'phone' => $lead->phone,
                        'status' => 'active',
                    ]
                );
                $request->merge(['customer_id' => $customer->id]);
                $lead->update(['customer_id' => $customer->id]);
            }
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'package_id' => 'nullable|exists:packages,id',
            'title' => 'required|string|max:200',
            'destination' => 'required|string|max:150',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'supplier_cost' => 'nullable|numeric|min:0',
            'valid_until' => 'nullable|date',
            'itinerary_text' => 'nullable|string',
            'inclusions_text' => 'nullable|string',
            'exclusions_text' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        $subtotal = (float) $validated['subtotal'];
        $discount = (float) ($validated['discount_amount'] ?? 0);
        $taxRate = (float) $validated['tax_rate'];
        $taxable = max(0, $subtotal - $discount);
        $taxAmount = round(($taxable * $taxRate) / 100, 2);
        $totalAmount = $taxable + $taxAmount;

        $supplierCost = (float) ($validated['supplier_cost'] ?? round($subtotal * 0.70, 2));
        $profitMargin = max(0, $subtotal - $supplierCost);

        $quotationNumber = 'QT-'.date('Y').'-'.strtoupper(Str::random(6));

        $itinerary = ! empty($validated['itinerary_text']) ? array_filter(array_map('trim', explode("\n", $validated['itinerary_text']))) : [];
        $inclusions = ! empty($validated['inclusions_text']) ? array_filter(array_map('trim', explode("\n", $validated['inclusions_text']))) : [];
        $exclusions = ! empty($validated['exclusions_text']) ? array_filter(array_map('trim', explode("\n", $validated['exclusions_text']))) : [];

        $quotation = Quotation::create([
            'quotation_number' => $quotationNumber,
            'customer_id' => $validated['customer_id'],
            'lead_id' => $validated['lead_id'] ?? null,
            'package_id' => $validated['package_id'] ?? null,
            'title' => $validated['title'],
            'destination' => $validated['destination'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'itinerary_details' => $itinerary,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'supplier_cost' => $supplierCost,
            'profit_margin' => $profitMargin,
            'valid_until' => $validated['valid_until'] ?? now()->addDays(14)->toDateString(),
            'status' => 'draft',
            'terms_conditions' => $validated['terms_conditions'] ?? null,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.quotations.show', $quotation->id)
            ->with('success', "Quotation #{$quotationNumber} generated successfully.");
    }

    public function show(int $id): View
    {
        $quotation = Quotation::with(['customer', 'package', 'creator', 'lead'])->findOrFail($id);

        return view('admin.quotations.show', compact('quotation'));
    }

    public function downloadPdf(int $id)
    {
        $quotation = Quotation::with(['customer', 'package', 'creator'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.quotation', compact('quotation'));

        return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
    }

    public function convertToBooking(int $id): RedirectResponse
    {
        $quotation = Quotation::with(['customer', 'package'])->findOrFail($id);

        return DB::transaction(function () use ($quotation) {
            $bookingNumber = 'BK-QT-'.strtoupper(Str::random(6));

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'customer_id' => $quotation->customer_id,
                'user_id' => Auth::id(),
                'service_type' => 'package',
                'package_id' => $quotation->package_id,
                'departure_date' => $quotation->start_date ?? now()->addDays(14)->toDateString(),
                'return_date' => $quotation->end_date ?? now()->addDays(20)->toDateString(),
                'adults' => $quotation->adults,
                'children' => $quotation->children,
                'selling_amount' => $quotation->subtotal,
                'discount_amount' => $quotation->discount_amount,
                'tax_amount' => $quotation->tax_amount,
                'total_amount' => $quotation->total_amount,
                'paid_amount' => 0.00,
                'balance_amount' => $quotation->total_amount,
                'supplier_cost' => $quotation->supplier_cost,
                'expected_profit' => $quotation->profit_margin,
                'booking_status' => 'confirmed',
                'payment_status' => 'unpaid',
                'notes' => "Converted from Quotation #{$quotation->quotation_number}",
            ]);

            $quotation->update(['status' => 'converted']);

            if ($quotation->lead) {
                $quotation->lead->update(['status' => 'converted']);
            }

            return redirect()->route('admin.bookings.show', $booking->id)
                ->with('success', "Quotation successfully converted to Confirmed Booking #{$bookingNumber}.");
        });
    }
}
