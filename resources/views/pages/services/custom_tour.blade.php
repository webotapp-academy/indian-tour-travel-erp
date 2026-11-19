@extends('layouts.app')

@section('title', 'Bespoke Custom Holiday Itinerary Planner - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="compass" class="w-4 h-4 text-amber-400"></i>
                Bespoke Holiday Architecture
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Craft Your Dream Custom Vacation
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Every traveler is unique. Tell us where you wish to explore, your dates, luxury preferences, and vehicle choice. Receive a bespoke day-by-day itinerary PDF with transparent pricing within 2 hours.
            </p>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">2 Hours</div>
                        <div class="text-xs text-slate-400">Fast Itinerary Turnaround</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="car" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Dedicated</div>
                        <div class="text-xs text-slate-400">Private Cab & Chauffeur</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                        <i data-lucide="sliders" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">100% Flexi</div>
                        <div class="text-xs text-slate-400">Customized Sightseeing</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Zero Extra</div>
                        <div class="text-xs text-slate-400">Direct Contracted Rates</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Section: Form & Perks -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Form -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Tailored From Scratch</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Design Your Custom Itinerary</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Senior Designers Online
                    </span>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 text-sm rounded-r-xl flex items-center gap-3">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-sm rounded-r-xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('services.custom_tour.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Where do you want to go? *</label>
                            <div class="relative">
                                <input type="text" name="destination" required value="{{ old('destination') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                       placeholder="e.g. Kashmir (Srinagar, Gulmarg)">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Departure City</label>
                            <div class="relative">
                                <input type="text" name="departure_city" value="{{ old('departure_city') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                       placeholder="e.g. Delhi, Mumbai, Ahmedabad">
                                <i data-lucide="navigation" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Travel Start Date *</label>
                            <div class="relative">
                                <input type="date" name="travel_start_date" required min="{{ date('Y-m-d') }}" value="{{ old('travel_start_date', date('Y-m-d', strtotime('+14 days'))) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Travel End Date</label>
                            <div class="relative">
                                <input type="date" name="travel_end_date" min="{{ date('Y-m-d') }}" value="{{ old('travel_end_date', date('Y-m-d', strtotime('+20 days'))) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Adults (12y+) *</label>
                            <select name="adults" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('adults', 2) == $i ? 'selected' : '' }}>{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Children (2-11y)</label>
                            <select name="children" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                                @for($i = 0; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('children', 0) == $i ? 'selected' : '' }}>{{ $i }} Child</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Infants (<2y)</label>
                            <select name="infants" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                                @for($i = 0; $i <= 4; $i++)
                                    <option value="{{ $i }}" {{ old('infants', 0) == $i ? 'selected' : '' }}>{{ $i }} Infant</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Approx. Budget Per Person (₹)</label>
                            <div class="relative">
                                <input type="number" name="budget" value="{{ old('budget') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                       placeholder="e.g. 45000">
                                <span class="absolute left-3.5 top-3.5 text-slate-400 font-bold text-sm">₹</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hotel Category Preference</label>
                            <select name="hotel_category" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                                <option value="4 Star Premium" selected>4 Star Premium & Boutique</option>
                                <option value="3 Star Standard">3 Star Standard & Comfortable</option>
                                <option value="5 Star Luxury">5 Star Luxury & Heritage Palaces</option>
                                <option value="Ultra Luxury / Pool Villas">Ultra Luxury & Private Villas</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Private Vehicle Preference</label>
                        <select name="transport_preference" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                            <option value="SUV (Innova Crysta)" selected>Premium SUV (Innova Crysta - 4 to 6 Pax)</option>
                            <option value="Sedan (Dzire / Etios)">Sedan (Dzire / Etios - 1 to 3 Pax)</option>
                            <option value="Luxury Coach (Tempo Traveller)">Luxury AC Coach (Tempo Traveller - 7 to 12 Pax)</option>
                            <option value="Flight + Cab Combo">Flight + Cab Complete Combo</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                            <input type="text" name="name" required value="{{ old('name', Auth::user()?->name) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                   placeholder="Full Name">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <input type="tel" name="phone" required value="{{ old('phone', Auth::user()?->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                   placeholder="+91 98765 43210">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <input type="email" name="email" required value="{{ old('email', Auth::user()?->email) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                   placeholder="you@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Special Occasion & Preferences</label>
                        <textarea name="special_requirements" rows="2"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                  placeholder="Mention Honeymoon setup, anniversary cake, Jain/Pure Veg meals, senior citizen ground floor rooms, photography stops...">{{ old('special_requirements') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="sparkles" class="w-4 h-4 mr-2"></i>
                            Design My Custom Holiday Itinerary
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                            Detailed PDF Proposal in 2 Hours
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Custom Holiday Advantages -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <i data-lucide="gem" class="w-4 h-4 text-amber-500"></i>
                        The BharatTravel Custom Experience
                    </h3>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="user-check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Dedicated Holiday Concierge</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Direct 1-on-1 contact with a destination specialist who knows hidden viewpoints, restaurants, and timings.</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="car" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Dedicated Chauffeur & Vehicle</h4>
                                <p class="text-xs text-slate-500 mt-0.5">No shared tour buses or fixed departure hurry. Travel at your own family pace with vetted, courteous drivers.</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="hotel" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Inspected Boutique & Luxury Stays</h4>
                                <p class="text-xs text-slate-500 mt-0.5">From heritage royal suites in Rajasthan to luxury glass igloos in Gulmarg, handpicked for comfort and views.</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="wallet" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Zero Hidden Surcharges</h4>
                                <p class="text-xs text-slate-500 mt-0.5">All state permits, toll taxes, parking, driver allowances, and 5% GST clearly itemized upfront.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Callout -->
                <div class="bg-gradient-to-br from-amber-950 to-slate-950 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="phone-forwarded" class="w-6 h-6 text-amber-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Prefer to Discuss over Phone?</h4>
                            <p class="text-xs text-amber-200 mb-3">Our holiday architects are available 7 days a week from 9:00 AM to 9:00 PM IST.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-amber-200">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                Call Travel Architect: +91 11 4567 8900 (Ext. 1)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
