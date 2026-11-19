@extends('layouts.app')

@section('title', $blog->title . ' - BharatTravel Journal')

@section('content')
<article class="bg-white">
    <!-- Header Hero -->
    <header class="relative bg-slate-900 text-white py-20">
        <div class="absolute inset-0 opacity-30">
            <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-white uppercase tracking-wider mb-4">
                {{ $blog->category ?? 'Destination Intel' }}
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-serif leading-tight mb-4">
                {{ $blog->title }}
            </h1>
            <div class="flex items-center justify-center gap-4 text-xs sm:text-sm text-slate-300">
                <span>By {{ $blog->author_name ?? 'BharatTravel Editors' }}</span>
                <span>•</span>
                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') : 'Recent' }}</span>
                <span>•</span>
                <span>5 min read</span>
            </div>
        </div>
    </header>

    <!-- Content Body -->
    <div class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Body -->
                <div class="lg:col-span-2 bg-white p-8 sm:p-12 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-lg text-slate-700 font-medium leading-relaxed mb-8 pb-6 border-b border-slate-100">
                        {{ $blog->summary }}
                    </p>

                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 [&>h3]:text-2xl [&>h3]:font-serif [&>h3]:font-bold [&>h3]:text-slate-900 [&>h3]:pt-4 [&>h3]:pb-1 [&>p]:leading-relaxed [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:space-y-2 [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:space-y-2">
                        {!! $blog->content !!}
                    </div>

                    <!-- Author Box -->
                    <div class="mt-12 pt-8 border-t border-slate-200 flex items-center gap-4">
                        <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-xl">
                            <i data-lucide="feather" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $blog->author_name ?? 'BharatTravel Travel Desk' }}</h4>
                            <p class="text-xs text-slate-500">Destination Researcher & Itinerary Specialist</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- CTA Card -->
                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-8 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-bold font-serif mb-2">Inspired by this story?</h3>
                        <p class="text-amber-100 text-sm mb-6">Let our holiday specialists build a tailored itinerary around these exact destinations.</p>
                        <a href="{{ route('services.custom_tour') }}" class="block w-full py-3 bg-white text-slate-900 hover:bg-slate-100 font-bold text-center rounded-xl text-sm shadow">
                            Customize This Trip
                        </a>
                    </div>

                    <!-- Recent Articles -->
                    @if(isset($recentBlogs) && $recentBlogs->count() > 0)
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="font-bold text-slate-900 text-base mb-4 pb-2 border-b border-slate-100">More Travel Stories</h4>
                            <div class="space-y-4">
                                @foreach($recentBlogs as $recent)
                                    <div class="flex gap-3 items-center">
                                        <img src="{{ $recent->featured_image }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                                        <div>
                                            <p class="text-[11px] text-slate-400 font-semibold">{{ $recent->category }}</p>
                                            <a href="{{ route('blogs.show', $recent->slug) }}" class="text-xs font-bold text-slate-800 hover:text-amber-600 line-clamp-2">
                                                {{ $recent->title }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</article>
@endsection

