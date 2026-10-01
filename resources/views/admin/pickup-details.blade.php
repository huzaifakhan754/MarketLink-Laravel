@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-7xl space-y-6">

{{-- PAGE HEADER --}}
<div class="mb-6">

    <div class="flex items-center gap-2 mb-3">

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-500 hover:text-[#1b4d3e] transition">
            Dashboard
        </a>

        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>

        <a href="{{ route('admin.pickup') }}"
           class="text-sm text-gray-500 hover:text-[#1b4d3e] transition">
            Pickup
        </a>

        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>

        <span class="text-sm font-medium text-[#1b4d3e]">
            Order #{{ $order->id }}
        </span>

    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Pickup Order #{{ $order->id }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Complete information for this ready pickup order.
            </p>
        </div>

        <div class="flex items-center gap-3">

            <a href="{{ route('admin.pickup') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5
                      bg-white border border-gray-200
                      hover:bg-gray-50
                      text-gray-700 rounded-lg
                      text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                Back to Pickup
            </a>

            <span class="inline-flex items-center gap-2
                         px-4 py-2.5
                         rounded-lg
                         bg-emerald-50
                         border border-emerald-200
                         text-emerald-700
                         text-xs font-bold">

                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Ready for Pickup

            </span>

        </div>

    </div>

</div>


{{-- ORDER SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    {{-- ORDER --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl
                        bg-[#1b4d3e]/10
                        flex items-center justify-center">

                <i class="fa-solid fa-receipt text-[#1b4d3e]"></i>

            </div>

            <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Order Number
                </p>

                <p class="text-lg font-bold text-gray-900">
                    #{{ $order->id }}
                </p>
            </div>

        </div>

    </div>


    {{-- TOTAL --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl
                        bg-emerald-50
                        flex items-center justify-center">

                <i class="fa-solid fa-money-bill-wave text-emerald-600"></i>

            </div>

            <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Order Total
                </p>

                <p class="text-lg font-bold text-[#1b4d3e]">
                    Rs.
                    {{ number_format(
                        ($order->price ?? 0) * ($order->quantity ?? 0),
                        2
                    ) }}
                </p>
            </div>

        </div>

    </div>


    {{-- DATE --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl
                        bg-orange-50
                        flex items-center justify-center">

                <i class="fa-solid fa-calendar text-orange-600"></i>

            </div>

            <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Order Date
                </p>

                <p class="text-sm font-bold text-gray-900">
                    {{ $order->created_at?->format('d M Y') ?? 'N/A' }}
                </p>

                <p class="text-[11px] text-gray-400">
                    {{ $order->created_at?->format('h:i A') ?? '' }}
                </p>
            </div>

        </div>

    </div>

</div>


{{-- MAIN GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


    {{-- CUSTOMER DETAILS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100
                    flex items-center gap-3">

            <div class="w-9 h-9 rounded-lg
                        bg-blue-50
                        flex items-center justify-center">

                <i class="fa-solid fa-user text-blue-600"></i>

            </div>

            <div>
                <h2 class="text-sm font-bold text-gray-900">
                    Customer Details
                </h2>

                <p class="text-[11px] text-gray-400">
                    Customer information
                </p>
            </div>

        </div>

        <div class="p-5 space-y-4">

            <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Name
                </p>

                <p class="text-sm font-semibold text-gray-800 mt-1">
                    {{ $order->user->name ?? 'N/A' }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Email
                    </p>

                    <p class="text-sm text-gray-700 mt-1 break-all">
                        {{ $order->user->email ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Phone
                    </p>

                    <p class="text-sm text-gray-700 mt-1">
                        {{ $order->customer_phone ?? ($order->user->phone ?? 'N/A') }}
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- FARMER DETAILS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100
                    flex items-center gap-3">

            <div class="w-9 h-9 rounded-lg
                        bg-orange-50
                        flex items-center justify-center">

                <i class="fa-solid fa-tractor text-orange-600"></i>

            </div>

            <div>
                <h2 class="text-sm font-bold text-gray-900">
                    Farmer Details
                </h2>

                <p class="text-[11px] text-gray-400">
                    Farmer and farm information
                </p>
            </div>

        </div>

        <div class="p-5 space-y-4">

            <div>
                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Farm Name
                </p>

                <p class="text-sm font-semibold text-gray-800 mt-1">
                    {{ $order->farmer->farm_name ?? 'N/A' }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Farmer Name
                    </p>

                    <p class="text-sm text-gray-700 mt-1">
                        {{ $order->farmer->user->name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Market
                    </p>

                    <p class="text-sm text-gray-700 mt-1">
                        {{ $order->farmer->market->name ?? 'N/A' }}
                    </p>
                </div>

            </div>

            @if($order->farmer?->location)

                <div>
                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Location
                    </p>

                    <p class="text-sm text-gray-700 mt-1">
                        {{ $order->farmer->location }}
                    </p>
                </div>

            @endif

        </div>

    </div>


    {{-- PRODUCT DETAILS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100
                    flex items-center gap-3">

            <div class="w-9 h-9 rounded-lg
                        bg-green-50
                        flex items-center justify-center">

                <i class="fa-solid fa-leaf text-green-600"></i>

            </div>

            <div>
                <h2 class="text-sm font-bold text-gray-900">
                    Product Details
                </h2>

                <p class="text-[11px] text-gray-400">
                    Ordered product information
                </p>
            </div>

        </div>

        <div class="p-5">

            <div class="flex items-center gap-4">

                <div class="w-20 h-20 rounded-xl overflow-hidden
                            bg-gray-100 shrink-0">

                    @if($order->product?->image)

                        <img
                            src="{{ asset('storage/' . $order->product->image) }}"
                            alt="{{ $order->product->name }}"
                            class="w-full h-full object-cover"
                        >

                    @else

                        <div class="w-full h-full flex items-center justify-center">

                            <i class="fa-solid fa-leaf text-gray-400 text-xl"></i>

                        </div>

                    @endif

                </div>

                <div class="min-w-0">

                    <h3 class="text-base font-bold text-gray-900">
                        {{ $order->product->name ?? 'N/A' }}
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Category:
                        {{ $order->product->category->name ?? 'N/A' }}
                    </p>

                    <p class="text-sm text-[#1b4d3e] font-semibold mt-2">
                        Rs. {{ number_format($order->price ?? 0, 2) }}
                        <span class="text-gray-400 font-normal">
                            / unit
                        </span>
                    </p>

                </div>

            </div>


            <div class="grid grid-cols-2 gap-4 mt-5 pt-5 border-t border-gray-100">

                <div>

                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Quantity
                    </p>

                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $order->quantity }}
                    </p>

                </div>

                <div>

                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Total
                    </p>

                    <p class="text-lg font-bold text-[#1b4d3e] mt-1">
                        Rs.
                        {{ number_format(
                            ($order->price ?? 0) * ($order->quantity ?? 0),
                            2
                        ) }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- PICKUP DETAILS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100
                    flex items-center gap-3">

            <div class="w-9 h-9 rounded-lg
                        bg-purple-50
                        flex items-center justify-center">

                <i class="fa-solid fa-box text-purple-600"></i>

            </div>

            <div>
                <h2 class="text-sm font-bold text-gray-900">
                    Pickup Details
                </h2>

                <p class="text-[11px] text-gray-400">
                    Customer pickup information
                </p>
            </div>

        </div>

        <div class="p-5 space-y-4">

            <div>

                <p class="text-[10px] uppercase font-semibold text-gray-400">
                    Pickup Name
                </p>

                <p class="text-sm font-semibold text-gray-800 mt-1">
                    {{ $order->pickup_name ?? 'N/A' }}
                </p>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Pickup Date
                    </p>

                    <p class="text-sm font-semibold text-gray-800 mt-1">
                        {{ $order->pickup_date ?? 'N/A' }}
                    </p>

                </div>

                <div>

                    <p class="text-[10px] uppercase font-semibold text-gray-400">
                        Time Slot
                    </p>

                    <p class="text-sm font-semibold text-gray-800 mt-1">
                        {{ $order->time_slot ?? 'N/A' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


</div>


{{-- ORDER INFORMATION --}}
<div class="mt-6 bg-white border border-gray-200 rounded-2xl shadow-sm">

    <div class="px-5 py-4 border-b border-gray-100">

        <h2 class="text-sm font-bold text-gray-900">
            Order Information
        </h2>

    </div>

    <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-5">

        <div>
            <p class="text-[10px] uppercase font-semibold text-gray-400">
                Order ID
            </p>

            <p class="text-sm font-semibold text-gray-800 mt-1">
                #{{ $order->id }}
            </p>
        </div>

        <div>
            <p class="text-[10px] uppercase font-semibold text-gray-400">
                Status
            </p>

            <span class="inline-flex items-center gap-1.5
                         mt-1 px-2.5 py-1
                         rounded-full
                         bg-emerald-50
                         border border-emerald-200
                         text-emerald-700
                         text-[11px] font-semibold">

                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                {{ ucfirst($order->status) }}

            </span>
        </div>

        <div>
            <p class="text-[10px] uppercase font-semibold text-gray-400">
                Created At
            </p>

            <p class="text-sm font-semibold text-gray-800 mt-1">
                {{ $order->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
            </p>
        </div>

    </div>

</div>


</div>

@endsection
