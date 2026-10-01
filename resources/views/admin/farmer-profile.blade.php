@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-7xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.farmers') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[#1b4d3e] hover:text-[#143b2f] transition">

            <i class="fa-solid fa-arrow-left text-xs"></i>

            Back to Farmers

        </a>
    </div>


    <!-- Success Message -->
    @if(session('success'))

        <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl
                    text-emerald-900 text-xs font-medium
                    flex items-center justify-between">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                <span>{{ session('success') }}</span>

            </div>

            <button onclick="this.parentElement.remove()"
                    class="text-emerald-700 hover:text-emerald-900 font-bold">

                ✕

            </button>

        </div>

    @endif


    <!-- ========================================================= -->
    <!-- PROFILE HEADER -->
    <!-- ========================================================= -->

  <!-- ========================================================= -->
<!-- PROFILE HEADER -->
<!-- ========================================================= -->

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

    <!-- Green Header -->
    <div class="h-18 bg-[#1b4d3e] relative">

        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(#fff 1px, transparent 1px);
                    background-size: 18px 18px;">
        </div>

    </div>


    <!-- Profile Information -->
    <div class="px-6 md:px-8 py-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">


            <!-- Farmer -->
            <div class="flex items-center gap-4">

                <!-- Image -->
                <div class="w-20 h-20 rounded-2xl
                            bg-[#1b4d3e]/10
                            border border-gray-200
                            shadow-sm
                            overflow-hidden
                            shrink-0
                            flex items-center justify-center
                            text-[#1b4d3e]
                            text-2xl font-bold">

                    @if($farmer->image)

                        <img src="{{ asset('storage/' . $farmer->image) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $farmer->farm_name }}">

                    @else

                        {{ strtoupper(substr($farmer->farm_name ?? 'F', 0, 1)) }}

                    @endif

                </div>


                <!-- Name -->
                <div>

                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $farmer->farm_name ?? 'Unnamed Farm' }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Farmer Profile
                    </p>

                    @if($farmer->market)

                        <div class="flex items-center gap-1.5 mt-2">

                            <i class="fa-solid fa-store text-[#1b4d3e] text-xs"></i>

                            <span class="text-xs text-gray-500">
                                {{ $farmer->market->name }}
                            </span>

                        </div>

                    @endif

                </div>

            </div>


            <!-- Status -->
            <div>

                @if($farmer->status === 'active')

                    <span class="inline-flex items-center gap-2
                                 px-3 py-1.5 rounded-full
                                 text-xs font-semibold
                                 bg-emerald-50
                                 text-emerald-700
                                 border border-emerald-200">

                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                        Active

                    </span>

                @else

                    <span class="inline-flex items-center gap-2
                                 px-3 py-1.5 rounded-full
                                 text-xs font-semibold
                                 bg-rose-50
                                 text-rose-700
                                 border border-rose-200">

                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>

                        Suspended

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>


    <!-- ========================================================= -->
    <!-- STAT CARDS -->
    <!-- ========================================================= -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">


        <!-- Products -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-gray-500">
                        Total Products
                    </p>

                    <h2 class="text-2xl font-bold text-[#1b4d3e] mt-1">
                        {{ $totalProducts }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-[#1b4d3e]/10
                            text-[#1b4d3e]
                            flex items-center justify-center">

                    <i class="fa-solid fa-box"></i>

                </div>

            </div>

        </div>


        <!-- Available -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-gray-500">
                        Available Products
                    </p>

                    <h2 class="text-2xl font-bold text-emerald-700 mt-1">
                        {{ $availableProducts }}
                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-emerald-50
                            text-emerald-600
                            flex items-center justify-center">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

            </div>

        </div>


        <!-- Market -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="min-w-0">

                    <p class="text-xs font-medium text-gray-500">
                        Assigned Market
                    </p>

                    <h2 class="text-base font-bold text-gray-800 mt-2 truncate">

                        {{ $farmer->market->name ?? 'Not Assigned' }}

                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-orange-50
                            text-orange-600
                            flex items-center justify-center shrink-0">

                    <i class="fa-solid fa-store"></i>

                </div>

            </div>

        </div>


        <!-- Status -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-gray-500">
                        Account Status
                    </p>

                    <h2 class="text-base font-bold text-gray-800 mt-2 capitalize">

                        {{ $farmer->status ?? 'N/A' }}

                    </h2>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-blue-50
                            text-blue-600
                            flex items-center justify-center">

                    <i class="fa-solid fa-user-check"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- FARMER DETAILS + DESCRIPTION -->
    <!-- ========================================================= -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        <!-- Left / Main -->
        <div class="lg:col-span-2 space-y-6">


            <!-- Personal / Farm Information -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="font-bold text-gray-900">
                        Farmer Information
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Basic information about this farmer.
                    </p>

                </div>


                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">


                    <!-- Email -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Email
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <i class="fa-solid fa-envelope text-[#1b4d3e] text-xs"></i>

                            <span class="text-sm text-gray-700">
                                {{ $farmer->user->email ?? 'N/A' }}
                            </span>

                        </div>

                    </div>


                    <!-- Phone -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Phone
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <i class="fa-solid fa-phone text-[#1b4d3e] text-xs"></i>

                            <span class="text-sm text-gray-700">

                                {{ $farmer->user->phone ?? 'N/A' }}

                            </span>

                        </div>

                    </div>


                    <!-- Market -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Market
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <i class="fa-solid fa-store text-[#1b4d3e] text-xs"></i>

                            <span class="text-sm text-gray-700">

                                {{ $farmer->market->name ?? 'Not Assigned' }}

                            </span>

                        </div>

                    </div>


                    <!-- Location -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Location
                        </p>

                        <div class="flex items-start gap-2 mt-2">

                            <i class="fa-solid fa-location-dot text-[#1b4d3e] text-xs mt-1"></i>

                            <span class="text-sm text-gray-700">

                                {{ $farmer->location ?? 'N/A' }}

                            </span>

                        </div>

                    </div>


                    <!-- Operating Days -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Operating Days
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <i class="fa-solid fa-calendar-days text-[#1b4d3e] text-xs"></i>

                            <span class="text-sm text-gray-700">

                                {{ $farmer->operating_days ?? 'N/A' }}

                            </span>

                        </div>

                    </div>


                    <!-- Pickup Window -->
                    <div>

                        <p class="text-[11px] font-semibold uppercase
                                  tracking-wider text-gray-400">
                            Pickup Window
                        </p>

                        <div class="flex items-center gap-2 mt-2">

                            <i class="fa-solid fa-clock text-[#1b4d3e] text-xs"></i>

                            <span class="text-sm text-gray-700">

                                {{ $farmer->pickup_window ?? 'N/A' }}

                            </span>

                        </div>

                    </div>


                </div>

            </div>


            <!-- Description -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="font-bold text-gray-900">
                        About Farmer
                    </h2>

                </div>

                <div class="p-6">

                    @if($farmer->description)

                        <p class="text-sm leading-7 text-gray-600">
                            {{ $farmer->description }}
                        </p>

                    @else

                        <p class="text-sm text-gray-400 italic">
                            No description provided.
                        </p>

                    @endif

                </div>

            </div>


        </div>


        <!-- ===================================================== -->
        <!-- RIGHT SIDE -->
        <!-- ===================================================== -->

        <div class="space-y-6">


            <!-- Account -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="font-bold text-gray-900">
                        Account Details
                    </h2>

                </div>

                <div class="p-6 space-y-5">


                    <div>

                        <p class="text-[11px] uppercase tracking-wider
                                  font-semibold text-gray-400">
                            Farmer Name
                        </p>

                        <p class="text-sm font-semibold text-gray-800 mt-1">

                            {{ $farmer->farm_name ?? 'N/A' }}

                        </p>

                    </div>


                    <div>

                        <p class="text-[11px] uppercase tracking-wider
                                  font-semibold text-gray-400">
                            Email
                        </p>

                        <p class="text-sm text-gray-700 mt-1 break-all">

                            {{ $farmer->user->email ?? 'N/A' }}

                        </p>

                    </div>


                    <div>

                        <p class="text-[11px] uppercase tracking-wider
                                  font-semibold text-gray-400">
                            Joined
                        </p>

                        <p class="text-sm text-gray-700 mt-1">

                            {{ $farmer->created_at?->format('d M Y') ?? 'N/A' }}

                        </p>

                    </div>


                    <!-- Toggle Status -->
                    <div class="pt-3 border-t border-gray-100">

                        <form action="{{ route('admin.farmers.toggle-status', $farmer->id) }}"
                              method="POST">

                            @csrf
                            @method('PATCH')

                            @if($farmer->status === 'active')

                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to suspend this farmer?')"
                                        class="w-full py-2.5 rounded-lg
                                               bg-white hover:bg-rose-50
                                               text-rose-600
                                               border border-rose-200
                                               text-xs font-semibold transition">

                                    <i class="fa-solid fa-ban mr-1"></i>

                                    Suspend Farmer

                                </button>

                            @else

                                <button type="submit"
                                        class="w-full py-2.5 rounded-lg
                                               bg-[#1b4d3e]
                                               hover:bg-[#143b2f]
                                               text-white
                                               text-xs font-semibold transition">

                                    <i class="fa-solid fa-check mr-1"></i>

                                    Activate Farmer

                                </button>

                            @endif

                        </form>

                    </div>

                </div>

            </div>


        </div>

    </div>


    <!-- ========================================================= -->
    <!-- PRODUCTS -->
    <!-- ========================================================= -->

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100
                    flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-3">

            <div>

                <h2 class="font-bold text-gray-900">
                    Farmer Products
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Products added by {{ $farmer->farm_name ?? 'this farmer' }}.
                </p>

            </div>

            <span class="inline-flex items-center gap-2
                         px-3 py-1.5 rounded-lg
                         bg-[#1b4d3e]/10
                         text-[#1b4d3e]
                         border border-[#1b4d3e]/20
                         text-xs font-bold">

                <i class="fa-solid fa-box"></i>

                {{ $totalProducts }} Products

            </span>

        </div>


        @if($farmer->products->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>

                        <tr class="bg-gray-50 border-b border-gray-200
                                   text-[10px] uppercase tracking-wider
                                   font-bold text-[#1b4d3e]">

                            <th class="px-6 py-3.5">
                                Product
                            </th>

                            <th class="px-6 py-3.5">
                                Category
                            </th>

                            <th class="px-6 py-3.5">
                                Price
                            </th>

                            <th class="px-6 py-3.5">
                                Stock
                            </th>

                            <th class="px-6 py-3.5">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($farmer->products as $product)

                            <tr class="hover:bg-gray-50 transition">


                                <!-- Product -->
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-11 h-11 rounded-lg
                                                    bg-gray-100 overflow-hidden
                                                    border border-gray-200 shrink-0">

                                            @if($product->image)

                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                     class="w-full h-full object-cover"
                                                     alt="{{ $product->name }}">

                                            @else

                                                <div class="w-full h-full flex items-center justify-center
                                                            text-gray-400">

                                                    <i class="fa-solid fa-image"></i>

                                                </div>

                                            @endif

                                        </div>


                                        <div>

                                            <p class="text-sm font-semibold text-gray-800">

                                                {{ $product->name }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Category -->
                                <td class="px-6 py-4">

                                    <span class="text-xs text-gray-600">

                                        {{ $product->category->name ?? 'N/A' }}

                                    </span>

                                </td>


                                <!-- Price -->
                                <td class="px-6 py-4">

                                    <span class="text-sm font-semibold text-[#1b4d3e]">

                                        Rs. {{ number_format($product->price ?? 0, 2) }}

                                    </span>

                                </td>


                                <!-- Stock -->
                                <td class="px-6 py-4">

                                    <span class="text-xs font-semibold text-gray-700">

                                        {{ $product->stock_quantity ?? 0 }}

                                    </span>

                                </td>


                                <!-- Status -->
                                <td class="px-6 py-4">

                                    @if(($product->status ?? '') === 'available')

                                        <span class="inline-flex items-center gap-1.5
                                                     px-2.5 py-1 rounded-full
                                                     bg-emerald-50
                                                     text-emerald-700
                                                     border border-emerald-200
                                                     text-[10px] font-semibold">

                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                            Available

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5
                                                     px-2.5 py-1 rounded-full
                                                     bg-gray-100
                                                     text-gray-600
                                                     border border-gray-200
                                                     text-[10px] font-semibold">

                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>

                                            {{ ucfirst($product->status ?? 'N/A') }}

                                        </span>

                                    @endif

                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <!-- No Products -->
            <div class="py-16 text-center">

                <div class="w-16 h-16 mx-auto rounded-2xl
                            bg-[#1b4d3e]/10
                            text-[#1b4d3e]
                            flex items-center justify-center">

                    <i class="fa-solid fa-box-open text-xl"></i>

                </div>

                <h3 class="mt-4 text-sm font-bold text-gray-800">
                    No Products Added
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    This farmer has not added any products yet.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection