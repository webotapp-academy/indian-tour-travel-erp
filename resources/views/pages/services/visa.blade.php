@extends('layouts.app')

@section('title', 'Global Visa Assistance for Indian Travellers - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-blue-500/15 text-blue-300 border border-blue-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                Authorized Global Visa Facilitation
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Stress-Free Visa Processing for Indian Travellers
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                From Dubai 24h e-Visas and Schengen appointments to US B1/B2 interview preparation. Enjoy full document scrutiny, cover letter drafting, and 99.4% approval track record.
            </p>

            <!-- Quick Trust Badges -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">99.4%</div>
                        <div class="text-xs text-slate-400">Approval Rate</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">120+</div>
                        <div class="text-xs text-slate-400">Countries Covered</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">24-48h</div>
                        <div class="text-xs text-slate-400">Express eVisas</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">1.2 Lakh+</div>
                        <div class="text-xs text-slate-400">Happy Travellers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Interactive Section: Form + Popular Visas -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Application Form Card -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Apply Online in 2 Minutes</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Visa Application & Consultation</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Consulate Desks Open
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

                <form action="{{ route('services.visa.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Destination Country *</label>
                            <div class="relative">
                                <select name="country_id" required class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                                    <option value="">Select Target Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }} ({{ $country->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Visa Category *</label>
                            <div class="relative">
                                <select name="visa_category" required class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                                    <option value="Tourist" {{ old('visa_category') == 'Tourist' ? 'selected' : '' }}>Tourist / Visitor Visa</option>
                                    <option value="Business" {{ old('visa_category') == 'Business' ? 'selected' : '' }}>Business Visa / Conference</option>
                                    <option value="Transit" {{ old('visa_category') == 'Transit' ? 'selected' : '' }}>Transit Visa</option>
                                    <option value="Student" {{ old('visa_category') == 'Student' ? 'selected' : '' }}>Student / Educational</option>
                                </select>
                                <i data-lucide="tag" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Applicant Full Name *</label>
                            <div class="relative">
                                <input type="text" name="applicant_name" required value="{{ old('applicant_name', Auth::user()?->name) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                       placeholder="As per Passport">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Passport Number</label>
                            <div class="relative">
                                <input type="text" name="passport_number" value="{{ old('passport_number') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm uppercase"
                                       placeholder="e.g. Z1234567">
                                <i data-lucide="file-text" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <div class="relative">
                                <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                       placeholder="+91 98765 43210">
                                <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <div class="relative">
                                <input type="email" name="contact_email" required value="{{ old('contact_email', Auth::user()?->email) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                       placeholder="you@email.com">
                                <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tentative Travel Date</label>
                            <div class="relative">
                                <input type="date" name="travel_date" value="{{ old('travel_date') }}" min="{{ date('Y-m-d') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Special Notes or Questions</label>
                        <textarea name="remarks" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                  placeholder="Mention number of applicants, previous visa rejections, urgent flight dates, or appointment preferences...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                            Submit Visa Request
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i>
                            256-Bit SSL Encrypted & Confidential
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Popular Visas & Concierge Card -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Popular Visa Cards -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                            Trending Indian Visas
                        </h3>
                        <span class="text-xs text-slate-500">Fast-Track</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-slate-50 hover:bg-blue-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🇦🇪</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Dubai (UAE) 30/60 Days</div>
                                    <div class="text-xs text-slate-500">eVisa • Express 24-48 Hours</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹6,899</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">99.8% Pass</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-blue-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🇪🇺</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Schengen Europe Tourist</div>
                                    <div class="text-xs text-slate-500">France, Swiss, Italy • 15 Days</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹9,499</div>
                                <span class="text-[10px] text-blue-600 font-semibold">VFS Slot Assist</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-blue-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🇸🇬</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Singapore e-Visa</div>
                                    <div class="text-xs text-slate-500">Multiple Entry • 3-4 Days</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹2,850</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Instant Approval</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-blue-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🇹🇭</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Thailand Tourist Visa</div>
                                    <div class="text-xs text-slate-500">Visa on Arrival / eVisa</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹2,499</div>
                                <span class="text-[10px] text-emerald-600 font-semibold">Zero Rejections</span>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 hover:bg-blue-50/50 rounded-2xl border border-slate-100 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🇺🇸</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">USA B1/B2 Visitor Visa</div>
                                    <div class="text-xs text-slate-500">10-Year Multiple • DS-160 Prep</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900">₹14,999</div>
                                <span class="text-[10px] text-purple-600 font-semibold">Mock Interview</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 24/7 Helpline Card -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="headphones" class="w-6 h-6 text-amber-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Need Urgent Visa Guidance?</h4>
                            <p class="text-xs text-blue-200 mb-3">Speak directly with our senior consular advisors for document eligibility checks.</p>
                            <a href="tel:+911145678900" class="inline-flex items-center gap-2 text-sm font-bold text-amber-300 hover:text-amber-200">
                                <i data-lucide="phone-call" class="w-4 h-4"></i>
                                +91 11 4567 8900 (Ext. 2)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 4-Step Seamless Journey -->
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Simple & Transparent</span>
            <h2 class="text-3xl font-serif font-bold text-slate-900 mt-1">How Our Visa Concierge Works</h2>
            <p class="text-slate-600 text-sm mt-2">No complicated consulate forms. We do the heavy lifting from start to finish.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <div class="relative bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white font-bold text-lg flex items-center justify-center mb-4">1</div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Submit Profile</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Fill the online inquiry form with travel dates and target country.</p>
            </div>

            <div class="relative bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white font-bold text-lg flex items-center justify-center mb-4">2</div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Document Audit</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Our officer verifies bank statements, ITR, employment proofs, and dummy itinerary.</p>
            </div>

            <div class="relative bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white font-bold text-lg flex items-center justify-center mb-4">3</div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Slot & Biometrics</h4>
                <p class="text-xs text-slate-600 leading-relaxed">We schedule the earliest appointment slot at VFS/BLS or file online e-Visas.</p>
            </div>

            <div class="relative bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white font-bold text-lg flex items-center justify-center mb-4">4</div>
                <h4 class="font-bold text-slate-900 text-base mb-2">Passport Dispatched</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Receive your visa stamp or electronic eVisa PDF directly in your email.</p>
            </div>
        </div>
    </div>
</section>

<!-- Required Documents Matrix -->
<section class="py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-serif font-bold text-slate-900">Standard Visa Checklist</h2>
            <p class="text-slate-600 text-sm mt-2">Keep these core documents ready for swift submission.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-3">Salaried Professionals</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Original Passport valid for 6+ months</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Last 3 months Salary Slips</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> 6 months Bank Statement with seal</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Form 16 / ITR of past 2 years</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Approved Leave Letter (NOC) from HR</li>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-3">Business Owners & Self-Employed</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> GST Registration / Incorporation Certificate</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Current Account Statement (6 months)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Company ITR with computation (2 years)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Personal Savings Statement & ITR</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Company Letterhead for Cover Letter</li>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-3">Students & Senior Citizens</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> School/College ID card & Leave NOC</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Financial Sponsorship Letter from Parents</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Retirement Proof / Pension Order (for seniors)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Fixed Deposit Certificates / Property Deeds</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> 2 Recent Photos (35x45mm, white background)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- FAQs -->
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-serif font-bold text-slate-900 text-center mb-8">Frequently Asked Questions</h2>
        
        <div class="space-y-4" x-data="{ open: null }">
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <button @click="open = open === 1 ? null : 1" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50">
                    <span>What happens if my visa gets rejected?</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform" :class="open === 1 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === 1" x-collapse class="p-5 pt-0 text-slate-600 text-sm border-t border-slate-100">
                    Our pre-audit process ensures your application is filed only when all financial and ties-to-home proofs satisfy consular standards. If a refusal occurs, our legal team assists with appeals or reapplication with missing supporting proofs.
                </div>
            </div>

            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <button @click="open = open === 2 ? null : 2" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50">
                    <span>Do I need to buy actual flight tickets before getting a visa?</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform" :class="open === 2 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === 2" x-collapse class="p-5 pt-0 text-slate-600 text-sm border-t border-slate-100">
                    No! We provide confirmed airline PNR reservation proofs and hotel reservation vouchers specifically accepted by consulates for visa processing, saving you from financial loss.
                </div>
            </div>

            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <button @click="open = open === 3 ? null : 3" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50">
                    <span>Can you help me get an urgent VFS or BLS appointment slot?</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform" :class="open === 3 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === 3" x-collapse class="p-5 pt-0 text-slate-600 text-sm border-t border-slate-100">
                    Yes, our consular operations desk continuously tracks cancellation slots and premium lounge availability to book the fastest appointment dates.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
