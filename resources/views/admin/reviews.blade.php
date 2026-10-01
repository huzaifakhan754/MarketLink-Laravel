@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-7xl space-y-6">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row
                md:items-center md:justify-between gap-4">

        <div>

            <div class="flex items-center gap-2 mb-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm text-gray-500
                          hover:text-[#1b4d3e] transition">

                    Dashboard

                </a>

                <i class="fa-solid fa-chevron-right
                          text-[9px] text-gray-400"></i>

                <span class="text-sm font-medium text-[#1b4d3e]">

                    Reviews

                </span>

            </div>


            <h1 class="text-2xl font-bold text-gray-900">

                Customer Reviews

            </h1>


            <p class="text-sm text-gray-500 mt-1">

                View all customer feedback and ratings.

            </p>

        </div>


        {{-- STATS --}}
        <div class="flex items-center gap-3">


            {{-- TOTAL --}}
            <div class="bg-white border border-gray-200
                        rounded-xl px-5 py-3 shadow-sm">

                <p class="text-[10px] text-gray-400
                          uppercase font-semibold">

                    Total Reviews

                </p>

                <p class="text-xl font-bold text-[#1b4d3e]">

                    {{ $totalReviews }}

                </p>

            </div>


            {{-- AVERAGE --}}
            <div class="bg-white border border-gray-200
                        rounded-xl px-5 py-3 shadow-sm">

                <p class="text-[10px] text-gray-400
                          uppercase font-semibold">

                    Average Rating

                </p>

                <div class="flex items-center gap-2">

                    <p class="text-xl font-bold text-[#1b4d3e]">

                        {{ number_format($averageRating, 1) }}

                    </p>

                    <i class="fa-solid fa-star
                              text-yellow-500 text-sm"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- REVIEWS --}}
    @if($reviews->count() > 0)

        <div class="space-y-4">

            @foreach($reviews as $review)

                <div class="bg-white border border-gray-200
                            rounded-2xl shadow-sm
                            hover:shadow-md transition">

                    <div class="p-5">


                        {{-- TOP ROW --}}
                        <div class="flex flex-col lg:flex-row
                                    lg:items-start
                                    lg:justify-between gap-4">


                            {{-- CUSTOMER --}}
                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-full
                                            bg-blue-50
                                            flex items-center
                                            justify-center
                                            shrink-0">

                                    <i class="fa-solid fa-user
                                              text-blue-600"></i>

                                </div>


                                <div>

                                    <p class="text-sm font-bold
                                              text-gray-900">

                                        {{ $review->customer->name ?? 'Unknown Customer' }}

                                    </p>


                                    <p class="text-xs text-gray-400">

                                        {{ $review->customer->email ?? 'No email available' }}

                                    </p>

                                </div>

                            </div>


                            {{-- RATING --}}
                            <div class="flex items-center gap-1">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $review->rating)

                                        <i class="fa-solid fa-star
                                                  text-yellow-500 text-sm"></i>

                                    @else

                                        <i class="fa-regular fa-star
                                                  text-gray-300 text-sm"></i>

                                    @endif

                                @endfor


                                <span class="ml-2 text-xs
                                             font-semibold text-gray-600">

                                    {{ $review->rating }}/5

                                </span>

                            </div>

                        </div>


                        {{-- REVIEW CONTENT --}}
                        <div class="mt-5">

                            <div class="bg-[#fdfbf7]
                                        border border-gray-100
                                        rounded-xl p-4">

                                <p class="text-sm text-gray-700
                                          leading-6">

                                    "{{ $review->comment }}"

                                </p>

                            </div>

                        </div>


                        {{-- DETAILS --}}
                        <div class="mt-5 pt-4
                                    border-t border-gray-100">

                            <div class="flex flex-wrap
                                        items-center gap-x-8 gap-y-3">


                                {{-- FARMER --}}
                                <div>

                                    <p class="text-[10px]
                                              uppercase
                                              font-semibold
                                              text-gray-400">

                                        Reviewed Farmer

                                    </p>

                                    <div class="flex items-center
                                                gap-2 mt-1">

                                        <div class="w-7 h-7
                                                    rounded-full
                                                    bg-orange-50
                                                    flex items-center
                                                    justify-center">

                                            <i class="fa-solid
                                                      fa-tractor
                                                      text-orange-600
                                                      text-[10px]"></i>

                                        </div>

                                        <div>

                                            <p class="text-xs
                                                      font-semibold
                                                      text-gray-800">

                                                {{ $review->farmer->farm_name ?? 'N/A' }}

                                            </p>

                                            <p class="text-[10px]
                                                      text-gray-400">

                                                {{ $review->farmer->user->name ?? 'N/A' }}

                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- PRODUCT --}}
                                <div>

                                    <p class="text-[10px]
                                              uppercase
                                              font-semibold
                                              text-gray-400">

                                        Product

                                    </p>

                                    <div class="flex items-center
                                                gap-2 mt-1">

                                        <div class="w-7 h-7
                                                    rounded-lg
                                                    bg-green-50
                                                    flex items-center
                                                    justify-center">

                                            <i class="fa-solid
                                                      fa-leaf
                                                      text-green-600
                                                      text-[10px]"></i>

                                        </div>

                                        <p class="text-xs
                                                  font-semibold
                                                  text-gray-800">

                                            {{ $review->order->product->name ?? 'N/A' }}

                                        </p>

                                    </div>

                                </div>


                                {{-- ORDER --}}
                                <div>

                                    <p class="text-[10px]
                                              uppercase
                                              font-semibold
                                              text-gray-400">

                                        Order

                                    </p>

                                    <p class="text-xs
                                              font-semibold
                                              text-gray-800 mt-2">

                                        #{{ $review->order_id }}

                                    </p>

                                </div>


                                {{-- DATE --}}
                                <div>

                                    <p class="text-[10px]
                                              uppercase
                                              font-semibold
                                              text-gray-400">

                                        Reviewed On

                                    </p>

                                    <p class="text-xs
                                              font-semibold
                                              text-gray-800 mt-2">

                                        {{ $review->created_at?->format('d M Y, h:i A') ?? 'N/A' }}

                                    </p>

                                </div>

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
                        bg-yellow-50
                        flex items-center justify-center">

                <i class="fa-solid fa-star
                          text-yellow-500 text-2xl"></i>

            </div>


            <h3 class="mt-4 text-lg font-bold text-gray-900">

                No Reviews Yet

            </h3>


            <p class="mt-1 text-sm text-gray-500">

                Customer feedback will appear here.

            </p>

        </div>

    @endif

</div>

@endsection