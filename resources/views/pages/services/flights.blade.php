@extends('layouts.app')

@section('title', 'Flight Ticketing & Corporate Airfares - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-sky-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#0284c7_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-300 border border-sky-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="plane-takeoff" class="w-4 h-4 text-sky-400"></i>
                IATA Accredited Global Air Desk
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Best Airfare Guarantee & Flight Concierge
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Access wholesale GDS airline fares, corporate seat blocks, complimentary web check-in, extra student baggage allowances, and 24/7 flight rescheduling desk.
            </p>

            <!-- Quick Trust Badges -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center shrink-0">
                        <i data-lucide="percent" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">0% Fee</div>
                        <div class="text-xs text-slate-400">On Round Trips</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="luggage" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">+10kg</div>
                        <div class="text-xs text-slate-400">Student Baggage</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Flexi Fares</div>
                        <div class="text-xs text-slate-400">Free Date Change</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                        <i data-lucide="headphones" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">24/7 Desk</div>
                        <div class="text-xs text-slate-400">Airport Support</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Interactive Section: Form + Popular Routes -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Flight Enquiry Terminal -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Direct Amadeus & Sabre Engine</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Request Best Airfare Quote</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        Live GDS Connected
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

                <form action="{{ route('services.flights.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Trip Type Toggle -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Trip Type</label>
                        <div class="grid grid-cols-3 gap-2 p-1.5 bg-slate-100 rounded-2xl">
                            <label class="cursor-pointer py-2 text-center rounded-xl text-xs font-bold transition-all text-slate-700 [&:has(:checked)]:bg-white [&:has(:checked)]:text-sky-600 [&:has(:checked)]:shadow-sm">
                                <input type="radio" name="trip_type" value="round_trip" {{ old('trip_type', 'round_trip') == 'round_trip' ? 'checked' : '' }} class="sr-only">
                                Round Trip
                            </label>
                            <label class="cursor-pointer py-2 text-center rounded-xl text-xs font-bold transition-all text-slate-700 [&:has(:checked)]:bg-white [&:has(:checked)]:text-sky-600 [&:has(:checked)]:shadow-sm">
                                <input type="radio" name="trip_type" value="one_way" {{ old('trip_type') == 'one_way' ? 'checked' : '' }} class="sr-only">
                                One Way
                            </label>
                            <label class="cursor-pointer py-2 text-center rounded-xl text-xs font-bold transition-all text-slate-700 [&:has(:checked)]:bg-white [&:has(:checked)]:text-sky-600 [&:has(:checked)]:shadow-sm">
                                <input type="radio" name="trip_type" value="multi_city" {{ old('trip_type') == 'multi_city' ? 'checked' : '' }} class="sr-only">
                                Multi City
                            </label>
                        </div>
                    </div>

                    <!-- Origin & Destination -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">From (Origin Airport / City) *</label>
                            <div class="relative">
                                <input type="text" name="departure_airport" required value="{{ old('departure_airport') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                       placeholder="e.g. New Delhi (DEL)">
                                <i data-lucide="plane-takeoff" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">To (Destination Airport / City) *</label>
                            <div class="relative">
                                <input type="text" name="arrival_airport" required value="{{ old('arrival_airport') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                       placeholder="e.g. Dubai (DXB) / Mumbai (BOM)">
                                <i data-lucide="plane-landing" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Departure Date *</label>
                            <div class="relative">
                                <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" value="{{ old('departure_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Return Date (For Round Trip)</label>
                            <div class="relative">
                                <input type="date" name="return_date" min="{{ date('Y-m-d') }}" value="{{ old('return_date') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers & Cabin -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Adults (12y+)</label>
                            <select name="adults" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm bg-white">
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ old('adults', 1) == $i ? 'selected' : '' }}>{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Children (2-11y)</label>
                            <select name="children" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm bg-white">
                                @for($i = 0; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('children', 0) == $i ? 'selected' : '' }}>{{ $i }} Child</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Infants (<2y)</label>
                            <select name="infants" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm bg-white">
                                @for($i = 0; $i <= 4; $i++)
                                    <option value="{{ $i }}" {{ old('infants', 0) == $i ? 'selected' : '' }}>{{ $i }} Infant</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cabin Class *</label>
                            <select name="cabin_class" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm bg-white">
                                <option value="economy" {{ old('cabin_class') == 'economy' ? 'selected' : '' }}>Economy</option>
                                <option value="premium_economy" {{ old('cabin_class') == 'premium_economy' ? 'selected' : '' }}>Premium Eco</option>
                                <option value="business" {{ old('cabin_class') == 'business' ? 'selected' : '' }}>Business</option>
                                <option value="first" {{ old('cabin_class') == 'first' ? 'selected' : '' }}>First Class</option>
                            </select>
                        </div>
                    </div>

                    <!-- Airline & Contact -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Preferred Airline (Optional)</label>
                            <input type="text" name="preferred_airline" value="{{ old('preferred_airline') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                   placeholder="e.g. Air India, Emirates, IndiGo">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                            <input type="text" name="contact_name" required value="{{ old('contact_name', Auth::user()?->name) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                   placeholder="Contact Person">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                   placeholder="+91 98765 43210">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <input type="email" name="contact_email" required value="{{ old('contact_email', Auth::user()?->email) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                   placeholder="you@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Special Meal, Seat or Group Requests</label>
                        <textarea name="remarks" rows="2"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                                  placeholder="Mention wheelchair assistance, extra baggage, meal preferences, or group booking count (10+ pax)...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                            Fetch Best Airline Fares
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-sky-600"></i>
                            Direct GDS Quotes in 15 Minutes
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Top Trending Flight Routes -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="trending-up" class="w-4 h-4 text-sky-600"></i>
                            Top Trending Air Routes
                        </h3>
                        <span class="text-xs text-slate-500">Live Deals</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 hover:bg-sky-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center">
                                    DEL
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">New Delhi ⇄ Mumbai</div>
                                    <div class="text-xs text-slate-500">Non-stop • 2h 10m • Daily Flights</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹3,899</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Special Fare</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-sky-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center">
                                    BLR
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Bengaluru ⇄ New Delhi</div>
                                    <div class="text-xs text-slate-500">Non-stop • 2h 45m • Vistara / IndiGo</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹4,499</div>
                                <span class="text-[10px] text-sky-600 font-semibold">Corporate Rate</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-sky-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 font-bold text-xs flex items-center justify-center">
                                    BOM
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Mumbai ⇄ Goa (Dabolim/MOPA)</div>
                                    <div class="text-xs text-slate-500">Non-stop • 1h 15m • Weekend Deals</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹2,499</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Hot Seller</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-sky-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 font-bold text-xs flex items-center justify-center">
                                    DXB
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Delhi ⇄ Dubai (DXB)</div>
                                    <div class="text-xs text-slate-500">Emirates / Air India • 3h 40m</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹14,999</div>
                                <span class="text-[10px] text-purple-600 font-semibold">30kg Baggage</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-sky-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center">
                                    BKK
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Mumbai ⇄ Bangkok (BKK)</div>
                                    <div class="text-xs text-slate-500">Non-stop • 4h 15m • Free Visa on Arr.</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹15,899</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Top Leisure</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Callout -->
                <div class="bg-gradient-to-br from-slate-900 to-sky-950 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="users" class="w-6 h-6 text-sky-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Planning a Group Flight (10+ Pax)?</h4>
                            <p class="text-xs text-slate-300 mb-3">Get private group seat blocks, name change flexibility up to 48 hours before takeoff, and special group tariffs.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-xs font-bold text-sky-300 hover:text-sky-200">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                Call Group Desk: +91 11 4567 8900 (Ext. 4)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Airline Partners -->
<section class="py-12 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-6">Direct Inventory Access With Top Global Airlines</p>
        <div class="flex flex-wrap items-center justify-center gap-8 md:gap-14 text-slate-600 font-bold text-sm tracking-wide">
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-sky-600"></i> Air India</span>
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-blue-600"></i> IndiGo</span>
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-red-600"></i> Emirates</span>
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-amber-600"></i> Singapore Airlines</span>
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-purple-600"></i> Qatar Airways</span>
            <span class="flex items-center gap-2"><i data-lucide="plane" class="w-4 h-4 text-sky-500"></i> Vistara</span>
        </div>
    </div>
</section>
@endsection
