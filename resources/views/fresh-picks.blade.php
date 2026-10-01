<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fresh Picks — MarketLink</title>

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
                        display: ['"Fraunces"', 'serif'],
                    }
                }
            }
        }
    </script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

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

        /* Toast Animation */
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
    </style>

</head>


<body class="min-h-screen bg-background text-foreground antialiased flex flex-col justify-between">
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


            <!-- DESKTOP NAVIGATION -->

            <nav class="hidden items-center gap-5 md:flex">

                <a href="{{ route('products') }}"
                    class="text-primary font-semibold border-b-2 border-primary pb-1">
                    Fresh Picks
                </a>

                <a href="{{ route('smart-basket.index') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">
                    Smart Basket
                </a>

                <a href="{{ route('price-compare.index') }}"
                    class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                    Price Compare
                </a>

                <a href="{{ route('compare-shopping.index') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">
                    Basket Saver
                </a>

                <a href="{{ route('markets') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">
                    Markets
                </a>
                <a href="{{ route('customer.dashboard') }}"
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


                <!-- ================================================= -->
                <!-- CART COUNT -->
                <!-- ================================================= -->

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


                    <!-- CART BADGE -->

                    <span id="cartBadge"

                          class="absolute -top-1 -right-1 bg-[#1b4d3e] text-white text-[10px] font-bold w-5 h-5 items-center justify-center rounded-full shadow-xs

                          {{ $cartCount > 0 ? 'flex' : 'hidden' }}">

                        {{ $cartCount }}

                    </span>

                </a>


                <!-- SIGN IN -->

                 @auth

                <form method="POST"
                    action="{{ route('logout') }}"
                    class="hidden sm:block">

                    @csrf

                    <button type="submit"
                        class="rounded-lg border border-primary/20 px-4 py-2 text-sm font-semibold text-primary hover:bg-primary hover:text-white transition">
                        Logout
                    </button>

                </form>

                @else

                <a href="{{ route('login') }}" class="hidden sm:inline-flex">
                    <button type="button"
                        class="rounded-lg border border-primary/20 px-4 py-2 text-sm font-semibold text-primary hover:bg-primary hover:text-white transition">
                        Sign in
                    </button>
                </a>

                @endauth


                <!-- MOBILE MENU BUTTON -->

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
                   class="text-base font-semibold text-foreground/80 hover:text-primary transition">
                    Markets
                </a>

                <a href="/products"
                   class="text-base font-semibold text-primary">
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20 w-full flex-grow">


        <!-- SUCCESS MESSAGE -->

        @if(session('success'))

            <div class="mb-5 p-4 text-sm font-semibold text-green-800 bg-green-100 border border-green-200 rounded-xl">

                <i class="fa-solid fa-circle-check mr-2"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- ERROR MESSAGE -->

        @if(session('error'))

            <div class="mb-5 p-4 text-sm font-semibold text-red-800 bg-red-100 border border-red-200 rounded-xl">

                <i class="fa-solid fa-circle-exclamation mr-2"></i>

                {{ session('error') }}

            </div>

        @endif


        <!-- ===================================================== -->
        <!-- HERO -->
        <!-- ===================================================== -->

        <section class="mb-8">

            <span class="text-xs font-bold tracking-widest uppercase text-accent">
                This Week's Harvest
            </span>

            <h1 class="text-4xl sm:text-6xl font-bold mt-2 text-primary">
                Fresh picks.
            </h1>

            <p id="item-count"
               class="mt-3 text-muted-foreground">

                Showing {{ $products->count() }}
                items ready to reserve for market-day pickup.

            </p>

        </section>


        <!-- ===================================================== -->
        <!-- FILTERS -->
        <!-- ===================================================== -->

        @php

            /*
            |--------------------------------------------------------------------------
            | GET CATEGORIES FROM DATABASE
            |--------------------------------------------------------------------------
            */

            $filterCategories = \App\Models\Category::orderBy('name', 'asc')->get();


            /*
            |--------------------------------------------------------------------------
            | GET MARKETS FROM DATABASE
            |--------------------------------------------------------------------------
            */

            $filterMarkets = \App\Models\Market::orderBy('name', 'asc')->get();

        @endphp


        <div class="bg-card p-4 rounded-xl border border-border shadow-sm mb-8 grid gap-4 sm:grid-cols-[1.5fr_1fr_1fr]">


            <!-- ================================================= -->
            <!-- PRODUCT NAME SEARCH -->
            <!-- ================================================= -->

            <div class="relative flex items-center">

                <i data-lucide="search"
                   class="absolute left-3.5 size-4 text-muted-foreground"></i>

                <input type="text"
                       id="searchInput"

                       name="name"

                       placeholder="Search product by name..."

                       autocomplete="off"

                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 transition">

            </div>


            <!-- ================================================= -->
            <!-- CATEGORY FILTER -->
            <!-- ================================================= -->

            <div class="relative">

                <select id="categoryFilter"
                        name="category"

                        class="w-full px-4 py-2.5 text-sm bg-background border border-border rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary/20 transition">

                    <option value="all">
                        All Categories
                    </option>


                    @foreach($filterCategories as $category)

                        <option value="{{ strtolower($category->name) }}">

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>


                <i data-lucide="chevron-down"
                   class="absolute right-3.5 top-3.5 size-4 text-muted-foreground pointer-events-none">
                </i>

            </div>


            <!-- ================================================= -->
            <!-- MARKET FILTER -->
            <!-- ================================================= -->

            <div class="relative">

                <select id="marketFilter"
                        name="market"

                        class="w-full px-4 py-2.5 text-sm bg-background border border-border rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary/20 transition">

                    <option value="all">
                        All Markets
                    </option>


                    @foreach($filterMarkets as $market)

                        <option value="{{ strtolower($market->name) }}">

                            {{ $market->name }}

                        </option>

                    @endforeach

                </select>


                <i data-lucide="chevron-down"
                   class="absolute right-3.5 top-3.5 size-4 text-muted-foreground pointer-events-none">
                </i>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- PRODUCTS -->
        <!-- ===================================================== -->

        <div class="bg-[#fcfbf7] min-h-screen py-2">

            <div class="max-w-7xl mx-auto space-y-6">


                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


                    @if($products->count() > 0)


                        @foreach($products as $product)


                            <div class="product-card bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden flex flex-col justify-between hover:shadow-md transition"

                                 data-name="{{ strtolower($product->name) }}"

                                 data-category="{{ strtolower($product->category->name ?? '') }}"

                                 data-market="{{ strtolower($product->market->name ?? '') }}">


                                <!-- IMAGE -->

                                <div class="relative h-52 bg-gray-100 overflow-hidden">


                                    @if($product->image)

                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover">

                                    @else

                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">

                                            <i class="fa-solid fa-wheat-awn text-4xl mb-1"></i>

                                            <span class="text-xs font-medium">
                                                No Image
                                            </span>

                                        </div>

                                    @endif


                                    @if($product->category)

                                        <div class="absolute top-3 left-3">

                                            <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-gray-800 rounded-full text-[11px] font-semibold shadow-xs">

                                                {{ $product->category->name }}

                                            </span>

                                        </div>

                                    @endif

                                </div>


                                <!-- DETAILS -->

                                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">


                                    <div>

                                        <div class="flex items-baseline justify-between gap-2">


                                            <h3 class="font-serif text-lg font-bold text-gray-900 leading-snug line-clamp-1">

                                                {{ $product->name }}

                                            </h3>


                                            <span class="text-sm font-bold text-[#b85a3a] whitespace-nowrap">

                                                PKR {{ number_format($product->price, 2) }}

                                                /

                                                {{ $product->unit ?? 'unit' }}

                                            </span>

                                        </div>


                                        <p class="text-xs text-gray-500 font-medium mt-1">

                                            {{ $product->user->name ?? 'Local Farm' }}

                                        </p>


                                        @if($product->market)

                                            <p class="text-xs text-gray-400 mt-1">

                                                <i class="fa-solid fa-location-dot mr-1"></i>

                                                {{ $product->market->name }}

                                            </p>

                                        @endif

                                    </div>


                                    <!-- ================================================= -->
                                    <!-- RESERVE FORM -->
                                    <!-- ================================================= -->

                                    <form action="{{ route('cart.add') }}"
                                          method="POST"
                                          class="add-to-cart-form mt-3">

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

                                </div>

                            </div>


                        @endforeach


                    @else


                        <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-gray-200/80">

                            <p class="text-gray-500 text-sm font-medium">

                                No fresh products available right now.

                            </p>

                        </div>


                    @endif

                </div>


                <!-- ================================================= -->
                <!-- NO RESULTS -->
                <!-- ================================================= -->

                <div id="noResults"
                     class="hidden py-20 text-center bg-white rounded-2xl border border-gray-200/80">

                    <div class="text-gray-300 mb-3">

                        <i class="fa-solid fa-filter-circle-xmark text-4xl"></i>

                    </div>

                    <p class="text-gray-500 text-sm font-medium">

                        No products match your filter criteria.

                    </p>

                </div>


                <!-- PAGINATION -->

                @if($products->hasPages())

                    <div class="pt-6">

                        {{ $products->links() }}

                    </div>

                @endif

            </div>

        </div>

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
                       class="hover:text-primary transition-colors">
                        Markets
                    </a>

                    <a href="/products"
                       class="text-primary font-semibold">
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
    <!-- ALL JAVASCRIPT -->
    <!-- ========================================================= -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            // =====================================================
            // LUCIDE ICONS
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

                menuBtn.addEventListener('click', function () {

                    mobileMenu.classList.toggle('hidden');

                    menuIcon.classList.toggle('hidden');

                    closeIcon.classList.toggle('hidden');

                });

            }


            // =====================================================
            // ADD TO CART - NO PAGE RELOAD
            // =====================================================

            const cartForms =
                document.querySelectorAll('.add-to-cart-form');


            cartForms.forEach(function (form) {

                form.addEventListener('submit', async function (event) {

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
                                form.action,
                                {
                                    method: 'POST',

                                    headers: {

                                        'X-CSRF-TOKEN':
                                            csrfToken,

                                        'X-Requested-With':
                                            'XMLHttpRequest',

                                        'Accept':
                                            'application/json'

                                    },

                                    body:
                                        formData
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


                            setTimeout(function () {

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
            // TOAST FUNCTION
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


                setTimeout(function () {

                    toast.classList.remove(
                        'show'
                    );

                }, 2500);

            }


            // =====================================================
            // SEARCH + CATEGORY + MARKET FILTER
            // =====================================================

            const searchInput =
                document.getElementById(
                    'searchInput'
                );


            const categoryFilter =
                document.getElementById(
                    'categoryFilter'
                );


            const marketFilter =
                document.getElementById(
                    'marketFilter'
                );


            const cards =
                document.querySelectorAll(
                    '.product-card'
                );


            const noResults =
                document.getElementById(
                    'noResults'
                );


            const itemCount =
                document.getElementById(
                    'item-count'
                );


            // =====================================================
            // FILTER FUNCTION
            // =====================================================

            function filterProducts() {


                const searchValue =
                    searchInput
                        ? searchInput.value
                            .toLowerCase()
                            .trim()
                        : '';


                const selectedCategory =
                    categoryFilter
                        ? categoryFilter.value
                            .toLowerCase()
                            .trim()
                        : 'all';


                const selectedMarket =
                    marketFilter
                        ? marketFilter.value
                            .toLowerCase()
                            .trim()
                        : 'all';


                let visibleCount = 0;


                cards.forEach(function (card) {


                    const name =
                        (
                            card.getAttribute(
                                'data-name'
                            ) || ''
                        )
                        .toLowerCase();


                    const category =
                        (
                            card.getAttribute(
                                'data-category'
                            ) || ''
                        )
                        .toLowerCase();


                    const market =
                        (
                            card.getAttribute(
                                'data-market'
                            ) || ''
                        )
                        .toLowerCase();


                    // =============================================
                    // NAME MATCH
                    // =============================================

                    const matchesName =
                        searchValue === '' ||
                        name.includes(searchValue);


                    // =============================================
                    // CATEGORY MATCH
                    // =============================================

                    const matchesCategory =
                        selectedCategory === 'all' ||
                        category === selectedCategory;


                    // =============================================
                    // MARKET MATCH
                    // =============================================

                    const matchesMarket =
                        selectedMarket === 'all' ||
                        market === selectedMarket;


                    // =============================================
                    // FINAL RESULT
                    // =============================================

                    if (
                        matchesName &&
                        matchesCategory &&
                        matchesMarket
                    ) {

                        card.style.display =
                            'flex';

                        visibleCount++;

                    } else {

                        card.style.display =
                            'none';

                    }

                });


                // =================================================
                // UPDATE ITEM COUNT
                // =================================================

                if (itemCount) {

                    itemCount.innerText =
                        `Showing ${visibleCount} items ready to reserve for market-day pickup.`;

                }


                // =================================================
                // NO RESULTS
                // =================================================

                if (noResults) {

                    if (visibleCount === 0) {

                        noResults.classList.remove(
                            'hidden'
                        );

                    } else {

                        noResults.classList.add(
                            'hidden'
                        );

                    }

                }

            }


            // =====================================================
            // NAME SEARCH
            // =====================================================

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterProducts
                );

            }


            // =====================================================
            // CATEGORY
            // =====================================================

            if (categoryFilter) {

                categoryFilter.addEventListener(
                    'change',
                    filterProducts
                );

            }


            // =====================================================
            // MARKET
            // =====================================================

            if (marketFilter) {

                marketFilter.addEventListener(
                    'change',
                    filterProducts
                );

            }

        });

    </script>
@include('components.ai-chatbot')
</body>

</html>