@extends('farmer.sidebar')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-10 w-full flex-grow">

    <!-- ==============================
         BACK BUTTON
    =============================== -->

    <div class="mb-8">

        <a
            href="{{ route('farmer.dashboard') }}"
            class="inline-flex items-center gap-2
                   text-sm font-semibold
                   text-gray-600
                   hover:text-[#1b4d3e]
                   transition"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to dashboard
        </a>

    </div>


    <!-- ==============================
         HEADER
    ============================== -->

    <div class="mb-8">

        <span class="text-[11px] font-bold tracking-widest uppercase text-[#1b4d3e]">
            CUSTOMER FEEDBACK
        </span>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">

            <div>

                <h1 class="text-4xl sm:text-5xl font-bold mt-1 text-gray-900">
                    Customer feedback.
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    See what customers are saying about your products.
                </p>

            </div>

        </div>

    </div>


    <!-- ==============================
         STATS
    ============================== -->

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- TOTAL FEEDBACKS -->

        <div class="bg-white border border-gray-200
                    rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Total feedbacks
                    </div>

                    <div class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalFeedbacks }}
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Customer reviews received
                    </div>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-[#f2ece4]
                            flex items-center justify-center">

                    <i class="fa-solid fa-comments text-[#1b4d3e]"></i>

                </div>

            </div>

        </div>


        <!-- AVERAGE RATING -->

        <div class="bg-white border border-gray-200
                    rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Average rating
                    </div>

                    <div class="flex items-center gap-2 mt-2">

                        <span class="text-3xl font-bold text-gray-900">
                            {{ number_format($averageRating, 1) }}
                        </span>

                        <span class="text-[#ca6232] text-xl">
                            ★
                        </span>

                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Based on customer ratings
                    </div>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-[#f2ece4]
                            flex items-center justify-center">

                    <i class="fa-solid fa-star text-[#ca6232]"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- ==============================
         FEEDBACK LIST
    ============================== -->

    <div class="bg-white border border-gray-200
                rounded-2xl shadow-sm overflow-hidden">

        <!-- CARD HEADER -->

        <div class="px-6 py-5 border-b border-gray-100">

            <h2 class="text-base font-bold text-gray-900">
                Customer reviews
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                Feedback submitted by customers for your completed orders.
            </p>

        </div>


        <!-- FEEDBACKS -->

        <div class="divide-y divide-gray-100">

            @forelse($feedbacks as $feedback)

                <div class="p-6">

                    <div class="flex flex-col sm:flex-row
                                sm:items-start
                                sm:justify-between gap-5">


                        <!-- CUSTOMER -->

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12
                                        rounded-full
                                        bg-[#1b4d3e]
                                        text-white
                                        flex items-center justify-center
                                        font-bold text-lg">

                                {{ strtoupper(substr($feedback->customer->name ?? 'C', 0, 1)) }}

                            </div>


                            <div>

                                <div class="font-bold text-gray-900">

                                    {{ $feedback->customer->name ?? 'Unknown Customer' }}

                                </div>

                                <div class="text-xs text-gray-400 mt-1">

                                    {{ $feedback->created_at->format('M d, Y') }}

                                </div>

                            </div>

                        </div>


                        <!-- RATING -->

                        <div class="flex items-center gap-1">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= $feedback->rating)

                                    <i class="fa-solid fa-star text-[#ca6232] text-sm"></i>

                                @else

                                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>

                                @endif

                            @endfor

                            <span class="ml-2 text-xs font-bold text-gray-500">

                                {{ $feedback->rating }}/5

                            </span>

                        </div>

                    </div>


                    <!-- PRODUCT -->

                    @if($feedback->order?->product)

                        <div class="mt-5">

                            <div class="inline-flex items-center gap-2
                                        bg-gray-50
                                        border border-gray-200
                                        rounded-lg
                                        px-3 py-2">

                                <i class="fa-solid fa-box text-[#1b4d3e] text-xs"></i>

                                <span class="text-xs text-gray-500">
                                    Product:
                                </span>

                                <span class="text-xs font-bold text-gray-800">

                                    {{ $feedback->order->product->name }}

                                </span>

                            </div>

                        </div>

                    @endif


                    <!-- COMMENT -->

                    <div class="mt-5">

                        @if($feedback->comment)

                            <div class="bg-[#fdfbf7]
                                        border border-gray-100
                                        rounded-xl
                                        p-4">

                                <div class="flex gap-3">

                                    <i class="fa-solid fa-quote-left
                                              text-[#1b4d3e]
                                              text-sm
                                              mt-1"></i>

                                    <p class="text-sm
                                              leading-6
                                              text-gray-700">

                                        {{ $feedback->comment }}

                                    </p>

                                </div>

                            </div>

                        @else

                            <p class="text-sm italic text-gray-400">
                                Customer gave a rating without a comment.
                            </p>

                        @endif

                    </div>

                </div>

            @empty

                <!-- EMPTY STATE -->

                <div class="py-16 px-6 text-center">

                    <div class="w-16 h-16
                                mx-auto
                                rounded-full
                                bg-[#f2ece4]
                                flex items-center justify-center">

                        <i class="fa-solid fa-comments
                                  text-[#1b4d3e]
                                  text-xl"></i>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mt-5">
                        No feedback yet
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Customer feedback will appear here once customers review your completed orders.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</main>

@endsection