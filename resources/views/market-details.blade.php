<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $market->name }} — MarketLink</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#fdfbf7',
                        foreground: '#22251e',

                        primary: {
                            DEFAULT: '#005327',
                            foreground: '#ffffff'
                        },

                        muted: {
                            DEFAULT: '#eae3d2',
                            foreground: '#66635b'
                        },

                        accent: {
                            DEFAULT: '#ca6232',
                            foreground: '#ffffff'
                        },

                        border: '#e6dfcf',
                        card: '#ffffff',
                    },

                    fontFamily: {
                        sans: ['"Work Sans"', 'sans-serif'],
                        display: ['"Fraunces"', 'serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fdfbf7;
            color: #22251e;
            font-family: 'Work Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Fraunces', serif;
        }

        #cartToast {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px);
            transition: all 0.3s ease;
        }

        #cartToast.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .farmer-section {
            scroll-margin-top: 100px;
        }
    </style>

</head>


<body class="min-h-screen bg-background text-foreground antialiased flex flex-col">


    <!-- ========================================================= -->
    <!-- ANNOUNCEMENT BAR -->
    <!-- ========================================================= -->

    <div class="bg-primary text-primary-foreground text-center py-2 text-xs font-semibold tracking-wide">
        Autumn harvest pre-orders are now open.
    </div>


    <!-- ========================================================= -->
    <!-- HEADER -->
    <!-- ========================================================= -->

    <header class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-16 items-center justify-between">


            <!-- LOGO -->

            <a href="/" class="flex items-center gap-2.5">

                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-primary text-primary-foreground">

                    <i data-lucide="leaf" class="size-5"></i>

                </span>

                <span class="font-display text-2xl font-bold text-primary">
                    MarketLink
                </span>

            </a>


            <!-- DESKTOP NAV -->

            <nav class="hidden md:flex items-center gap-7">

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

            <div class="flex items-center gap-2 sm:gap-3">


                <!-- FAVORITES -->

                <a href="/favorites"
                    aria-label="Favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i data-lucide="heart" class="size-5"></i>

                </a>


                <!-- CART COUNT -->

                @php

                $cart = session('cart', []);

                $cartCount = 0;

                foreach ($cart as $item) {
                $cartCount += $item['quantity'] ?? 0;
                }

                @endphp


                <!-- CART -->

                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center p-2 text-gray-700 hover:text-gray-900 transition"
                    aria-label="Shopping Cart">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />

                    </svg>


                    <span id="cartBadge"
                        class="absolute -top-1 -right-1 bg-[#1b4d3e] text-white text-[10px] font-bold w-5 h-5 items-center justify-center rounded-full shadow-xs
                          {{ $cartCount > 0 ? 'flex' : 'hidden' }}">

                        {{ $cartCount }}

                    </span>

                </a>


                <!-- SIGN IN -->

                <a href="/login" class="hidden sm:block">

                    <button class="border border-border bg-background hover:bg-black/5 h-8 rounded-md px-3 text-xs font-medium transition-colors">

                        Sign in

                    </button>

                </a>


                <!-- MOBILE -->

                <button id="menuBtn"
                    class="p-2 md:hidden text-foreground hover:text-primary transition focus:outline-none"
                    aria-label="Toggle Navigation">

                    <i data-lucide="menu"
                        id="menuIcon"
                        class="size-6"></i>

                    <i data-lucide="x"
                        id="closeIcon"
                        class="size-6 hidden"></i>

                </button>

            </div>

        </div>


        <!-- MOBILE MENU -->

        <div id="mobileMenu"
            class="hidden md:hidden border-b border-border bg-background px-6 py-5 shadow-lg">

            <nav class="flex flex-col gap-4">

                <a href="/markets"
                    class="text-base font-semibold text-primary">
                    Markets
                </a>

                <a href="/products"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">
                    Fresh Picks
                </a>

                <a href="/dashboard"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">
                    Farmer Studio
                </a>

                <a href="/admin"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">
                    Admin
                </a>

                <div class="pt-2 border-t border-border">

                    <a href="/login" class="block w-full">

                        <button class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white">
                            Sign in
                        </button>

                    </a>

                </div>

            </nav>

        </div>

    </header>


    <!-- ========================================================= -->
    <!-- CART TOAST -->
    <!-- ========================================================= -->

    <div id="cartToast"
        class="fixed top-24 right-5 z-[9999] px-5 py-3 rounded-xl shadow-xl text-white font-semibold flex items-center gap-2">

        <i id="toastIcon"
            class="fa-solid fa-circle-check"></i>

        <span id="toastMessage"></span>

    </div>


    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20 w-full">


        <!-- ========================================================= -->
        <!-- BACK BUTTON -->
        <!-- ========================================================= -->

        <a href="/markets"
            class="inline-flex items-center gap-2 text-sm font-semibold text-muted-foreground hover:text-primary transition mb-7">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Markets

        </a>


        <!-- ========================================================= -->
        <!-- MARKET HERO -->
        <!-- ========================================================= -->

        <section class="bg-white rounded-3xl border border-border shadow-sm overflow-hidden mb-10">

            <div class="grid lg:grid-cols-[0.9fr_1.1fr]">


                <!-- MARKET IMAGE -->

                <div class="h-72 lg:h-80 bg-gray-100 overflow-hidden">

                    @if($market->image)

                    <img src="{{ asset('storage/' . $market->image) }}"
                        alt="{{ $market->name }}"
                        class="w-full h-full object-cover">

                    @else

                    <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1200&q=80"
                        alt="{{ $market->name }}"
                        class="w-full h-full object-cover">

                    @endif

                </div>


                <!-- MARKET INFORMATION -->

                <div class="p-7 sm:p-10 flex flex-col justify-center">

                    <span class="text-xs font-bold tracking-widest uppercase text-accent">
                        MarketLink Market
                    </span>


                    <h1 class="text-4xl sm:text-5xl font-bold text-primary mt-2">
                        {{ $market->name }}
                    </h1>


                    <div class="flex items-start gap-3 mt-5">

                        <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">

                            <i class="fa-solid fa-location-dot text-primary"></i>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Location
                            </p>

                            <p class="text-sm text-muted-foreground mt-1">
                                {{ $market->location }}
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">


                        @if($market->days)

                        <div class="rounded-xl bg-[#fdfbf7] border border-border p-4">

                            <div class="flex items-center gap-2 text-primary">

                                <i class="fa-regular fa-calendar"></i>

                                <span class="text-xs font-bold uppercase tracking-wide">
                                    Market Days
                                </span>

                            </div>

                            <p class="text-sm font-semibold text-gray-800 mt-2">
                                {{ $market->days }}
                            </p>

                        </div>

                        @endif


                        @if($market->timing)

                        <div class="rounded-xl bg-[#fdfbf7] border border-border p-4">

                            <div class="flex items-center gap-2 text-primary">

                                <i class="fa-regular fa-clock"></i>

                                <span class="text-xs font-bold uppercase tracking-wide">
                                    Timing
                                </span>

                            </div>

                            <p class="text-sm font-semibold text-gray-800 mt-2">
                                {{ $market->timing }}
                            </p>

                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </section>


        <!-- ========================================================= -->
        <!-- MARKET STATS -->
        <!-- ========================================================= -->

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">


            <div class="bg-white border border-border rounded-2xl p-5 flex items-center gap-4">

                <div class="w-11 h-11 rounded-full bg-primary/10 flex items-center justify-center">

                    <i class="fa-solid fa-users text-primary"></i>

                </div>

                <div>

                    <p class="text-2xl font-bold text-primary">
                        {{ $market->farmers->count() }}
                    </p>

                    <p class="text-xs text-muted-foreground font-medium">
                        Farmers at this market
                    </p>

                </div>

            </div>


            <div class="bg-white border border-border rounded-2xl p-5 flex items-center gap-4">

                <div class="w-11 h-11 rounded-full bg-orange-50 flex items-center justify-center">

                    <i class="fa-solid fa-box-open text-accent"></i>

                </div>

                <div>

                    <p class="text-2xl font-bold text-primary">

                        {{ $market->farmers->sum(function ($farmer) {
                            return $farmer->products->count();
                        }) }}

                    </p>

                    <p class="text-xs text-muted-foreground font-medium">
                        Fresh products available
                    </p>

                </div>

            </div>


            <div class="bg-white border border-border rounded-2xl p-5 flex items-center gap-4">

                <div class="w-11 h-11 rounded-full bg-green-50 flex items-center justify-center">

                    <i class="fa-solid fa-leaf text-primary"></i>

                </div>

                <div>

                    <p class="text-2xl font-bold text-primary">
                        Fresh
                    </p>

                    <p class="text-xs text-muted-foreground font-medium">
                        Local harvests
                    </p>

                </div>

            </div>

        </div>


        <!-- ========================================================= -->
        <!-- FARMERS -->
        <!-- ========================================================= -->

        <section>

            <div class="mb-8">

                <span class="text-xs font-bold tracking-widest uppercase text-accent">
                    Local Growers
                </span>

                <h2 class="text-3xl sm:text-4xl font-bold text-primary mt-2">
                    Farmers at {{ $market->name }}
                </h2>

                <p class="mt-2 text-sm text-muted-foreground">
                    Explore products from farmers selling at this market.
                </p>

            </div>


            @if($market->farmers->count() > 0)


            <div class="space-y-10">


                @foreach($market->farmers as $farmer)

                <div class="farmer-section bg-white border border-border rounded-3xl shadow-sm overflow-hidden">


                    <!-- FARMER HEADER -->

                    <div class="p-5 sm:p-7 border-b border-border bg-[#fffefb]">

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">


                            <div class="flex items-center gap-4">


                                <!-- FARMER IMAGE -->

                                <div class="w-16 h-16 rounded-full overflow-hidden bg-primary/10 shrink-0">

                                    @if($farmer->image)

                                    <img src="{{ asset('storage/' . $farmer->image) }}"
                                        alt="{{ $farmer->farm_name }}"
                                        class="w-full h-full object-cover">

                                    @else

                                    <div class="w-full h-full flex items-center justify-center">

                                        <i class="fa-solid fa-user text-primary text-xl"></i>

                                    </div>

                                    @endif

                                </div>


                                <div>

                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900">

                                        {{ $farmer->farm_name ?: ($farmer->user->name ?? 'Local Farmer') }}

                                    </h3>


                                    @if($farmer->user)

                                    <p class="text-sm text-muted-foreground mt-1">

                                        <i class="fa-solid fa-user mr-1"></i>

                                        {{ $farmer->user->name }}

                                    </p>

                                    @endif


                                    @if($farmer->location)

                                    <p class="text-xs text-gray-400 mt-1">

                                        <i class="fa-solid fa-location-dot mr-1"></i>

                                        {{ $farmer->location }}

                                    </p>

                                    @endif

                                </div>

                            </div>


                            <!-- PRODUCT COUNT -->

                            <div class="self-start sm:self-center">

                                <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-xs font-bold">

                                    <i class="fa-solid fa-box"></i>

                                    {{ $farmer->products->count() }}

                                    {{ $farmer->products->count() == 1 ? 'Product' : 'Products' }}

                                </span>

                            </div>

                        </div>


                        @if($farmer->description)

                        <p class="mt-5 text-sm text-gray-600 leading-6 max-w-3xl">

                            {{ $farmer->description }}

                        </p>

                        @endif


                    </div>


                    <!-- FARMER PRODUCTS -->

                    <div class="p-5 sm:p-7">


                        @if($farmer->products->count() > 0)


                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">


                            @foreach($farmer->products as $product)


                            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">


                                <!-- IMAGE -->

                                <div class="relative h-48 bg-gray-100 overflow-hidden">


                                    @if($product->image)

                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">

                                    @else

                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">

                                        <i class="fa-solid fa-wheat-awn text-4xl mb-2"></i>

                                        <span class="text-xs font-medium">
                                            No Image
                                        </span>

                                    </div>

                                    @endif


                                    <!-- CATEGORY -->

                                    @if($product->category)

                                    <div class="absolute top-3 left-3">

                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-gray-800 rounded-full text-[11px] font-semibold shadow-sm">

                                            {{ $product->category->name }}

                                        </span>

                                    </div>

                                    @endif


                                </div>


                                <!-- DETAILS -->

                                <div class="p-4 flex flex-col justify-between flex-1">


                                    <div>

                                        <div class="flex items-start justify-between gap-2">

                                            <h3 class="font-serif text-lg font-bold text-gray-900 leading-snug">

                                                {{ $product->name }}

                                            </h3>

                                        </div>


                                        <p class="text-sm font-bold text-[#b85a3a] mt-2">

                                            PKR {{ number_format($product->price, 2) }}

                                            <span class="text-xs text-gray-500 font-medium">

                                                / {{ $product->unit ?? 'unit' }}

                                            </span>

                                        </p>


                                        @if($product->description)

                                        <p class="text-xs text-gray-500 mt-2 leading-5 line-clamp-2">

                                            {{ $product->description }}

                                        </p>

                                        @endif


                                        <!-- STOCK -->

                                        @if(isset($product->stock_quantity))

                                        <p class="text-xs mt-3 font-medium
                                                                {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-500' }}">

                                            @if($product->stock_quantity > 0)

                                            <i class="fa-solid fa-circle-check mr-1"></i>

                                            {{ $product->stock_quantity }} available

                                            @else

                                            <i class="fa-solid fa-circle-xmark mr-1"></i>

                                            Out of stock

                                            @endif

                                        </p>

                                        @endif

                                    </div>


                                    <!-- CART FORM -->

                                    @if($product->stock_quantity > 0)

                                    <form action="{{ route('cart.add') }}"
                                        method="POST"
                                        class="add-to-cart-form mt-4">

                                        @csrf

                                        <input type="hidden"
                                            name="product_id"
                                            value="{{ $product->id }}">


                                        <button type="submit"
                                            class="reserve-btn w-full bg-[#005327] hover:bg-[#003d1c] text-white font-semibold rounded-full py-2.5 transition">

                                            <i class="fa-solid fa-cart-plus mr-2"></i>

                                            Reserve Item

                                        </button>

                                    </form>

                                    @else

                                    <button disabled
                                        class="w-full mt-4 bg-gray-200 text-gray-400 font-semibold rounded-full py-2.5 cursor-not-allowed">

                                        Out of Stock

                                    </button>

                                    @endif


                                </div>

                            </div>


                            @endforeach

                        </div>


                        @else


                        <!-- NO PRODUCTS -->

                        <div class="py-12 text-center">

                            <div class="w-14 h-14 mx-auto rounded-full bg-primary/10 flex items-center justify-center">

                                <i class="fa-solid fa-box-open text-primary text-xl"></i>

                            </div>

                            <h4 class="text-lg font-bold text-gray-800 mt-4">
                                No products available
                            </h4>

                            <p class="text-sm text-gray-500 mt-1">
                                This farmer has not added any products yet.
                            </p>

                        </div>


                        @endif


                    </div>

                </div>


                @endforeach


            </div>


            @else


            <!-- NO FARMERS -->

            <div class="bg-white border border-border rounded-3xl py-20 text-center">

                <div class="w-16 h-16 mx-auto rounded-full bg-primary/10 flex items-center justify-center">

                    <i class="fa-solid fa-users-slash text-primary text-2xl"></i>

                </div>

                <h3 class="text-xl font-bold text-gray-800 mt-5">
                    No farmers found
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    There are currently no farmers registered at this market.
                </p>

                <a href="/markets"
                    class="inline-flex items-center gap-2 mt-6 bg-primary text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-[#003d1c] transition">

                    <i class="fa-solid fa-arrow-left"></i>

                    Back to Markets

                </a>

            </div>


            @endif

        </section>


    </main>


    <!-- ========================================================= -->
    <!-- FOOTER -->
    <!-- ========================================================= -->

    <footer class="border-t border-border bg-card w-full mt-auto">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 py-12 md:grid-cols-[1.2fr_0.8fr_0.8fr]">


            <div>

                <div class="flex items-center gap-2 text-primary">

                    <i data-lucide="leaf" class="size-6"></i>

                    <span class="font-display text-2xl font-bold">
                        MarketLink
                    </span>

                </div>

                <p class="mt-4 max-w-sm text-sm leading-6 text-muted-foreground">

                    Weekly harvests from the growers who make our neighborhoods taste like home.

                </p>

            </div>


            <div>

                <h3 class="text-base font-bold text-primary">
                    Explore
                </h3>

                <div class="mt-4 grid gap-2 text-sm text-muted-foreground">

                    <a href="/markets"
                        class="text-primary font-semibold">
                        Markets
                    </a>

                    <a href="/products"
                        class="hover:text-primary transition-colors">
                        Fresh picks
                    </a>

                    <a href="/login"
                        class="hover:text-primary transition-colors">
                        Grower access
                    </a>

                </div>

            </div>


            <div>

                <h3 class="text-base font-bold text-primary">
                    Visit us
                </h3>

                <p class="mt-4 text-sm leading-6 text-muted-foreground">

                    218 Market Lane<br>
                    River District<br>
                    hello@marketlink.local

                </p>

            </div>


        </div>


        <div class="border-t border-border py-4 text-center text-xs text-muted-foreground">

            © 2026 MarketLink · Demo experience · Pay in cash at pickup

        </div>

    </footer>


    <!-- ========================================================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================================================= -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // =====================================================
            // LUCIDE
            // =====================================================

            if (typeof lucide !== 'undefined') {

                lucide.createIcons();

            }


            // =====================================================
            // MOBILE MENU
            // =====================================================

            const menuBtn =
                document.getElementById('menuBtn');

            const mobileMenu =
                document.getElementById('mobileMenu');

            const menuIcon =
                document.getElementById('menuIcon');

            const closeIcon =
                document.getElementById('closeIcon');


            if (menuBtn) {

                menuBtn.addEventListener('click', function() {

                    mobileMenu.classList.toggle('hidden');

                    menuIcon.classList.toggle('hidden');

                    closeIcon.classList.toggle('hidden');

                });

            }


            // =====================================================
            // ADD TO CART WITHOUT PAGE RELOAD
            // =====================================================

            const cartForms =
                document.querySelectorAll('.add-to-cart-form');


            cartForms.forEach(function(form) {

                form.addEventListener('submit', async function(event) {

                    event.preventDefault();


                    const button =
                        form.querySelector('.reserve-btn');


                    if (!button) {
                        return;
                    }


                    const originalButtonHTML =
                        button.innerHTML;


                    button.disabled = true;


                    button.innerHTML = `
                        <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                        Adding...
                    `;


                    try {

                        const formData =
                            new FormData(form);


                        const csrfToken =
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).getAttribute('content');


                        const response =
                            await fetch(
                                form.action, {
                                    method: 'POST',

                                    headers: {

                                        'X-CSRF-TOKEN': csrfToken,

                                        'X-Requested-With': 'XMLHttpRequest',

                                        'Accept': 'application/json'

                                    },

                                    body: formData
                                }
                            );


                        const data =
                            await response.json();


                        if (
                            response.ok &&
                            data.success
                        ) {


                            const cartBadge =
                                document.getElementById(
                                    'cartBadge'
                                );


                            if (cartBadge) {

                                cartBadge.textContent =
                                    data.cartCount;

                                cartBadge.classList.remove(
                                    'hidden'
                                );

                                cartBadge.classList.add(
                                    'flex'
                                );

                            }


                            button.innerHTML = `
                                <i class="fa-solid fa-check mr-2"></i>
                                Added
                            `;


                            button.classList.remove(
                                'bg-[#005327]'
                            );


                            button.classList.add(
                                'bg-green-700'
                            );


                            showToast(
                                data.message,
                                true
                            );


                            setTimeout(function() {

                                button.innerHTML =
                                    originalButtonHTML;

                                button.classList.remove(
                                    'bg-green-700'
                                );

                                button.classList.add(
                                    'bg-[#005327]'
                                );

                                button.disabled =
                                    false;

                            }, 1500);


                        } else {


                            showToast(
                                data.message ||
                                'Unable to add item.',
                                false
                            );


                            button.innerHTML =
                                originalButtonHTML;

                            button.disabled =
                                false;

                        }


                    } catch (error) {

                        console.error(
                            'Add To Cart Error:',
                            error
                        );


                        showToast(
                            'Something went wrong. Please try again.',
                            false
                        );


                        button.innerHTML =
                            originalButtonHTML;

                        button.disabled =
                            false;

                    }

                });

            });


            // =====================================================
            // TOAST
            // =====================================================

            function showToast(message, success = true) {

                const toast =
                    document.getElementById(
                        'cartToast'
                    );


                const toastMessage =
                    document.getElementById(
                        'toastMessage'
                    );


                const toastIcon =
                    document.getElementById(
                        'toastIcon'
                    );


                if (!toast) {
                    return;
                }


                toastMessage.textContent =
                    message;


                toast.classList.remove(
                    'bg-green-600',
                    'bg-red-600'
                );


                if (success) {

                    toast.classList.add(
                        'bg-green-600'
                    );


                    toastIcon.className =
                        'fa-solid fa-circle-check';

                } else {

                    toast.classList.add(
                        'bg-red-600'
                    );


                    toastIcon.className =
                        'fa-solid fa-circle-exclamation';

                }


                toast.classList.add(
                    'show'
                );


                setTimeout(function() {

                    toast.classList.remove(
                        'show'
                    );

                }, 2500);

            }

        });
    </script>

@include('components.ai-chatbot')
</body>

</html>