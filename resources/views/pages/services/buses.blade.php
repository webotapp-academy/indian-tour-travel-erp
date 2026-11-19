@extends('layouts.app')

@section('title', 'Luxury Volvo Bus Tickets & Highway Charters - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-teal-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#14b8a6_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-300 border border-teal-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="bus" class="w-4 h-4 text-teal-400"></i>
                Premium Intercity Highway Luxury Coaches
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Volvo AC Sleeper & Group Coach Charters
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Guaranteed single sleeper berths, sanitized fleet with fresh blankets, live GPS tracking, and corporate Tempo Traveller / Volvo charters across all major tourist corridors.
            </p>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Live GPS</div>
                        <div class="text-xs text-slate-400">Real-Time Tracking</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Ladies Safe</div>
                        <div class="text-xs text-slate-400">Reserved Berths</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="wifi" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Amenities</div>
                        <div class="text-xs text-slate-400">Wi-Fi & Charging</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Charters</div>
                        <div class="text-xs text-slate-400">Tempo & Coaches</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Section: Form & Top Routes -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Form -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Premium Fleet Network</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Book Bus Tickets or Charter Coaches</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        Volvo 9600 Ready
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

                <form action="{{ route('services.buses.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Departure City *</label>
                            <div class="relative">
                                <input type="text" name="from_city" required value="{{ old('from_city') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                                       placeholder="e.g. Delhi (Kashmere Gate) / Bangalore">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Destination City *</label>
                            <div class="relative">
                                <input type="text" name="to_city" required value="{{ old('to_city') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                                       placeholder="e.g. Manali / Goa / Jaipur">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Journey Date *</label>
                            <div class="relative">
                                <input type="date" name="journey_date" required min="{{ date('Y-m-d') }}" value="{{ old('journey_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                       class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Coach Tier *</label>
                            <select name="bus_type" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm bg-white">
                                <option value="AC Volvo Multi-Axle Sleeper" {{ old('bus_type') == 'AC Volvo Multi-Axle Sleeper' ? 'selected' : '' }}>Volvo Multi-Axle Sleeper</option>
                                <option value="Scania Luxury AC Sleeper" {{ old('bus_type') == 'Scania Luxury AC Sleeper' ? 'selected' : '' }}>Scania Luxury Sleeper</option>
                                <option value="AC BharatBenz Semi-Sleeper" {{ old('bus_type') == 'AC BharatBenz Semi-Sleeper' ? 'selected' : '' }}>BharatBenz Semi-Sleeper</option>
                                <option value="Tempo Traveller (12-26 Seater Charter)" {{ old('bus_type') == 'Tempo Traveller (12-26 Seater Charter)' ? 'selected' : '' }}>Tempo Traveller Charter</option>
                                <option value="Volvo 45-53 Seater Coach Charter" {{ old('bus_type') == 'Volvo 45-53 Seater Coach Charter' ? 'selected' : '' }}>Volvo 45-Seater Charter</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Passenger Count *</label>
                            <select name="passenger_count" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm bg-white">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('passenger_count', 1) == $i ? 'selected' : '' }}>{{ $i }} Seat{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                                <option value="12">12 Pax (Tempo Charter)</option>
                                <option value="17">17 Pax (Tempo Charter)</option>
                                <option value="26">26 Pax (Mini Coach)</option>
                                <option value="45">45 Pax (Full Volvo Charter)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Lead Passenger Name *</label>
                            <input type="text" name="contact_name" required value="{{ old('contact_name', Auth::user()?->name) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                                   placeholder="Full Name">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                                   placeholder="+91 98765 43210">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pickup Point / Berth Preference / Remarks</label>
                        <textarea name="remarks" rows="2"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm"
                                  placeholder="Mention preferred boarding point, Lower Single Sleeper request, Ladies Berth reservation, or corporate charter schedule...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-teal-600 to-emerald-700 hover:from-teal-700 hover:to-emerald-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                            Reserve Bus Seats / Get Charter Quote
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-teal-600"></i>
                            Live GPS & Sanitized Coach Guaranteed
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Top Routes -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="trending-up" class="w-4 h-4 text-teal-600"></i>
                            Popular Tourist Corridors
                        </h3>
                        <span class="text-xs text-slate-500">Night Volvos</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 hover:bg-teal-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Delhi ⇄ Manali / Solang</div>
                                <div class="text-xs text-slate-500">Volvo 9600 Sleeper • 12h Overnight • AC</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-teal-900">₹1,199</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Blanket Inc.</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-teal-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Bangalore ⇄ Goa (Panaji)</div>
                                <div class="text-xs text-slate-500">Scania Multi-Axle • 11h Overnight</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-teal-900">₹1,250</div>
                                <span class="text-[10px] text-teal-600 font-semibold">Charging Port</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-teal-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Mumbai ⇄ Mahabaleshwar</div>
                                <div class="text-xs text-slate-500">Mercedes-Benz AC • 6h Express Highway</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-teal-900">₹650</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Daily Run</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-teal-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Delhi ⇄ Jaipur (Pink City)</div>
                                <div class="text-xs text-slate-500">Expressway Volvo • 4h 30m • Wi-Fi</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-teal-900">₹499</div>
                                <span class="text-[10px] text-teal-600 font-semibold">Every 30 Mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charter Callout -->
                <div class="bg-gradient-to-br from-teal-950 to-slate-950 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="compass" class="w-6 h-6 text-teal-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Wedding & Corporate Coach Charters</h4>
                            <p class="text-xs text-teal-200 mb-3">Book whole Luxury Tempo Travellers (12/17/26 seaters) or full 45-seater Volvo coaches with chauffeur and fuel included.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-amber-200">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                Bus Charter Desk: +91 11 4567 8900 (Ext. 7)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
