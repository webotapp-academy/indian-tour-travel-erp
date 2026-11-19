@extends('layouts.app')

@section('title', 'Passport Seva Kendra (PSK) Assistance - BharatTravel')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 uppercase tracking-widest mb-5 backdrop-blur-sm">
                <i data-lucide="book-open" class="w-4 h-4 text-amber-400"></i>
                Official Passport Seva Portal Concierge
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight leading-tight mb-5">
                Indian Passport Services Made Effortless
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8">
                Guaranteed appointment booking at your nearest PSK/POPSK center, Annexure preparation, Non-ECR status verification, and Tatkal express dispatch in 3-5 days.
            </p>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-left max-w-4xl mx-auto pt-6 border-t border-slate-800/80">
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i data-lucide="zap" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">48 Hours</div>
                        <div class="text-xs text-slate-400">PSK Slot Guaranteed</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">100%</div>
                        <div class="text-xs text-slate-400">Pre-Verified Docs</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                        <i data-lucide="flame" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">3-5 Days</div>
                        <div class="text-xs text-slate-400">Tatkal Fast-Track</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl p-3.5 backdrop-blur-sm">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-white">45,000+</div>
                        <div class="text-xs text-slate-400">Passports Issued</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Section: Form & Service Options -->
<section class="py-16 bg-slate-50 relative -mt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 7 Cols: Form -->
            <div class="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">PSK Slot Booking & Verification</span>
                        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 mt-1">Request Passport Appointment</h2>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Tatkal Slots Open
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

                <form action="{{ route('services.passport.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Service Category *</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                                <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex flex-col items-center text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition-all [&:has(:checked)]:border-indigo-600 [&:has(:checked)]:bg-indigo-50">
                                    <input type="radio" name="service_type" value="fresh" {{ old('service_type', 'fresh') == 'fresh' ? 'checked' : '' }} class="sr-only">
                                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600 mb-1"></i>
                                    <span class="text-xs font-bold text-slate-800">Fresh Passport</span>
                                    <span class="text-[10px] text-slate-500">First Time</span>
                                </label>

                                <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex flex-col items-center text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition-all [&:has(:checked)]:border-indigo-600 [&:has(:checked)]:bg-indigo-50">
                                    <input type="radio" name="service_type" value="renewal" {{ old('service_type') == 'renewal' ? 'checked' : '' }} class="sr-only">
                                    <i data-lucide="refresh-cw" class="w-5 h-5 text-indigo-600 mb-1"></i>
                                    <span class="text-xs font-bold text-slate-800">Renewal / Expired</span>
                                    <span class="text-[10px] text-slate-500">Validity Over</span>
                                </label>

                                <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex flex-col items-center text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition-all [&:has(:checked)]:border-indigo-600 [&:has(:checked)]:bg-indigo-50">
                                    <input type="radio" name="service_type" value="reissue" {{ old('service_type') == 'reissue' ? 'checked' : '' }} class="sr-only">
                                    <i data-lucide="file-edit" class="w-5 h-5 text-indigo-600 mb-1"></i>
                                    <span class="text-xs font-bold text-slate-800">Reissue / Changes</span>
                                    <span class="text-[10px] text-slate-500">Name/Address</span>
                                </label>

                                <label class="cursor-pointer border border-rose-200 bg-rose-50/20 rounded-xl p-3 flex flex-col items-center text-center hover:border-rose-500 hover:bg-rose-50/40 transition-all [&:has(:checked)]:border-rose-600 [&:has(:checked)]:bg-rose-50">
                                    <input type="radio" name="service_type" value="tatkal" {{ old('service_type') == 'tatkal' ? 'checked' : '' }} class="sr-only">
                                    <i data-lucide="zap" class="w-5 h-5 text-rose-600 mb-1"></i>
                                    <span class="text-xs font-bold text-rose-900">Tatkal Express</span>
                                    <span class="text-[10px] text-rose-600 font-semibold">3-5 Days</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Applicant Full Name *</label>
                            <div class="relative">
                                <input type="text" name="applicant_name" required value="{{ old('applicant_name', Auth::user()?->name) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                       placeholder="As on Aadhaar / Birth Proof">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Place of Birth (City / State)</label>
                            <div class="relative">
                                <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                       placeholder="e.g. New Delhi, Delhi">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile *</label>
                            <div class="relative">
                                <input type="tel" name="contact_phone" required value="{{ old('contact_phone', Auth::user()?->phone) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                       placeholder="+91 98765 43210">
                                <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <div class="relative">
                                <input type="email" name="contact_email" required value="{{ old('contact_email', Auth::user()?->email) }}"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                       placeholder="you@email.com">
                                <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Preferred PSK City / Special Remarks</label>
                        <textarea name="remarks" rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                                  placeholder="Mention preferred PSK/POPSK center, marital status change, minor child application, or urgent departure dates...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-blue-700 hover:from-indigo-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                            Request PSK Assistance
                        </button>
                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                            Govt Approved PSK Guidance
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right 5 Cols: Service Matrix & Info -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-indigo-600"></i>
                        Passport Service Plans
                    </h3>

                    <div class="space-y-3">
                        <div class="p-3.5 bg-indigo-50/50 rounded-2xl border border-indigo-100 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-indigo-950 text-sm">Fresh Passport (36 / 60 Pgs)</div>
                                <div class="text-xs text-indigo-700">10-Year Adult Validity • Normal Slot</div>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-800">15-20 Days</span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Renewal & Re-Issue</div>
                                <div class="text-xs text-slate-500">Pages Exhausted or Expired</div>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-slate-200 text-slate-700">10-14 Days</span>
                        </div>

                        <div class="p-3.5 bg-rose-50/60 rounded-2xl border border-rose-200 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-rose-950 text-sm">Tatkal Fast-Track Scheme</div>
                                <div class="text-xs text-rose-700">Priority Dispatch & Police Verif. Post-Dispatch</div>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-rose-100 text-rose-800">3-5 Days</span>
                        </div>

                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Police Clearance Cert. (PCC)</div>
                                <div class="text-xs text-slate-500">For Employment & Immigration Abroad</div>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800">7-10 Days</span>
                        </div>
                    </div>
                </div>

                <!-- Callout -->
                <div class="bg-gradient-to-br from-indigo-900 to-slate-900 p-6 rounded-3xl text-white shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                            <i data-lucide="check-check" class="w-6 h-6 text-emerald-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-1">Zero Rejection Scrutiny</h4>
                            <p class="text-xs text-indigo-200 mb-3">Our PSK paralegal verifies your name spellings across Aadhaar, PAN, and 10th Marks Sheet before filing.</p>
                            <div class="text-xs text-amber-300 font-semibold flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                                PSK Desk: +91 11 4567 8900 (Ext. 3)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Required Documents Matrix -->
