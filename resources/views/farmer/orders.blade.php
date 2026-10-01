@extends('farmer.sidebar')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-10 w-full flex-grow">

    <!-- ==============================
         HEADER
    =============================== -->

    <div class="mb-8">

        <span class="text-[11px] font-bold tracking-widest uppercase text-[#1b4d3e]">
            MARKET-DAY QUEUE
        </span>

        <h1 class="text-4xl sm:text-5xl font-bold mt-1 text-gray-900">
            Incoming orders.
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            Pending orders placed for your products.
        </p>

    </div>


    <!-- ==============================
         SUCCESS MESSAGE
    =============================== -->

    @if(session('success'))

        <div class="mb-6 flex items-center justify-between gap-4
                    bg-emerald-50 border border-emerald-200
                    text-emerald-800 rounded-xl px-4 py-3">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                <span class="text-sm font-semibold">
                    {{ session('success') }}
                </span>

            </div>


            <button
                type="button"
                onclick="this.parentElement.remove()"
                class="text-emerald-700 hover:text-emerald-900 font-bold"
            >
                ×
            </button>

        </div>

    @endif


    <!-- ==============================
         ERROR MESSAGE
    =============================== -->

    @if(session('error'))

        <div class="mb-6 flex items-center justify-between gap-4
                    bg-rose-50 border border-rose-200
                    text-rose-800 rounded-xl px-4 py-3">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>

                <span class="text-sm font-semibold">
                    {{ session('error') }}
                </span>

            </div>


            <button
                type="button"
                onclick="this.parentElement.remove()"
                class="text-rose-700 hover:text-rose-900 font-bold"
            >
                ×
            </button>

        </div>

    @endif


    <!-- ==============================
         ORDERS TABLE
    =============================== -->

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <!-- TABLE HEADER -->

                <thead>

                    <tr class="bg-gray-50 text-xs font-bold text-gray-700 border-b border-gray-200">

                        <th class="py-4 px-6">
                            Order
                        </th>

                        <th class="py-4 px-6">
                            Customer
                        </th>

                        <th class="py-4 px-6">
                            Product
                        </th>

                        <th class="py-4 px-6">
                            Quantity
                        </th>

                        <th class="py-4 px-6">
                            Total
                        </th>

                        <th class="py-4 px-6">
                            Status
                        </th>

                        <th class="py-4 px-6 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <!-- TABLE BODY -->

                <tbody class="divide-y divide-gray-100 text-sm">

                    @forelse($orders as $order)

                        <tr class="hover:bg-gray-50 transition-colors">

                            <!-- ORDER -->

                            <td class="py-5 px-6">

                                <div class="font-bold text-gray-800">

                                    ML-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}

                                </div>

                                <div class="text-[11px] text-gray-400 mt-1">

                                    {{ $order->created_at->format('M d, Y') }}

                                </div>

                            </td>


                            <!-- CUSTOMER -->

                            <td class="py-5 px-6">

                                <div class="font-semibold text-gray-800">

                                    {{ $order->user->name ?? 'Unknown Customer' }}

                                </div>

                                @if($order->user?->email)

                                    <div class="text-[11px] text-gray-400 mt-1">

                                        {{ $order->user->email }}

                                    </div>

                                @endif

                            </td>


                            <!-- PRODUCT -->

                            <td class="py-5 px-6">

                                <div class="flex items-center gap-3">

                                    @if($order->product?->image)

                                        <img
                                            src="{{ asset('storage/' . $order->product->image) }}"
                                            class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                            alt="{{ $order->product->name }}"
                                        >

                                    @else

                                        <div class="w-10 h-10 rounded-lg bg-gray-100
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

                                            <div class="text-[11px] text-gray-400">

                                                Per {{ $order->product->unit }}

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <!-- QUANTITY -->

                            <td class="py-5 px-6">

                                <span class="font-semibold text-gray-800">

                                    {{ $order->quantity }}

                                </span>

                                @if($order->product?->unit)

                                    <span class="text-gray-400 text-xs">

                                        {{ $order->product->unit }}

                                    </span>

                                @endif

                            </td>


                            <!-- TOTAL -->

                            <td class="py-5 px-6">

                                <span class="font-bold text-gray-900">

                                    PKR
                                    {{ number_format($order->price * $order->quantity, 2) }}

                                </span>

                            </td>


                            <!-- STATUS -->

                            <td class="py-5 px-6">

                                <span class="inline-flex items-center gap-1.5
                                             px-2.5 py-1 rounded-full
                                             bg-amber-50
                                             text-amber-700
                                             border border-amber-200
                                             text-[10px] font-bold uppercase">

                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>

                                    Pending

                                </span>

                            </td>


                            <!-- ACTIONS -->

                            <td class="py-5 px-6 text-right">

                                <div class="flex justify-end items-center gap-2">

                                    <!-- CONFIRM -->

                                    <form
                                        action="{{ route('farmer.orders.confirm', $order->id) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="px-3.5 py-2
                                                   bg-[#1b4d3e]
                                                   hover:bg-[#143b2f]
                                                   text-white
                                                   rounded-lg
                                                   text-xs
                                                   font-bold
                                                   transition"
                                        >

                                            <i class="fa-solid fa-check mr-1"></i>

                                            Confirm

                                        </button>

                                    </form>


                                    <!-- CANCEL -->

                                    <form
                                        action="{{ route('farmer.orders.cancel', $order->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this order?');"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="px-3.5 py-2
                                                   bg-rose-50
                                                   hover:bg-rose-100
                                                   text-rose-600
                                                   border border-rose-200
                                                   rounded-lg
                                                   text-xs
                                                   font-bold
                                                   transition"
                                        >

                                            <i class="fa-solid fa-xmark mr-1"></i>

                                            Cancel

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="py-20 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="w-16 h-16 rounded-full
                                                bg-gray-50
                                                flex items-center justify-center
                                                mb-4">

                                        <i class="fa-solid fa-inbox text-2xl text-gray-300"></i>

                                    </div>


                                    <h3 class="text-sm font-bold text-gray-700">

                                        No pending orders

                                    </h3>


                                    <p class="text-xs text-gray-400 mt-1">

                                        New orders for your products will appear here.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- ==============================
             PAGINATION
        =============================== -->

      
    </div>

</main>

@endsection