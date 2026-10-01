@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-7xl space-y-6">

    {{-- PAGE HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <div class="flex items-center gap-2 mb-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm text-gray-500 hover:text-[#1b4d3e] transition">
                    Dashboard
                </a>

                <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>

                <span class="text-sm font-medium text-[#1b4d3e]">
                    History
                </span>

            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Order History
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                View all completed orders.
            </p>

        </div>


        {{-- COUNT --}}
        <div class="bg-white border border-gray-200 rounded-xl px-5 py-3 shadow-sm">

            <p class="text-[11px] text-gray-400 uppercase font-semibold">
                Completed Orders
            </p>

            <p class="text-xl font-bold text-[#1b4d3e]">
                {{ $orders->count() }}
            </p>

        </div>

    </div>


    {{-- ORDERS --}}
    @if($orders->count() > 0)

        <div class="space-y-4">

            @foreach($orders as $order)

                <div class="bg-white border border-gray-200
                            rounded-2xl shadow-sm
                            hover:shadow-md transition">

                    <div class="p-5">

                        <div class="flex flex-col xl:flex-row
                                    xl:items-center gap-5">


                            {{-- ORDER --}}
                            <div class="xl:w-24 shrink-0">

                                <p class="text-[10px] uppercase
                                          text-gray-400 font-semibold">
                                    Order
                                </p>

                                <p class="text-sm font-bold text-gray-900 mt-1">
                                    #{{ $order->id }}
                                </p>

                            </div>


                            {{-- CUSTOMER --}}
                            <div class="xl:w-40 shrink-0">

                                <p class="text-[10px] uppercase
                                          text-gray-400 font-semibold">
                                    Customer
                                </p>

                                <div class="flex items-center gap-2 mt-1">

                                    <div class="w-7 h-7 rounded-full
                                                bg-blue-50
                                                flex items-center justify-center">

                                        <i class="fa-solid fa-user
                                                  text-blue-600 text-[10px]"></i>

                                    </div>

                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $order->user->name ?? 'N/A' }}
                                    </p>

                                </div>

                            </div>


                            {{-- FARMER --}}
                            <div class="xl:w-40 shrink-0">

                                <p class="text-[10px] uppercase
                                          text-gray-400 font-semibold">
                                    Farmer
                                </p>

                                <div class="flex items-center gap-2 mt-1">

                                    <div class="w-7 h-7 rounded-full
                                                bg-orange-50
                                                flex items-center justify-center">

                                        <i class="fa-solid fa-tractor
                                                  text-orange-600 text-[10px]"></i>

                                    </div>

                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $order->farmer->farm_name ?? 'N/A' }}
                                    </p>

                                </div>

                            </div>


                            {{-- PRODUCT --}}
                            <div class="flex-1 min-w-0">

                                <p class="text-[10px] uppercase
                                          text-gray-400 font-semibold">
                                    Product
                                </p>

                                <div class="flex items-center gap-3 mt-1">

                                    <div class="w-9 h-9 rounded-lg
                                                bg-gray-100 overflow-hidden
                                                shrink-0">

                                        @if($order->product?->image)

                                            <img
                                                src="{{ asset('storage/' . $order->product->image) }}"
                                                class="w-full h-full object-cover"
                                                alt="{{ $order->product->name }}"
                                            >

                                        @else

                                            <div class="w-full h-full
                                                        flex items-center justify-center">

                                                <i class="fa-solid fa-leaf
                                                          text-gray-400 text-xs"></i>

                                            </div>

                                        @endif

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-sm font-semibold
                                                  text-gray-800 truncate">

                                            {{ $order->product->name ?? 'N/A' }}

                                        </p>

                                        <p class="text-xs text-gray-400">

                                            Qty: {{ $order->quantity }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- TOTAL --}}
                            <div class="xl:w-28 shrink-0">

                                <p class="text-[10px] uppercase
                                          text-gray-400 font-semibold">
                                    Total
                                </p>

                                <p class="text-sm font-bold
                                          text-[#1b4d3e] mt-1">

                                    Rs.
                                    {{ number_format(
                                        ($order->price ?? 0) *
                                        ($order->quantity ?? 0),
                                        2
                                    ) }}

                                </p>

                            </div>


                            {{-- STATUS --}}
                            <div class="xl:w-28 shrink-0">

                                <span class="inline-flex items-center gap-1.5
                                             px-2.5 py-1.5
                                             rounded-full
                                             bg-gray-100
                                             border border-gray-200
                                             text-gray-700
                                             text-[11px]
                                             font-semibold">

                                    <span class="w-1.5 h-1.5
                                                 rounded-full
                                                 bg-gray-500"></span>

                                    Completed

                                </span>

                            </div>


                            {{-- VIEW DETAILS --}}
                            <div class="xl:w-auto shrink-0">

                                <a href="{{ route('admin.history.show', $order->id) }}"
                                   class="inline-flex items-center gap-2
                                          px-4 py-2
                                          bg-[#1b4d3e]
                                          hover:bg-[#143b2f]
                                          text-white
                                          rounded-lg
                                          text-xs
                                          font-semibold
                                          transition
                                          whitespace-nowrap">

                                    <i class="fa-solid fa-eye text-[10px]"></i>

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- EMPTY --}}
        <div class="bg-white border border-gray-200
                    rounded-2xl shadow-sm
                    py-16 text-center">

            <div class="w-16 h-16 mx-auto
                        rounded-2xl
                        bg-[#1b4d3e]/10
                        flex items-center justify-center">

                <i class="fa-solid fa-clock-rotate-left
                          text-[#1b4d3e] text-2xl"></i>

            </div>

            <h3 class="mt-4 text-lg font-bold text-gray-900">
                No Completed Orders
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Completed orders will appear here.
            </p>

        </div>

    @endif

</div>

@endsection