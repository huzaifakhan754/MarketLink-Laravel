@extends('admin.sidebar')

@section('content')
<div class="p-6 md:p-8 max-w-7xl  space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <h1 class="text-xl font-bold text-[#1b4d3e] tracking-tight">Farmers Directory</h1>
            <p class="text-xs font-medium text-gray-500 mt-0.5">Manage farmer profiles and platform active status.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-[#1b4d3e] bg-[#1b4d3e]/10 px-3 py-1.5 rounded-lg border border-[#1b4d3e]/20">
                Total Farmers: <strong class="text-[#1b4d3e] font-bold">{{ $farmers->total() }}</strong>
            </span>
        </div>
    </div>

    <!-- Alert Message -->
    @if(session('success'))
    <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-900 text-xs font-medium flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-xs font-bold">✕</button>
    </div>
    @endif

    <!-- Main Table Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200 text-[11px] font-bold uppercase tracking-wider text-[#1b4d3e]">
                        <th class="py-3.5 px-5">Farmer & Email</th>
                        <th class="py-3.5 px-5">Assigned Market</th>
                        <th class="py-3.5 px-5">Location</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium">
                    @forelse($farmers as $farmer)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <!-- Farmer Info -->
                        <td class="py-3.5 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#1b4d3e]/10 text-[#1b4d3e] font-bold flex items-center justify-center shrink-0 border border-[#1b4d3e]/20 overflow-hidden text-xs">
                                    @if($farmer->image)
                                    <img src="{{ asset('storage/' . $farmer->image) }}" class="w-full h-full object-cover">
                                    @else
                                    {{ strtoupper(substr($farmer->farm_name ?? 'F', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-xs">{{ $farmer->farm_name }}</div>
                                    <div class="text-[11px] text-gray-400 font-normal">{{ $farmer->user->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Market -->
                        <td class="py-3.5 px-5">
                            @if($farmer->market)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-[#1b4d3e] text-[11px] font-semibold rounded-md border border-gray-200/80">
                                <i class="fa-solid fa-store text-[10px] text-[#1b4d3e]"></i>
                                {{ $farmer->market->name }}
                            </span>
                            @else
                            <span class="text-[11px] text-gray-400 italic">No market assigned</span>
                            @endif
                        </td>

                        <!-- Location -->
                        <td class="py-3.5 px-5 text-gray-600 text-xs">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-[#1b4d3e] text-[11px]"></i>
                                {{ Str::limit($farmer->location ?? 'N/A', 30) }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3.5 px-5">
                            @if($farmer->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Suspended
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-5">
                            <div class="flex items-center justify-start gap-2">

                                <!-- View Profile -->
                                <a href="{{ route('admin.farmers.show', $farmer->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5
                  bg-[#1b4d3e] hover:bg-[#143b2f]
                  text-white rounded-lg text-[11px] font-semibold
                  transition shadow-sm">

                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                    View Profile
                                </a>


                                <!-- Toggle Status -->
                                <form action="{{ route('admin.farmers.toggle-status', $farmer->id) }}"
                                    method="POST"
                                    class="inline-block">

                                    @csrf
                                    @method('PATCH')

                                    @if($farmer->status === 'active')

                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to suspend this farmer?')"
                                        class="px-3 py-1.5
                               bg-white hover:bg-rose-50
                               text-rose-600
                               border border-rose-200
                               hover:border-rose-300
                               rounded-lg text-[11px] font-semibold
                               transition">

                                        Suspend

                                    </button>

                                    @else

                                    <button type="submit"
                                        class="px-3 py-1.5
                               bg-white hover:bg-emerald-50
                               text-emerald-700
                               border border-emerald-200
                               rounded-lg text-[11px] font-semibold
                               transition">

                                        Activate

                                    </button>

                                    @endif

                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 font-medium text-xs">
                            No farmers registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($farmers->hasPages())
        <div class="p-3 border-t border-gray-100 bg-gray-50/50">
            {{ $farmers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection