@extends('farmer.sidebar')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-10 w-full flex-grow">

    <!-- ==============================
         BACK BUTTON
    =============================== -->

    <div class="mb-8">

        <a
            href="{{ route('farmer.pickup') }}"
            class="inline-flex items-center gap-2
                   text-sm font-semibold
                   text-gray-600
                   hover:text-[#1b4d3e]
                   transition"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to pickups
        </a>

    </div>


    <!-- ==============================
         HEADER
    =============================== -->

    <div class="mb-8">

        <span class="text-[11px] font-bold tracking-widest uppercase text-[#1b4d3e]">
            ORDER DETAILS
        </span>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">

            <div>

                <h1 class="text-4xl sm:text-5xl font-bold mt-1 text-gray-900">
                    Order details.
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Review the customer and pickup information for this order.
                </p>

            </div>


            <!-- ORDER NUMBER -->

            <div class="text-left sm:text-right">

                <div class="text-xs text-gray-400 font-medium">
                    Order
                </div>

                <div class="text-lg font-bold text-[#1b4d3e]">
                    ML-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                </div>

            </div>

        </div>

    </div>


    <!-- ==============================
         ORDER STATUS
    =============================== -->

    <div class="mb-6">

        <div class="bg-emerald-50 border border-emerald-200
                    rounded-xl px-5 py-4
                    flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-3">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full
                            bg-emerald-100
                            flex items-center justify-center">

                    <i class="fa-solid fa-circle-check text-emerald-600"></i>

                </div>

                <div>

                    <div class="text-sm font-bold text-emerald-800">
                        Ready for pickup
                    </div>

                    <div class="text-xs text-emerald-700 mt-0.5">
                        This order is ready for the customer.
                    </div>

                </div>

            </div>


            <span class="inline-flex items-center gap-1.5
                         px-3 py-1.5
                         rounded-full
                         bg-white
                         text-emerald-700
                         border border-emerald-200
                         text-[10px]
                         font-bold
                         uppercase">

                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                Ready

            </span>

        </div>

    </div>


    <!-- ==============================
         MAIN GRID
    =============================== -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        <!-- ==============================
             LEFT SIDE
        =============================== -->

        <div class="lg:col-span-2 space-y-6">


            <!-- PRODUCT CARD -->

            <div class="bg-white border border-gray-200
                        rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="text-base font-bold text-gray-900">
                        Product
                    </h2>

                    <p class="text-xs text-gray-400 mt-1">
                        Item included in this order
                    </p>

                </div>


                <div class="p-6">

                    <div class="flex flex-col sm:flex-row gap-5">


                        <!-- PRODUCT IMAGE -->

                        @if($order->product?->image)

                            <img
                                src="{{ asset('storage/' . $order->product->image) }}"
                                alt="{{ $order->product->name }}"
                                class="w-full sm:w-32 h-32
                                       rounded-xl
                                       object-cover
                                       border border-gray-200"
                            >

                        @else

                            <div class="w-full sm:w-32 h-32
                                        rounded-xl
                                        bg-gray-100
                                        flex items-center justify-center
                                        text-gray-400">

                                <i class="fa-solid fa-wheat-awn text-3xl"></i>

                            </div>

                        @endif


                        <!-- PRODUCT INFO -->

                        <div class="flex-1">

                            <div class="flex flex-col sm:flex-row
                                        sm:items-start
                                        sm:justify-between gap-3">

                                <div>

                                    <h3 class="text-xl font-bold text-gray-900">

                                        {{ $order->product->name ?? 'Product removed' }}

                                    </h3>

                                    @if($order->product?->unit)

                                        <p class="text-xs text-gray-400 mt-1">

                                            Sold per {{ $order->product->unit }}

                                        </p>

                                    @endif

                                </div>


                                <div class="text-left sm:text-right">

                                    <div class="text-xs text-gray-400">
                                        Unit price
                                    </div>

                                    <div class="text-lg font-bold text-gray-900">

                                        PKR {{ number_format($order->price, 2) }}

                                    </div>

                                </div>

                            </div>


                            <!-- QUANTITY / TOTAL -->

                            <div class="grid grid-cols-2 gap-4 mt-6">


                                <div class="bg-gray-50 rounded-xl p-4">

                                    <div class="text-[10px]
                                                uppercase
                                                tracking-wider
                                                font-bold
                                                text-gray-400">

                                        Quantity

                                    </div>

                                    <div class="text-lg
                                                font-bold
                                                text-gray-900
                                                mt-1">

                                        {{ $order->quantity }}

                                        @if($order->product?->unit)

                                            <span class="text-xs
                                                         text-gray-400
                                                         font-medium">

                                                {{ $order->product->unit }}

                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <div class="bg-[#f2ece4] rounded-xl p-4">

                                    <div class="text-[10px]
                                                uppercase
                                                tracking-wider
                                                font-bold
                                                text-gray-500">

                                        Order total

                                    </div>

                                    <div class="text-lg
                                                font-bold
                                                text-[#1b4d3e]
                                                mt-1">

                                        PKR
                                        {{ number_format($order->price * $order->quantity, 2) }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- CUSTOMER CARD -->

            <div class="bg-white border border-gray-200
                        rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="text-base font-bold text-gray-900">
                        Customer information
                    </h2>

                    <p class="text-xs text-gray-400 mt-1">
                        Customer who placed this order
                    </p>

                </div>


                <div class="p-6">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12
                                    rounded-full
                                    bg-[#1b4d3e]
                                    text-white
                                    flex items-center justify-center
                                    font-bold text-lg">

                            {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}

                        </div>


                        <div>

                            <div class="font-bold text-gray-900">

                                {{ $order->user->name ?? 'Unknown Customer' }}

                            </div>

                            @if($order->user?->email)

                                <div class="text-sm text-gray-500 mt-1">

                                    {{ $order->user->email }}

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ==============================
             RIGHT SIDE
        =============================== -->

        <div class="space-y-6">


            <!-- ORDER SUMMARY -->

            <div class="bg-white border border-gray-200
                        rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="text-base font-bold text-gray-900">
                        Order summary
                    </h2>

                </div>


                <div class="p-6 space-y-4">


                    <div class="flex justify-between items-center">

                        <span class="text-sm text-gray-500">
                            Order ID
                        </span>

                        <span class="text-sm font-bold text-gray-800">

                            ML-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}

                        </span>

                    </div>


                    <div class="flex justify-between items-center">

                        <span class="text-sm text-gray-500">
                            Quantity
                        </span>

                        <span class="text-sm font-bold text-gray-800">

                            {{ $order->quantity }}

                        </span>

                    </div>


                    <div class="flex justify-between items-center">

                        <span class="text-sm text-gray-500">
                            Unit price
                        </span>

                        <span class="text-sm font-bold text-gray-800">

                            PKR {{ number_format($order->price, 2) }}

                        </span>

                    </div>


                    <div class="border-t border-gray-100 pt-4
                                flex justify-between items-center">

                        <span class="text-sm font-bold text-gray-900">
                            Total
                        </span>

                        <span class="text-xl font-bold text-[#1b4d3e]">

                            PKR
                            {{ number_format($order->price * $order->quantity, 2) }}

                        </span>

                    </div>

                </div>

            </div>


            <!-- ORDER DATE -->

            <div class="bg-white border border-gray-200
                        rounded-2xl shadow-sm p-6">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10
                                rounded-lg
                                bg-gray-50
                                flex items-center justify-center">

                        <i class="fa-regular fa-calendar text-gray-500"></i>

                    </div>

                    <div>

                        <div class="text-xs text-gray-400">
                            Order placed
                        </div>

                        <div class="text-sm font-bold text-gray-800 mt-1">

                            {{ $order->created_at->format('M d, Y') }}

                        </div>

                    </div>

                </div>

            </div>


            <!-- PICKUP ACTION -->

            <div class="bg-[#1b4d3e]
                        rounded-2xl
                        p-6
                        text-white">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10
                                rounded-full
                                bg-white/10
                                flex items-center justify-center">

                        <i class="fa-solid fa-hand-holding-heart"></i>

                    </div>

                    <div>

                        <h3 class="font-bold">
                            Customer pickup
                        </h3>

                        <p class="text-xs text-white/70 mt-0.5">
                            Order is ready to hand over.
                        </p>

                    </div>

                </div>


               <form
    action="{{ route('farmer.orders.pickedup', $order->id) }}"
    method="POST"
    onsubmit="return confirm('Mark this order as picked up?');"
>
    @csrf

    <button
        type="submit"
        class="w-full bg-white text-[#1b4d3e]
               hover:bg-gray-100 rounded-lg py-3
               text-sm font-bold transition"
    >
        <i class="fa-solid fa-check mr-1"></i>
        Mark as Picked Up
    </button>
</form>
            </div>


        </div>

    </div>

</main>

@endsection