<section class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Documentation Guide</span>
            <h2 class="text-3xl font-serif font-bold text-slate-900 mt-1">What to Bring to the PSK Counter</h2>
            <p class="text-slate-600 text-sm mt-2">Original documents along with two sets of self-attested photocopies.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                    <i data-lucide="home" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-3">Proof of Present Address (Any 1)</h4>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-indigo-500"></i> Aadhaar Card with current address</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-indigo-500"></i> Active Bank Passbook (Scheduled Bank)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-indigo-500"></i> Electricity / Water / Gas Bill (Past 2 mos)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-indigo-500"></i> Registered Rent Agreement</li>
                </ul>
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-3">Proof of Date of Birth (Any 1)</h4>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Birth Certificate (Municipal Corp)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> 10th Standard School Leaving / Board Cert.</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> PAN Card (issued by Income Tax Dept)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500"></i> Driving License</li>
                </ul>
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                    <i data-lucide="shield-alert" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base mb-3">Non-ECR (Emigration Check Not Req.)</h4>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-amber-500"></i> 10th Standard Pass Certificate or higher</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-amber-500"></i> Income Tax Payers (ITR acknowledgment)</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-amber-500"></i> Persons holding professional degrees</li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-amber-500"></i> Spouses and children of Non-ECR holders</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
