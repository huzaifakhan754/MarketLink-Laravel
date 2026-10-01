<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order History — MarketLink</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#faf8f5] text-gray-800 font-sans min-h-screen">

    <!-- ================= TOP BANNER ================= -->
    <div class="bg-[#005327] text-[#e2f1e7] text-xs text-center py-2 italic font-medium">
        Autumn harvest pre-orders are now open.
    </div>


    <!-- ================= NAVBAR ================= -->
    <header class="max-w-6xl mx-auto px-6 py-5 relative flex items-center justify-between">

        <!-- LEFT: LOGO -->
        <div class="flex items-center">

            <a href="{{ route('customer.dashboard') }}"
                class="text-xl font-bold tracking-tight text-[#005327]">
                MarketLink
            </a>

        </div>


        <!-- CENTER NAV -->
        <nav
            class="hidden md:flex items-center justify-center gap-8
                   absolute left-1/2 -translate-x-1/2
                   text-sm font-medium text-gray-600">

            <a
                href="{{ url('/markets') }}"
                class="text-primary font-semibold border-b-2 border-primary pb-1">

                Markets

            </a>

            <a
                href="{{ url('/products') }}"
                class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                Fresh Picks

            </a>
            <a
                href="{{ route('customer.orders') }}"
                class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                My Orders

            </a>
            <a
                href="{{ route('history') }}"
                class="hover:text-[#005327] transition">
                Order History
            </a>

            <a
                href="{{ route('customer.dashboard') }}"
                class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                My Dashboard

            </a>

        </nav>


        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-2">

            <!-- Search -->
            <button
                type="button"
                class="p-2 text-gray-600 hover:text-[#005327] transition">

                <i data-lucide="search" class="w-5 h-5"></i>

            </button>


            <!-- Heart -->
            <button
                type="button"
                class="p-2 text-gray-600 hover:text-[#005327] transition">

                <i data-lucide="heart" class="w-5 h-5"></i>

            </button>


            <!-- Cart -->
            <a href="{{ route('cart.index') }}"
                class="p-2 text-gray-600 hover:text-[#005327] transition">

                <i data-lucide="shopping-cart" class="w-5 h-5"></i>

            </a>


            <!-- User -->
            <div class="flex items-center gap-2 ml-1">

                <div
                    class="w-8 h-8 rounded-full bg-[#005327] text-white
                           flex items-center justify-center
                           text-xs font-bold">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <span class="text-sm font-medium text-gray-700 hidden sm:block">

                    {{ auth()->user()->name }}

                </span>

            </div>

        </div>

    </header>



    <!-- ================= MAIN ================= -->
    <main class="max-w-6xl mx-auto px-6 py-8">


        <!-- Greeting -->
        <span class="text-xs font-bold tracking-wider text-amber-700 uppercase">

            GOOD MORNING,
            {{ strtoupper(explode(' ', auth()->user()->name)[0]) }}

        </span>


        <!-- Heading -->
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#005327] mt-1">

            Your order history.

        </h1>


        <p class="text-gray-600 text-sm mt-1">

            View your completed MarketLink purchases and order details.

        </p>



        <!-- ================= SUMMARY CARDS ================= -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">


            <!-- Completed Orders -->
            <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                <div class="text-3xl font-bold text-[#005327]">

                    {{ $orders->count() }}

                </div>

                <div class="text-sm text-gray-600 font-medium">

                    Completed orders

                </div>

            </div>



            <!-- Total Items -->
            <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                <div class="text-3xl font-bold text-[#005327]">

                    {{ $orders->sum('quantity') }}

                </div>

                <div class="text-sm text-gray-600 font-medium">

                    Items purchased

                </div>

            </div>



            <!-- Total Spent -->
            <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                <div class="text-3xl font-bold text-[#005327]">

                    ${{ number_format(
                        $orders->sum(function ($order) {
                            return ($order->price ?? 0) * ($order->quantity ?? 1);
                        }),
                        2
                    ) }}

                </div>

                <div class="text-sm text-gray-600 font-medium">

                    Total spent

                </div>

            </div>

        </div>



        <!-- ================= ORDER HISTORY ================= -->
        <div class="mt-8">


            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">


                <!-- Header -->
                <div
                    class="px-6 py-5 border-b border-gray-100
                           flex items-center justify-between">

                    <div>

                        <h2 class="text-xl font-bold text-[#005327]">

                            Completed orders

                        </h2>

                        <p class="text-sm text-gray-500 mt-1">

                            Your previous MarketLink purchases.

                        </p>

                    </div>


                    <a href="{{ route('products') }}"
                        class="hidden sm:inline-flex items-center
                              text-sm font-semibold
                              text-[#005327] hover:underline">

                        Shop fresh picks

                        <i data-lucide="arrow-right"
                            class="w-4 h-4 ml-1"></i>

                    </a>

                </div>



                <!-- ================= ORDERS ================= -->

                @if($orders->count() > 0)

                <div class="divide-y divide-gray-100">


                    @foreach($orders as $order)

                    <div class="p-6 hover:bg-[#faf8f5] transition">


                        <div
                            class="flex flex-col md:flex-row
                                           md:items-center
                                           md:justify-between
                                           gap-5">


                            <!-- PRODUCT -->
                            <div class="flex items-center gap-4">


                                <!-- Product Image -->
                                <div
                                    class="w-20 h-20 rounded-xl
                                                   bg-[#f2ece4]
                                                   overflow-hidden
                                                   flex-shrink-0">

                                    @if($order->product && $order->product->image)

                                    <img
                                        src="{{ asset('storage/' . $order->product->image) }}"
                                        alt="{{ $order->product->name }}"
                                        class="w-full h-full object-cover">

                                    @else

                                    <div
                                        class="w-full h-full
                                                           flex items-center
                                                           justify-center
                                                           text-[#005327]">

                                        <i data-lucide="leaf"
                                            class="w-8 h-8"></i>

                                    </div>

                                    @endif

                                </div>



                                <!-- Product Info -->
                                <div>

                                    <h3
                                        class="text-lg font-bold
                                                       text-[#005327]">

                                        {{ $order->product->name ?? 'MarketLink Product' }}

                                    </h3>


                                    <p class="text-sm text-gray-500 mt-1">

                                        Order #{{ $order->id }}

                                    </p>


                                    <p class="text-sm text-gray-500 mt-1">

                                        {{ $order->created_at->format('d M Y') }}

                                    </p>

                                </div>

                            </div>



                            <!-- ORDER DETAILS -->
                            <div
                                class="flex flex-wrap
                                               items-center gap-6">


                                <!-- Quantity -->
                                <div>

                                    <p
                                        class="text-xs
                                                       text-gray-400
                                                       uppercase
                                                       tracking-wide">

                                        Quantity

                                    </p>

                                    <p
                                        class="text-sm
                                                       font-semibold
                                                       text-gray-700
                                                       mt-1">

                                        {{ $order->quantity }}

                                    </p>

                                </div>



                                <!-- Price -->
                                <div>

                                    <p
                                        class="text-xs
                                                       text-gray-400
                                                       uppercase
                                                       tracking-wide">

                                        Price

                                    </p>

                                    <p
                                        class="text-sm
                                                       font-semibold
                                                       text-gray-700
                                                       mt-1">

                                        ${{ number_format($order->price ?? 0, 2) }}

                                    </p>

                                </div>



                                <!-- Total -->
                                <div>

                                    <p
                                        class="text-xs
                                                       text-gray-400
                                                       uppercase
                                                       tracking-wide">

                                        Total

                                    </p>

                                    <p
                                        class="text-base
                                                       font-bold
                                                       text-[#005327]
                                                       mt-1">

                                        ${{ number_format(
                                                    ($order->price ?? 0) *
                                                    ($order->quantity ?? 1),
                                                    2
                                                ) }}

                                    </p>

                                </div>



                                <!-- Status -->
                                <span
                                    class="bg-emerald-100
                                                   text-emerald-800
                                                   text-xs
                                                   font-semibold
                                                   px-3 py-1.5
                                                   rounded-full">

                                    Completed

                                </span>
                                <!-- Feedback Button -->
                                @if($order->feedback)

                                <div class="text-center">

                                    <span
                                        class="inline-flex items-center
                   gap-1
                   bg-[#f2ece4]
                   text-[#005327]
                   text-xs
                   font-semibold
                   px-3 py-1.5
                   rounded-full">

                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>

                                        Feedback Given

                                    </span>

                                </div>

                                @else

                                <button
                                    type="button"
                                    onclick="openFeedbackModal({{ $order->id }})"
                                    class="inline-flex items-center
               gap-2
               bg-[#005327]
               text-white
               px-4 py-2
               rounded-lg
               text-xs
               font-semibold
               hover:bg-[#003d1c]
               transition">

                                    <i data-lucide="message-square" class="w-4 h-4"></i>

                                    Give Feedback

                                </button>

                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                @else


                <!-- ================= EMPTY STATE ================= -->

                <div class="px-6 py-16 text-center">


                    <div
                        class="w-16 h-16 mx-auto
                                   rounded-full
                                   bg-[#f2ece4]
                                   flex items-center
                                   justify-center
                                   text-[#005327]">

                        <i data-lucide="shopping-bag"
                            class="w-7 h-7"></i>

                    </div>


                    <h3
                        class="text-xl font-serif
                                   font-bold
                                   text-[#005327]
                                   mt-5">

                        No completed orders yet.

                    </h3>


                    <p
                        class="text-sm text-gray-500
                                   mt-2 max-w-md mx-auto">

                        Your completed purchases will appear here
                        once you place and complete an order.

                    </p>


                    <a
                        href="{{ route('products') }}"
                        class="inline-flex items-center
                                   mt-6
                                   bg-[#005327]
                                   text-white
                                   px-5 py-2.5
                                   rounded-lg
                                   text-sm
                                   font-semibold
                                   hover:bg-[#003d1c]
                                   transition">

                        Browse fresh picks

                        <i data-lucide="arrow-right"
                            class="w-4 h-4 ml-2"></i>

                    </a>

                </div>

                @endif

            </div>

        </div>

        <!-- ================= FEEDBACK MODAL ================= -->

        <div id="feedbackModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

            <div
                class="bg-white rounded-2xl
               shadow-2xl
               w-full max-w-md
               p-6">

                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h2 class="text-xl font-bold text-[#005327]">
                            Give Feedback
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Share your experience with the farmer.
                        </p>

                    </div>

                    <button
                        type="button"
                        onclick="closeFeedbackModal()"
                        class="text-gray-400 hover:text-gray-700">

                        <i data-lucide="x" class="w-5 h-5"></i>

                    </button>

                </div>


                <!-- Form -->
                <form
                    id="feedbackForm"
                    method="POST">

                    @csrf


                    <!-- Rating -->
                    <div class="mb-5">

                        <label
                            class="block text-sm font-semibold
                           text-gray-700 mb-2">

                            Rating

                        </label>


                        <div
                            class="flex items-center gap-2"
                            id="ratingStars">


                            @for($i = 1; $i <= 5; $i++)

                                <button
                                type="button"
                                onclick="selectRating({{ $i }})"
                                class="rating-star text-gray-300
                                   hover:text-yellow-400
                                   transition">

                                <i
                                    data-lucide="star"
                                    class="w-8 h-8">
                                </i>

                                </button>

                                @endfor

                        </div>


                        <input
                            type="hidden"
                            name="rating"
                            id="ratingInput"
                            value="">

                    </div>


                    <!-- Comment -->
                    <div class="mb-5">

                        <label
                            for="comment"
                            class="block text-sm font-semibold
                           text-gray-700 mb-2">

                            Your Feedback

                        </label>


                        <textarea
                            name="comment"
                            id="comment"
                            rows="4"
                            maxlength="1000"
                            placeholder="Tell the farmer about your experience..."
                            class="w-full border border-gray-200
                           rounded-xl
                           px-4 py-3
                           text-sm
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#005327]/20
                           focus:border-[#005327]"></textarea>

                    </div>


                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeFeedbackModal()"
                            class="px-4 py-2.5
                           rounded-lg
                           text-sm font-semibold
                           text-gray-600
                           bg-gray-100
                           hover:bg-gray-200">

                            Cancel

                        </button>


                        <button
                            type="submit"
                            class="px-5 py-2.5
                           rounded-lg
                           text-sm font-semibold
                           bg-[#005327]
                           text-white
                           hover:bg-[#003d1c]
                           transition">

                            Submit Feedback

                        </button>

                    </div>

                </form>

            </div>

        </div>


    </main>



    <!-- ================= FOOTER ================= -->
    <footer
        class="bg-[#005327] text-gray-300
               py-12 px-6 mt-16
               border-t border-emerald-900">


        <div
            class="max-w-6xl mx-auto
                   grid grid-cols-1 md:grid-cols-3 gap-8">


            <!-- Brand -->
            <div>

                <h3 class="text-xl font-bold text-white mb-2">

                    MarketLink

                </h3>

                <p class="text-sm text-gray-200 max-w-xs">

                    Weekly harvests from the growers who make our
                    neighborhoods taste like home.

                </p>

            </div>



            <!-- Explore -->
            <div>

                <h4 class="text-sm font-semibold text-white mb-3">

                    Explore

                </h4>

                <ul class="space-y-2 text-sm text-gray-200">

                    <li>

                        <a href="{{ route('markets') }}"
                            class="hover:text-white">

                            Markets

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('products') }}"
                            class="hover:text-white">

                            Fresh picks

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('customer.dashboard') }}"
                            class="hover:text-white">

                            Dashboard

                        </a>

                    </li>

                </ul>

            </div>



            <!-- Visit -->
            <div>

                <h4 class="text-sm font-semibold text-white mb-3">

                    Visit us

                </h4>

                <p class="text-sm text-gray-200">

                    218 Market Lane River District

                </p>

                <p class="text-sm text-gray-200">

                    hello@marketlink.local

                </p>

            </div>

        </div>



        <!-- Bottom -->
        <div
            class="max-w-6xl mx-auto
                   border-t border-emerald-800/60
                   mt-8 pt-6
                   text-xs text-gray-300
                   flex justify-between items-center">

            <p>

                © 2026 MarketLink · Demo experience · Pay in cash at pickup

            </p>

        </div>

    </footer>



    <!-- Lucide -->
    <script>
        lucide.createIcons();
    </script>

    <script>
        let selectedRating = 0;


        function openFeedbackModal(orderId) {
            const modal = document.getElementById('feedbackModal');

            const form = document.getElementById('feedbackForm');

            form.action = `/history/${orderId}/feedback`;

            document.getElementById('ratingInput').value = '';

            selectedRating = 0;

            updateStars();

            document.getElementById('comment').value = '';

            modal.classList.remove('hidden');

            modal.classList.add('flex');

            lucide.createIcons();
        }


        function closeFeedbackModal() {
            const modal = document.getElementById('feedbackModal');

            modal.classList.add('hidden');

            modal.classList.remove('flex');
        }


        function selectRating(rating) {
            selectedRating = rating;

            document.getElementById('ratingInput').value = rating;

            updateStars();
        }


        function updateStars() {
            const stars = document.querySelectorAll('.rating-star');

            stars.forEach((star, index) => {

                const icon = star.querySelector('svg');

                if (index < selectedRating) {

                    star.classList.remove('text-gray-300');

                    star.classList.add('text-yellow-400');

                } else {

                    star.classList.remove('text-yellow-400');

                    star.classList.add('text-gray-300');

                }

            });
        }


        // Close modal by clicking outside
        document.getElementById('feedbackModal')
            .addEventListener('click', function(event) {

                if (event.target === this) {

                    closeFeedbackModal();

                }

            });


        lucide.createIcons();
    </script>
    @include('components.ai-chatbot')
</body>

</html>