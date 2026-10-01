<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard — MarketLink</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#faf8f5] text-gray-800 font-sans flex flex-col min-h-screen justify-between">

    <!-- Header Banner & Navbar -->
    <div>

        <!-- Top Announcement Banner -->
        <div class="bg-[#005327] text-[#e2f1e7] text-xs text-center py-2 italic font-medium">
            Autumn harvest pre-orders are now open.
        </div>


        <!-- Main Navigation -->
        <header class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            <div class="flex items-center space-x-8">

                <a href="#" class="text-xl font-bold tracking-tight text-[#005327]">
                    MarketLink
                </a>

                <nav class="hidden md:flex items-center justify-center gap-8 absolute left-1/2 transform -translate-x-1/2 text-sm font-medium text-gray-600">
                    <!-- Dashoard -->
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-semibold border-b-2 border-primary pb-1">
                        My Dashboard
                    </a>
                    <!-- My Order -->
                       <a href="{{ route('customer.orders') }}"
                        class="text-sm font-medium text-foreground/80 hover:text-primary transition">
                        My Orders
                    </a>
                    <!-- Order history -->
                     <a href="{{ route('history') }}"
                        class="hover:text-[#005327] transition">
                        Order History
                    </a>
                    <!-- Update profile -->
                    <a
                        href="{{ url('/markets') }}"
                        class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                        Markets

                    </a>

                   
                  
                   



                </nav>

            </div>


            <div class="flex items-center space-x-4">

                <button class="p-2 text-gray-600 hover:text-black">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>

                <button class="p-2 text-gray-600 hover:text-black">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                </button>

                <!-- Logged-in User -->
                <div class="flex items-center gap-2">

                    <div class="w-8 h-8 rounded-full bg-[#005327] text-white
                                flex items-center justify-center text-xs font-bold">

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                    </div>

                    <span class="text-sm font-medium text-gray-700 hidden sm:block">
                        {{ $user->name }}
                    </span>

                </div>

            </div>

        </header>



        <!-- Main Content Container -->
        <main class="max-w-6xl mx-auto px-6 py-8">


            <!-- Top Greeting Subtitle -->
            <span class="text-xs font-bold tracking-wider text-amber-700 uppercase">

                GOOD MORNING, {{ strtoupper(explode(' ', $user->name)[0]) }}

            </span>


            <!-- Main Heading -->
            <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#005327] mt-1">

                Your market week, at a glance.

            </h1>


            <p class="text-gray-600 text-sm mt-1">

                Fresh picks, saved growers, and pickup details in one place.

            </p>



            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">


                <!-- Upcoming Pickups -->
                <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                    <div class="text-3xl font-bold text-[#005327]">

                        {{ $upcomingPickups }}

                    </div>

                    <div class="text-sm text-gray-600 font-medium">

                        Upcoming pickups

                    </div>

                </div>



                <!-- Pending Orders -->
                <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                    <div class="text-3xl font-bold text-[#005327]">

                        {{ $pendingOrders }}

                    </div>

                    <div class="text-sm text-gray-600 font-medium">

                        Pending orders

                    </div>

                </div>



                <!-- Total Spent -->
                <div class="bg-[#f2ece4] p-5 rounded-xl text-center">

                    <div class="text-3xl font-bold text-[#005327]">

                        ${{ number_format($spentLocally, 0) }}

                    </div>

                    <div class="text-sm text-gray-600 font-medium">

                        Spent locally

                    </div>

                </div>

            </div>



            <!-- Main Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">


                <!-- Next Pickup Card -->
                <div class="md:col-span-2 bg-white p-6 rounded-2xl
                            border border-gray-100 shadow-sm
                            flex flex-col justify-between">

                    <div>

                        <div class="flex justify-between items-center mb-4">

                            <h2 class="text-xl font-bold text-[#005327]">

                                Your next pickup

                            </h2>


                            @if($nextPickup)

                            <span class="
                                    bg-emerald-100
                                    text-emerald-800
                                    text-xs
                                    font-semibold
                                    px-2.5
                                    py-1
                                    rounded-full
                                ">

                                {{ ucfirst($nextPickup->status) }}

                            </span>

                            @else

                            <span class="
                                    bg-gray-100
                                    text-gray-600
                                    text-xs
                                    font-semibold
                                    px-2.5
                                    py-1
                                    rounded-full
                                ">

                                No pickup

                            </span>

                            @endif

                        </div>



                        @if($nextPickup)

                        <!-- Product Name -->
                        <h3 class="text-2xl font-serif font-bold text-[#005327] mt-2">

                            {{ $nextPickup->product->name ?? 'MarketLink Order' }}

                        </h3>


                        <!-- Product Details -->
                        <p class="text-sm text-gray-500 mt-1">

                            {{ $nextPickup->quantity ?? 1 }} item(s)

                            ·

                            ${{ number_format(
                                    ($nextPickup->price ?? 0) *
                                    ($nextPickup->quantity ?? 1),
                                    2
                                ) }}

                        </p>


                        @if($nextPickup->product && $nextPickup->product->farmer)

                        <p class="text-sm text-gray-500 mt-2">

                            Grower:
                            <span class="font-medium text-gray-700">

                                {{ $nextPickup->product->farmer->farm_name
                                            ?? $nextPickup->product->farmer->user->name
                                            ?? 'Local Grower'
                                        }}

                            </span>

                        </p>

                        @endif


                        @else

                        <h3 class="text-2xl font-serif font-bold text-[#005327] mt-2">

                            No upcoming pickup

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Browse fresh picks and place your first order.

                        </p>

                        @endif

                    </div>



                    <!-- View Order -->
                    <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">

                        <a href="{{ route('customer.orders') }}"
                            class="inline-flex items-center text-sm font-semibold
                                  text-[#005327] hover:underline">

                            View orders

                            <i data-lucide="arrow-right"
                                class="w-4 h-4 ml-1"></i>

                        </a>

                    </div>

                </div>



                <!-- Quick Links Card -->
                <div class="bg-[#005327] text-white p-6 rounded-2xl
                            flex flex-col justify-between">

                    <div>

                        <h2 class="text-xl font-serif font-bold mb-4">

                            Quick links

                        </h2>


                        <ul class="space-y-3 text-sm">


                            <!-- Fresh Picks -->
                            <li>

                                <a href="{{ route('products') }}"
                                    class="flex justify-between items-center
                                          text-gray-200 hover:text-white
                                          border-b border-emerald-800/50 pb-2">

                                    Browse fresh picks

                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4"></i>

                                </a>

                            </li>



                            <!-- Favorites -->
                            <li>

                                <a href="#"
                                    class="flex justify-between items-center
                                          text-gray-200 hover:text-white
                                          border-b border-emerald-800/50 pb-2">

                                    Saved favorites

                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4"></i>

                                </a>

                            </li>



                            <!-- Orders -->
                            <li>

                                <a href="{{ route('customer.orders') }}"
                                    class="flex justify-between items-center
                                          text-gray-200 hover:text-white pb-2">

                                    Order history

                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4"></i>

                                </a>

                            </li>


                        </ul>

                    </div>

                </div>

            </div>

        </main>

    </div>



    <!-- Footer -->
    <footer class="bg-[#005327] text-gray-300 py-12 px-6 mt-16
                   border-t border-emerald-900">

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">


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

                        <a href="#"
                            class="hover:text-white">

                            Grower access

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



        <div class="max-w-6xl mx-auto border-t border-emerald-800/60
                    mt-8 pt-6 text-xs text-gray-300
                    flex justify-between items-center">

            <p>

                © 2026 MarketLink · Demo experience · Pay in cash at pickup

            </p>

        </div>

    </footer>



    <!-- Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    @include('components.ai-chatbot')
</body>

</html>