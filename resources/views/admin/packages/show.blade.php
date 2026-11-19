@extends('layouts.admin')

@section('title', 'Package Console: ' . $package->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.packages.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900">&larr; Back to Packages</a>
                <span class="text-slate-300">•</span>
                <span class="text-xs font-bold text-amber-600 uppercase">#{{ $package->package_code }}</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-500">{{ $package->destination?->name }}</span>
            </div>
            <h1 class="text-2xl font-bold font-serif text-slate-900">{{ $package->title }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                {{ $package->duration_days }} Days / {{ $package->duration_nights }} Nights
                &bull; Adult: <span class="font-bold text-slate-900">₹{{ number_format($package->discount_price ?: $package->adult_price, 2) }}</span>
                &bull; Child: <span class="text-slate-700">₹{{ number_format($package->child_price, 2) }}</span>
                &bull; Bookings: <span class="font-bold text-teal-700">{{ $package->bookings->count() }} Pax Trips</span>
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('packages.show', $package->slug) }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Live Preview
            </a>
            <a href="{{ route('admin.packages.edit', $package->id) }}" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit Package
            </a>
            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($package->title) }}\'?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Main 2-Column Console Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Day-wise Itineraries & Departures -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Day-Wise Itineraries List -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-500"></i>
                    Day-by-Day Tour Itinerary ({{ $package->itineraries->count() }} Days Configured)
                </h3>

                <div class="space-y-4 text-xs">
                    @forelse($package->itineraries->sortBy('day_number') as $day)
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-slate-950">
                                        Day {{ $day->day_number }}
                                    </span>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $day->title }}</h4>
                                </div>
                            </div>
                            <p class="text-slate-600 leading-relaxed mt-1">{{ $day->description }}</p>
                            <div class="mt-3 pt-2 border-t border-slate-200/60 flex flex-wrap gap-4 text-[11px] text-slate-500">
                                @if($day->hotel_info)
                                    <span><i data-lucide="bed" class="w-3 h-3 inline mr-1 text-slate-400"></i>Stay: <strong>{{ $day->hotel_info }}</strong></span>
                                @endif
                                @if($day->meals_info)
                                    <span><i data-lucide="utensils" class="w-3 h-3 inline mr-1 text-slate-400"></i>Meals: <strong>{{ $day->meals_info }}</strong></span>
                                @endif
                                @if($day->transport_info)
                                    <span><i data-lucide="car" class="w-3 h-3 inline mr-1 text-slate-400"></i>Transport: <strong>{{ $day->transport_info }}</strong></span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 py-4 text-center">No day itineraries added yet. Use the form on the right to add Day 1, Day 2, etc.</p>
                    @endforelse
                </div>
            </div>

            <!-- Group Departure Schedules Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-teal-600"></i> Fixed Departure Schedules ({{ $package->departures->count() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-6">Departure Date</th>
                                <th class="py-3 px-6">Return Date</th>
                                <th class="py-3 px-6 text-center">Total Seats</th>
                                <th class="py-3 px-6 text-center">Available</th>
                                <th class="py-3 px-6">Price</th>
                                <th class="py-3 px-6">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($package->departures as $dep)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-6 font-bold text-slate-900">{{ \Carbon\Carbon::parse($dep->departure_date)->format('D, M d, Y') }}</td>
                                    <td class="py-3 px-6">{{ \Carbon\Carbon::parse($dep->return_date)->format('D, M d, Y') }}</td>
                                    <td class="py-3 px-6 text-center font-semibold">{{ $dep->total_seats }}</td>
                                    <td class="py-3 px-6 text-center font-bold text-emerald-700">{{ $dep->available_seats }}</td>
                                    <td class="py-3 px-6 font-semibold">{{ $dep->price_override ? '₹' . number_format($dep->price_override) : 'Standard' }}</td>
                                    <td class="py-3 px-6">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">{{ $dep->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-slate-400">
                                        No fixed group departure dates scheduled.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Col: Add Itinerary Day & Add Departure Forms -->
        <div class="space-y-6">
            <!-- Add Itinerary Day Form -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs text-xs">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-amber-500"></i> Add Itinerary Day
                </h3>
                <form action="{{ route('admin.packages.itineraries.store', $package->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Day # *</label>
                            <input type="number" name="day_number" min="1" required value="{{ $package->itineraries->count() + 1 }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>
                        <div class="col-span-2">
                            <label class="block font-semibold text-slate-700 mb-1">Day Title *</label>
                            <input type="text" name="title" required placeholder="e.g. Arrival in Srinagar" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Detailed Itinerary Description *</label>
                        <textarea name="description" rows="3" required placeholder="Describe morning sightseeing, afternoon tour, transfers..." class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Hotel Stay</label>
                        <input type="text" name="hotel_info" placeholder="e.g. Deluxe Houseboat, Dal Lake" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Meals Plan</label>
                            <input type="text" name="meals_info" placeholder="e.g. Dinner" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Transport</label>
                            <input type="text" name="transport_info" placeholder="e.g. Private Sedan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl text-xs transition">
                        Add Day Itinerary
                    </button>
                </form>
            </div>

            <!-- Add Fixed Departure Date Form -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs text-xs">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="calendar-plus" class="w-4 h-4 text-teal-600"></i> Add Departure Schedule
                </h3>
                <form action="{{ route('admin.packages.departures.store', $package->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Departure Date *</label>
                        <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Return Date *</label>
                        <input type="date" name="return_date" required min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Total Seats *</label>
                            <input type="number" name="total_seats" value="30" min="1" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Available Seats *</label>
                            <input type="number" name="available_seats" value="30" min="0" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Price Override (Optional)</label>
                        <input type="number" step="0.01" name="price_override" placeholder="Leave empty for standard MRP" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-black text-white font-bold rounded-xl text-xs transition">
                        Schedule Group Departure
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

