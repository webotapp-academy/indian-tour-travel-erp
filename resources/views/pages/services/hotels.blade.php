@extends('layouts.app')

@section('title', 'Luxury Hotel & Resort Reservations - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-purple-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#a855f7_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="crown" class="w-4 h-4 text-amber-400"></i>
                Direct Contracted B2B Hotel Rates
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Luxury Stays, Heritage Havelis & Beach Resorts
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Enjoy complimentary buffet breakfast, guaranteed early check-in, room category upgrades, and wholesale contracted tariffs on 50,000+ handpicked hotels across India & worldwide.
            </p>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                        <i data-lucide="hotel" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">50,000+</div>
                        <div class="text-xs text-slate-400">Verified Hotels</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="coffee" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Free CP</div>
                        <div class="text-xs text-slate-400">Buffet Breakfast</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Free Upgrade</div>
                        <div class="text-xs text-slate-400">On Availability</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">Wholesale</div>
                        <div class="text-xs text-slate-400">Save Up To 40%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Section: Form & Featured Stays -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Form -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Contracted Wholesale Inventory</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Book Your Preferred Hotel Stay</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                        <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                        Special Tariffs Active
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

                <form action="{{ route('services.hotels.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Destination City / Location *</label>
                            <div class="relative">
                                <input type="text" name="city" required value="{{ old('city') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                                       placeholder="e.g. Goa, Udaipur, Srinagar, Dubai">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Specific Hotel Name (Optional)</label>
                            <div class="relative">
                                <input type="text" name="hotel_name" value="{{ old('hotel_name') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                                       placeholder="e.g. Taj Lake Palace, W Goa, Atlantis">
                                <i data-lucide="building" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Check-in Date *</label>
                            <div class="relative">
                                <input type="date" name="check_in_date" required min="{{ date('Y-m-d') }}" value="{{ old('check_in_date', date('Y-m-d', strtotime('+7 days'))) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Check-out Date *</label>
                            <div class="relative">
                                <input type="date" name="check_out_date" required min="{{ date('Y-m-d') }}" value="{{ old('check_out_date', date('Y-m-d', strtotime('+10 days'))) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Rooms *</label>
                            <select name="rooms_count" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm bg-white">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('rooms_count', 1) == $i ? 'selected' : '' }}>{{ $i }} Room{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Adults *</label>
                            <select name="adults" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm bg-white">
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ old('adults', 2) == $i ? 'selected' : '' }}>{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Children</label>
                            <select name="children" class="w-full px-3 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm bg-white">
                                @for($i = 0; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('children', 0) == $i ? 'selected' : '' }}>{{ $i }} Child</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Room Category</label>
                            <select name="room_type" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm bg-white">
                                <option value="Deluxe Room" {{ old('room_type') == 'Deluxe Room' ? 'selected' : '' }}>Deluxe Room</option>
                                <option value="Executive Suite" {{ old('room_type') == 'Executive Suite' ? 'selected' : '' }}>Executive Suite</option>
                                <option value="Heritage Villa / Haveli" {{ old('room_type') == 'Heritage Villa / Haveli' ? 'selected' : '' }}>Heritage Villa / Haveli</option>
                                <option value="Private Pool Villa" {{ old('room_type') == 'Private Pool Villa' ? 'selected' : '' }}>Private Pool Villa</option>
                                <option value="Standard Budget Room" {{ old('room_type') == 'Standard Budget Room' ? 'selected' : '' }}>Standard Budget Room</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meal Plan Preference</label>
                            <select name="meal_plan" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm bg-white">
                                <option value="CP (Breakfast Included)" {{ old('meal_plan') == 'CP (Breakfast Included)' ? 'selected' : '' }}>CP - Free Buffet Breakfast</option>
                                <option value="MAP (Breakfast + Dinner)" {{ old('meal_plan') == 'MAP (Breakfast + Dinner)' ? 'selected' : '' }}>MAP - Breakfast + Dinner (Recommended)</option>
                                <option value="AP (All Meals Included)" {{ old('meal_plan') == 'AP (All Meals Included)' ? 'selected' : '' }}>AP - All 3 Meals Included</option>
                                <option value="EP (Room Only)" {{ old('meal_plan') == 'EP (Room Only)' ? 'selected' : '' }}>EP - Room Only (No Meals)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                            <input type="text" name="contact_name" required value="{{ old('contact_name', Auth::user()?->name) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                                   placeholder="Primary Guest">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                                   placeholder="+91 98765 43210">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <input type="email" name="contact_email" required value="{{ old('contact_email', Auth::user()?->email) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                                   placeholder="you@email.com">
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                            Lock In Wholesale Hotel Rate
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-purple-600"></i>
                            Free Cancellation on Flexi Bookings
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Curated Stays -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-purple-600"></i>
                            Handpicked Luxury Escapes
                        </h3>
                        <span class="text-xs text-slate-500">Contracted</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 hover:bg-purple-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Taj Exotica Resort & Spa, Goa
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded">5★ Luxury</span>
                                </div>
                                <div class="text-xs text-slate-500">Benaulim Beach • Private Pool Villa • Spa</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-purple-900">₹14,500</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Free Breakfast</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-purple-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    The Oberoi Udaivilas, Udaipur
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded">5★ Heritage</span>
                                </div>
                                <div class="text-xs text-slate-500">Lake Pichola • Royal Butler Service</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-purple-900">₹26,999</div>
                                <span class="text-[10px] text-purple-600 font-semibold">Special B2B</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-purple-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Solang Valley Chalet, Manali
                                    <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-1.5 py-0.5 rounded">4★ Alpine</span>
                                </div>
                                <div class="text-xs text-slate-500">Snow Mountain Balcony • Bonfire Nights</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-purple-900">₹4,999</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Save 35%</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-purple-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    Kumarakom Lake Resort, Kerala
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded">5★ Backwater</span>
                                </div>
                                <div class="text-xs text-slate-500">Heritage Villas • Private Houseboat Stays</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-purple-900">₹11,200</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Ayurveda Inc.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotel Desk Banner -->
                <div class="bg-gradient-to-br from-purple-900 to-slate-900 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="crown" class="w-6 h-6 text-amber-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Corporate & Destination Weddings</h4>
                            <p class="text-xs text-purple-200 mb-3">Booking 10+ rooms? Our MICE & luxury events desk negotiates direct palace & banquet block rates with banqueting perks.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-amber-200">
                                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                                Luxury Desk: +91 11 4567 8900 (Ext. 5)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
