@extends('layouts.admin')

@section('title', 'Holiday Packages & Tariffs | BharatTravel')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Holiday Tour Packages Master</h1>
            <p class="text-xs text-slate-500 mt-1">Manage domestic & international itineraries, retail pricing, day-wise itineraries, and group departure dates.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold rounded-xl transition shadow-xs flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Create New Tour Package
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.packages.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs"
                       placeholder="Search title or package code...">
            </div>

            <div>
                <select name="type" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                    <option value="">All Types</option>
                    <option value="domestic" {{ request('type') == 'domestic' ? 'selected' : '' }}>Domestic Tours</option>
                    <option value="international" {{ request('type') == 'international' ? 'selected' : '' }}>International Tours</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-slate-900 hover:bg-black text-white font-bold rounded-xl text-xs transition">
                    Filter
                </button>
                <a href="{{ route('admin.packages.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Package Grid / Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">Package</th>
                        <th class="py-3.5 px-6">Destination</th>
                        <th class="py-3.5 px-6">Duration</th>
                        <th class="py-3.5 px-6">Base Adult Price</th>
                        <th class="py-3.5 px-6 text-center">Bookings</th>
                        <th class="py-3.5 px-6">Type</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($packages as $pkg)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $pkg->featured_image ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=150&q=80' }}"
                                         class="w-12 h-12 rounded-xl object-cover shrink-0 border border-slate-200">
                                    <div>
                                        <a href="{{ route('admin.packages.show', $pkg->id) }}" class="font-bold text-slate-900 hover:text-amber-600 block line-clamp-1">
                                            {{ $pkg->title }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 font-semibold uppercase">{{ $pkg->package_code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $pkg->destination?->name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $pkg->duration_days }}D / {{ $pkg->duration_nights }}N
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900">₹{{ number_format($pkg->discount_price ?: $pkg->adult_price, 2) }}</span>
                                @if($pkg->discount_price)
                                    <span class="line-through text-[10px] text-slate-400 block">₹{{ number_format($pkg->adult_price, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-800">
                                    {{ $pkg->bookings_count }}
                                </span>
                            </td>
                            <td class="py-4 px-6 uppercase text-[10px] font-bold text-slate-500">
                                {{ $pkg->type }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                    {{ $pkg->status == 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($pkg->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.packages.show', $pkg->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-lg transition inline-block">
                                        Console
                                    </a>
                                    <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold rounded-lg transition inline-block">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($pkg->title) }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg transition inline-flex items-center gap-1" title="Delete Package">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                No packages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

