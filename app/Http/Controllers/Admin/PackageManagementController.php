<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\PackageCategory;
use App\Models\PackageDeparture;
use App\Models\PackageItinerary;
use App\Models\TourPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = TourPackage::with(['destination', 'category'])->withCount('bookings');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('package_code', 'like', "%{$search}%");
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $categories = PackageCategory::all();

        return view('admin.packages.index', compact('packages', 'categories'));
    }

    public function create(): View
    {
        $destinations = Destination::where('is_active', true)->get();
        $categories = PackageCategory::where('is_active', true)->get();

        return view('admin.packages.create', compact('destinations', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'destination_id' => 'required|exists:destinations,id',
            'category_id' => 'nullable|exists:package_categories,id',
            'type' => 'required|string|in:domestic,international',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'starting_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'departure_city' => 'nullable|string|max:100',
            'pickup_drop_info' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'highlights' => 'nullable|string', // newline separated
            'inclusions' => 'nullable|string', // newline separated
            'exclusions' => 'nullable|string', // newline separated
            'terms_conditions' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'required|string|in:draft,published',
        ]);

        $packageCode = 'PKG-'.strtoupper(Str::random(6));
        $slug = Str::slug($validated['title']).'-'.strtolower(Str::random(4));

        $highlights = ! empty($validated['highlights']) ? array_filter(array_map('trim', explode("\n", $validated['highlights']))) : [];
        $inclusions = ! empty($validated['inclusions']) ? array_filter(array_map('trim', explode("\n", $validated['inclusions']))) : [];
        $exclusions = ! empty($validated['exclusions']) ? array_filter(array_map('trim', explode("\n", $validated['exclusions']))) : [];

        $package = TourPackage::create(array_merge($validated, [
            'package_code' => $packageCode,
            'slug' => $slug,
            'child_price' => $validated['child_price'] ?? 0,
            'infant_price' => $validated['infant_price'] ?? 0,
            'highlights' => $highlights,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.packages.show', $package->id)
            ->with('success', "Package '{$package->title}' created. You can now add Day-wise Itineraries and Departure dates.");
    }

    public function show(int $id): View
    {
        $package = TourPackage::with(['destination', 'category', 'itineraries', 'departures', 'bookings.customer'])
            ->findOrFail($id);

        return view('admin.packages.show', compact('package'));
    }

    public function edit(int $id): View
    {
        $package = TourPackage::findOrFail($id);
        $destinations = Destination::where('is_active', true)->get();
        $categories = PackageCategory::where('is_active', true)->get();

        return view('admin.packages.edit', compact('package', 'destinations', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $package = TourPackage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'destination_id' => 'required|exists:destinations,id',
            'category_id' => 'nullable|exists:package_categories,id',
            'type' => 'required|string|in:domestic,international',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'starting_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'departure_city' => 'nullable|string|max:100',
            'pickup_drop_info' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'highlights' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'status' => 'required|string|in:draft,published',
        ]);

        $highlights = ! empty($validated['highlights']) ? array_filter(array_map('trim', explode("\n", $validated['highlights']))) : $package->highlights;
        $inclusions = ! empty($validated['inclusions']) ? array_filter(array_map('trim', explode("\n", $validated['inclusions']))) : $package->inclusions;
        $exclusions = ! empty($validated['exclusions']) ? array_filter(array_map('trim', explode("\n", $validated['exclusions']))) : $package->exclusions;

        $package->update(array_merge($validated, [
            'child_price' => $validated['child_price'] ?? 0,
            'infant_price' => $validated['infant_price'] ?? 0,
            'highlights' => $highlights,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.packages.show', $package->id)->with('success', 'Package updated successfully.');
    }

    public function addItinerary(Request $request, int $id): RedirectResponse
    {
        $package = TourPackage::findOrFail($id);

        $validated = $request->validate([
            'day_number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'hotel_info' => 'nullable|string|max:200',
            'meals_info' => 'nullable|string|max:200',
            'transport_info' => 'nullable|string|max:200',
        ]);

        PackageItinerary::create(array_merge($validated, ['package_id' => $package->id]));

        return back()->with('success', "Day {$validated['day_number']} itinerary added.");
    }

    public function addDeparture(Request $request, int $id): RedirectResponse
    {
        $package = TourPackage::findOrFail($id);

        $validated = $request->validate([
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0',
            'price_override' => 'nullable|numeric|min:0',
        ]);

        PackageDeparture::create(array_merge($validated, [
            'package_id' => $package->id,
            'status' => 'open',
        ]));

        return back()->with('success', 'Departure schedule added.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $package = TourPackage::findOrFail($id);
        $title = $package->title;
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', "Package '{$title}' has been deleted successfully.");
    }
}
