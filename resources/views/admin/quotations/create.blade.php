@extends('layouts.admin')

@section('title', 'Generate Holiday Itinerary Quotation | BharatTravel')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.quotations.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900">&larr; Back to Quotations</a>
                <span class="text-slate-300">•</span>
                <span class="text-xs font-bold text-amber-600 uppercase">Proposal Architect</span>
            </div>
            <h1 class="text-xl font-bold font-serif text-slate-900">Build Travel Itinerary Quotation</h1>
            <p class="text-xs text-slate-500 mt-0.5">Assemble day-wise itineraries, supplier costs, margin calculations, and PDF proposal generation.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs rounded-r">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.quotations.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <!-- Client & Lead Association -->
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-amber-500"></i> Client & CRM Association
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Customer Profile *</label>
                        <select name="customer_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                            <option value="">Select Target Customer</option>
                            @foreach($customers as $cust)
                                <option value="{{ $cust->id }}" 
                                    {{ (old('customer_id') == $cust->id || ($selectedLead && $selectedLead->customer_id == $cust->id)) ? 'selected' : '' }}>
                                    {{ $cust->name }} ({{ $cust->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Link to Lead Inquiry (Optional)</label>
                        <select name="lead_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                            <option value="">None / Standalone Quote</option>
                            @foreach($leads as $ld)
                                <option value="{{ $ld->id }}" {{ (old('lead_id') == $ld->id || ($selectedLead && $selectedLead->id == $ld->id)) ? 'selected' : '' }}>
                                    {{ $ld->lead_number }} - {{ $ld->name }} ({{ $ld->destination }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Preset Tour Package (Optional)</label>
                        <select name="package_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                            <option value="">Custom Tailored Itinerary</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" {{ old('package_id') == $pkg->id ? 'selected' : '' }}>
                                    {{ $pkg->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Quotation Parameters -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-amber-500"></i> Trip Specification
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1">Proposal Title *</label>
                        <input type="text" name="title" required 
                               value="{{ old('title', $selectedLead ? 'Custom Holiday Proposal for ' . $selectedLead->destination : '') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs"
                               placeholder="e.g. Kashmir Luxury Honeymoon 6D5N Package">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1">Target Destination *</label>
                        <input type="text" name="destination" required 
                               value="{{ old('destination', $selectedLead ? $selectedLead->destination : '') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs"
                               placeholder="e.g. Kashmir / Dubai / Kerala">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Travel Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $selectedLead?->travel_start_date ? \Carbon\Carbon::parse($selectedLead->travel_start_date)->format('Y-m-d') : '') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Travel End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Quote Validity Date</label>
                        <input type="date" name="valid_until" value="{{ old('valid_until', date('Y-m-d', strtotime('+14 days'))) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Adults (12+ Yrs) *</label>
                        <input type="number" name="adults" min="1" required value="{{ old('adults', $selectedLead?->adults ?? 2) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Children (2-12 Yrs)</label>
                        <input type="number" name="children" min="0" value="{{ old('children', $selectedLead?->children ?? 0) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Commercial Pricing & Margins -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="calculator" class="w-4 h-4 text-amber-500"></i> Financial Breakdown & Margin
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Selling Subtotal (₹) *</label>
                        <input type="number" step="0.01" name="subtotal" required value="{{ old('subtotal', 50000) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Discount Amount (₹)</label>
                        <input type="number" step="0.01" name="discount_amount" value="{{ old('discount_amount', 0) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">GST Tax Rate (%) *</label>
                        <select name="tax_rate" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="5.00" selected>5% (GST SAC 9985 - Tour Operator)</option>
                            <option value="18.00">18% (Consultancy / Agency Margin)</option>
                            <option value="0.00">0% (SEZ / Exempt)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Estimated Supplier Cost (₹)</label>
                        <input type="number" step="0.01" name="supplier_cost" value="{{ old('supplier_cost', 35000) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Day-Wise Proposal Details -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-amber-500"></i> Proposal Content (One line per day/item)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Day-Wise Itinerary Points</label>
                        <textarea name="itinerary_text" rows="5" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono" placeholder="Day 1: Arrival & Shikara Ride&#10;Day 2: Gulmarg Meadow of Flowers&#10;Day 3: Pahalgam Valley Excursion">{{ old('itinerary_text') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Proposal Inclusions</label>
                        <textarea name="inclusions_text" rows="5" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono" placeholder="4-Star Hotel Stay&#10;Daily Breakfast & Dinner&#10;Private Innova Crysta for all transfers">{{ old('inclusions_text') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Proposal Exclusions</label>
                        <textarea name="exclusions_text" rows="5" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono" placeholder="Airfare / Rail tickets&#10;Gondola Phase 2 tickets&#10;Personal tips and gratuities">{{ old('exclusions_text') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Generate PDF Quotation Proposal
            </button>
        </form>
    </div>
</div>
@endsection

