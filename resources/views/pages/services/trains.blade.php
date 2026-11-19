@extends('layouts.app')

@section('title', 'IRCTC Train Booking Assistance & Tatkal Desk - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-rose-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#f43f5e_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="train" class="w-4 h-4 text-rose-400"></i>
                IRCTC Authorized Rail Concierge Desk
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Indian Railways Ticket Booking Assistance
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Skip the waitlist frustration. Get Tatkal allocation assistance, Vande Bharat Express seats, Rajdhani/Tejas confirmations, and real-time PNR tracking alerts.
            </p>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                        <i data-lucide="zap" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">96%</div>
                        <div class="text-xs text-slate-400">Tatkal Success Rate</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Live PNR</div>
                        <div class="text-xs text-slate-400">WhatsApp Alerts</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Vande Bharat</div>
                        <div class="text-xs text-slate-400">Priority Quotas</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">IRCTC</div>
                        <div class="text-xs text-slate-400">Authorized Agent</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Section: Form & Premium Trains -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Form -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-600">Avoid Waitlists & Regret</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Book Train Tickets with Expert Help</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        Tatkal Desk Active
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

                <form action="{{ route('services.trains.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Origin Station / City *</label>
                            <div class="relative">
                                <input type="text" name="from_station" required value="{{ old('from_station') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm"
                                       placeholder="e.g. New Delhi (NDLS) / Mumbai">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Destination Station / City *</label>
                            <div class="relative">
                                <input type="text" name="to_station" required value="{{ old('to_station') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm"
                                       placeholder="e.g. Varanasi (BSB) / Goa (MAO)">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Journey Date *</label>
                            <div class="relative">
                                <input type="date" name="journey_date" required min="{{ date('Y-m-d') }}" value="{{ old('journey_date', date('Y-m-d', strtotime('+5 days'))) }}"
                                       class="w-full pl-9 pr-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Class *</label>
                            <select name="class_type" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm bg-white">
                                <option value="Vande Bharat (Executive / CC)" {{ old('class_type') == 'Vande Bharat (Executive / CC)' ? 'selected' : '' }}>Vande Bharat (EC/CC)</option>
                                <option value="1st AC (1A)" {{ old('class_type') == '1st AC (1A)' ? 'selected' : '' }}>1st AC (1A)</option>
                                <option value="2nd AC (2A)" {{ old('class_type') == '2nd AC (2A)' ? 'selected' : '' }}>2nd AC (2A)</option>
                                <option value="3rd AC (3A / 3E)" {{ old('class_type', '3rd AC (3A / 3E)') == '3rd AC (3A / 3E)' ? 'selected' : '' }}>3rd AC (3A / 3E)</option>
                                <option value="Sleeper (SL)" {{ old('class_type') == 'Sleeper (SL)' ? 'selected' : '' }}>Sleeper (SL)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Passengers *</label>
                            <select name="passenger_count" required class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm bg-white">
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('passenger_count', 1) == $i ? 'selected' : '' }}>{{ $i }} Person{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Name *</label>
                            <input type="text" name="contact_name" required value="{{ old('contact_name', Auth::user()?->name) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm"
                                   placeholder="Full Name">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm"
                                   placeholder="+91 98765 43210">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Berth / Tatkal / Meal Preferences</label>
                        <textarea name="remarks" rows="2"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm"
                                  placeholder="Mention Tatkal request, Senior Citizen Lower Berth, Side Lower, Veg / Non-Veg meal, or specific train number (e.g. 12004 Vande Bharat)...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-rose-600 to-red-700 hover:from-rose-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                            Check Availability & Tatkal Slots
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-rose-600"></i>
                            Official IRCTC Partner Network
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Iconic Indian Trains -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-rose-600"></i>
                            Premium Indian Train Corridors
                        </h3>
                        <span class="text-xs text-slate-500">Fast Express</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 hover:bg-rose-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Vande Bharat Express
                                    <span class="text-[10px] bg-rose-100 text-rose-800 font-bold px-1.5 py-0.5 rounded">160 km/h</span>
                                </div>
                                <div class="text-xs text-slate-500">Delhi-Varanasi • Mumbai-Goa • Delhi-Katra</div>
                            </div>
                            <span class="text-xs font-bold text-rose-700">Executive CC</span>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-rose-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Rajdhani & Tejas Express
                                    <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-1.5 py-0.5 rounded">All-AC</span>
                                </div>
                                <div class="text-xs text-slate-500">Delhi-Mumbai • Delhi-Kolkata • Complimentary Meals</div>
                            </div>
                            <span class="text-xs font-bold text-blue-700">1A / 2A / 3A</span>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-rose-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Palace on Wheels
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded">Royal Heritage</span>
                                </div>
                                <div class="text-xs text-slate-500">Rajasthan Circuit • Luxury Dining & Suites</div>
                            </div>
                            <span class="text-xs font-bold text-amber-700">Luxury Charter</span>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-rose-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    UNESCO Heritage Toy Trains
                                    <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-1.5 py-0.5 rounded">Scenic</span>
                                </div>
                                <div class="text-xs text-slate-500">Kalka-Shimla • Darjeeling Himalayan Railway</div>
                            </div>
                            <span class="text-xs font-bold text-emerald-700">Glass Dome</span>
                        </div>
                    </div>
                </div>

                <!-- Callout -->
                <div class="bg-gradient-to-br from-rose-950 to-slate-950 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="zap" class="w-6 h-6 text-amber-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Urgent Tatkal Booking?</h4>
                            <p class="text-xs text-rose-200 mb-3">AC Tatkal opens at 10:00 AM & Sleeper Tatkal opens at 11:00 AM. Register with us 1 hour prior for guaranteed processing.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-amber-200">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                Rail Helpline: +91 11 4567 8900 (Ext. 6)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
