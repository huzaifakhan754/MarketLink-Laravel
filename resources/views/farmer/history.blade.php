@extends('farmer.sidebar')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-10 w-full flex-grow">

    <!-- HEADER -->
    <div class="mb-8">

        <span class="text-[11px] font-bold tracking-widest uppercase text-[#1b4d3e]">
            ORDER HISTORY
        </span>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            <div>
                <h1 class="text-4xl sm:text-5xl font-bold mt-1 text-gray-900">
                    Completed orders.
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    View all orders successfully picked up by customers.
                </p>
            </div>

            <!-- COUNT -->
            <div class="bg-white border border-gray-200 rounded-xl px-5 py-3 shadow-sm">

                <div class="text-[10px] uppercase tracking-wider font-bold text-gray-400">
                    Completed
                </div>

                <div class="text-2xl font-bold text-[#1b4d3e]">
                    {{ $orders->count() }}
                </div>

            </div>

        </div>

    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="mb-6 bg-emerald-50 border border-emerald-200
                    text-emerald-700 rounded-xl px-5 py-4
                    text-sm font-semibold">

            <i class="fa-solid fa-circle-check mr-2"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- ORDERS TABLE -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-base font-bold text-gray-900">
                Completed orders
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                Orders that have already been picked up.
            </p>

        </div>


        @if($orders->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 border-b border-gray-100">

                        <tr>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Order
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Customer
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Product
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Quantity
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Total
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Status
                            </th>

                            <th class="text-left px-6 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-bold text-gray-400">
                                Date
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($orders as $order)

                            <tr class="hover:bg-gray-50 transition">


                                <!-- ORDER -->
                                <td class="px-6 py-5">

                                    <div class="font-bold text-gray-900">
                                        ML-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="text-xs text-gray-400 mt-1">
                                        Order #{{ $order->id }}
                                    </div>

                                </td>


                                <!-- CUSTOMER -->
                                <td class="px-6 py-5">

                                    <div class="font-semibold text-gray-800">
                                        {{ $order->user->name ?? 'Unknown Customer' }}
                                    </div>

                                    @if($order->user?->email)

                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $order->user->email }}
                                        </div>

                                    @endif

                                </td>


                                <!-- PRODUCT -->
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        @if($order->product?->image)

                                            <img
                                                src="{{ asset('storage/' . $order->product->image) }}"
                                                alt="{{ $order->product->name }}"
                                                class="w-11 h-11 rounded-lg object-cover border border-gray-200"
                                            >

                                        @else

                                            <div class="w-11 h-11 rounded-lg bg-gray-100
                                                        flex items-center justify-center
                                                        text-gray-400">

                                                <i class="fa-solid fa-wheat-awn"></i>

                                            </div>

                                        @endif


                                        <div>

                                            <div class="font-semibold text-gray-800">
                                                {{ $order->product->name ?? 'Product removed' }}
                                            </div>

                                            @if($order->product?->unit)

                                                <div class="text-xs text-gray-400 mt-1">
                                                    Per {{ $order->product->unit }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                <!-- QUANTITY -->
                                <td class="px-6 py-5">

                                    <span class="font-semibold text-gray-800">
                                        {{ $order->quantity }}
                                    </span>

                                    @if($order->product?->unit)

                                        <span class="text-xs text-gray-400">
                                            {{ $order->product->unit }}
                                        </span>

                                    @endif

                                </td>


                                <!-- TOTAL -->
                                <td class="px-6 py-5">

                                    <span class="font-bold text-[#1b4d3e]">
                                        PKR {{ number_format($order->price * $order->quantity, 2) }}
                                    </span>

                                </td>


                                <!-- STATUS -->
                                <td class="px-6 py-5">

                                    <span class="inline-flex items-center gap-1.5
                                                 px-3 py-1.5 rounded-full
                                                 bg-emerald-50
                                                 text-emerald-700
                                                 border border-emerald-200
                                                 text-[10px] font-bold uppercase">

                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                        Completed

                                    </span>

                                </td>


                                <!-- DATE -->
                                <td class="px-6 py-5">

                                    <div class="text-sm font-semibold text-gray-700">
                                        {{ $order->updated_at->format('M d, Y') }}
                                    </div>

                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $order->updated_at->format('h:i A') }}
                                    </div>

                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <!-- EMPTY STATE -->

            <div class="px-6 py-20 text-center">

                <div class="w-16 h-16 mx-auto rounded-full
                            bg-gray-50 flex items-center justify-center
                            text-gray-400 mb-5">

                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>

                </div>

                <h3 class="text-lg font-bold text-gray-900">
                    No completed orders yet
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Orders you mark as picked up will appear here.
                </p>

                <a
                    href="{{ route('farmer.pickup') }}"
                    class="inline-flex items-center gap-2
                           mt-6 px-5 py-2.5
                           bg-[#1b4d3e]
                           hover:bg-[#143b2f]
                           text-white rounded-lg
                           text-sm font-bold transition"
                >
                    <i class="fa-solid fa-box"></i>
                    View Pickup Orders
                </a>

            </div>

        @endif

    </div>

</main>

@endsection