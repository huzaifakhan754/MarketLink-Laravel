<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Price Compare · MarketLink</title>

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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: "Work Sans", sans-serif;
            background: #fdfbf7;
            color: #22251e;
        }

        .display-font {
            font-family: "Fraunces", serif;
        }

        .compare-card {
            transition: all .25s ease;
        }

        .compare-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 83, 39, .10);
        }

        .best-card {
            border: 2px solid #005327;
            background: linear-gradient(
                135deg,
                rgba(0, 83, 39, .05),
                rgba(255, 255, 255, 1)
            );
        }

        .price-number {
            font-family: "Fraunces", serif;
        }

        .loader {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .fade-up {
            animation: fadeUp .35s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <header class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="h-20 flex items-center justify-between">

                <!-- Logo -->
                <a href="{{ route('homepage') }}"
                   class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                        <i data-lucide="leaf"
                           class="w-5 h-5 text-white"></i>
                    </div>

                    <span class="display-font text-2xl font-semibold text-primary">
                        MarketLink
                    </span>

                </a>


                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-7">

                    <a href="{{ route('markets') }}"
                       class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                        Markets
                    </a>

                    <a href="{{ route('products') }}"
                       class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                        Fresh Picks
                    </a>

                    <a href="{{ route('price-compare.index') }}"
                       class="relative text-sm font-semibold text-primary">
                        Price Compare

                        <span class="absolute -bottom-7 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    </a>

                    <a href="{{ route('customer.orders') }}"
                       class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                        My Orders
                    </a>

                    <a href="{{ route('history') }}"
                       class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                        Order History
                    </a>

                    <a href="{{ route('customer.dashboard') }}"
                       class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                        Dashboard
                    </a>

                </nav>


                <!-- Right -->
                <div class="hidden lg:flex items-center gap-3">

                    <a href="/favorites"
                       class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-muted transition"
                       title="Favorites">

                        <i data-lucide="heart"
                           class="w-5 h-5"></i>

                    </a>


                    <a href="{{ route('cart.index') }}"
                       class="relative w-10 h-10 rounded-full flex items-center justify-center hover:bg-muted transition"
                       title="Cart">

                        <i data-lucide="shopping-cart"
                           class="w-5 h-5"></i>

                        @php
                            $cart = session('cart', []);
                            $cartCount = 0;

                            foreach ($cart as $item) {
                                $cartCount += (int) ($item['quantity'] ?? 0);
                            }
                        @endphp

                        @if($cartCount > 0)

                            <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-accent text-white text-[10px] font-bold flex items-center justify-center">
                                {{ $cartCount }}
                            </span>

                        @endif

                    </a>


                    @auth

                        <a href="{{ route('customer.dashboard') }}"
                           class="ml-2 px-5 py-2.5 rounded-full bg-primary text-white text-sm font-semibold hover:opacity-90 transition">
                            Dashboard
                        </a>

                    @else

                        <a href="{{ route('login') }}"
                           class="ml-2 px-5 py-2.5 rounded-full bg-primary text-white text-sm font-semibold hover:opacity-90 transition">
                            Sign in
                        </a>

                    @endauth

                </div>


                <!-- Mobile Button -->
                <button id="menuBtn"
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-muted">

                    <i id="menuIcon"
                       data-lucide="menu"
                       class="w-6 h-6"></i>

                    <i id="closeIcon"
                       data-lucide="x"
                       class="w-6 h-6 hidden"></i>

                </button>

            </div>

        </div>


        <!-- Mobile Menu -->
        <div id="mobileMenu"
             class="hidden lg:hidden border-t border-border bg-background">

            <div class="max-w-7xl mx-auto px-5 py-5 space-y-2">

                <a href="{{ route('markets') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Markets
                </a>

                <a href="{{ route('products') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Fresh Picks
                </a>

                <a href="{{ route('price-compare.index') }}"
                   class="block px-4 py-3 rounded-xl bg-primary text-white font-semibold">
                    Price Compare
                </a>

                <a href="{{ route('customer.orders') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    My Orders
                </a>

                <a href="{{ route('history') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Order History
                </a>

                <a href="{{ route('customer.dashboard') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    My Dashboard
                </a>

                <a href="{{ route('cart.index') }}"
                   class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Cart
                </a>

            </div>

        </div>

    </header>


    <!-- =========================================================
         HERO
    ========================================================== -->

    <main>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10">

            <div class="max-w-3xl">

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-semibold mb-5">

                    <i data-lucide="badge-percent"
                       class="w-4 h-4"></i>

                    Smart Price Comparison

                </div>


                <h1 class="display-font text-4xl sm:text-5xl lg:text-6xl font-semibold leading-tight">

                    Find the
                    <span class="text-primary">
                        best price
                    </span>
                    before you buy.

                </h1>


                <p class="mt-5 text-base sm:text-lg text-muted-foreground max-w-2xl leading-7">

                    Compare the same fresh product across different MarketLink
                    markets and find where you can get it for the lowest available price.

                </p>

            </div>

        </section>


        <!-- =====================================================
             SELECT PRODUCT
        ====================================================== -->

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <div class="bg-white border border-border rounded-3xl shadow-sm p-6 sm:p-8">

                <div class="flex flex-col lg:flex-row lg:items-end gap-6">

                    <div class="flex-1">

                        <label class="block text-sm font-semibold mb-2">
                            Select a product
                        </label>

                        <div class="relative">

                            <i data-lucide="search"
                               class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                            <select id="productSelect"
                                    class="w-full h-14 pl-12 pr-5 rounded-2xl border border-border bg-background outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary appearance-none">

                                <option value="">
                                    Choose a product to compare...
                                </option>

                                @foreach($products as $product)

                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                        @if($product->unit)
                                            · per {{ $product->unit }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <button id="compareBtn"
                            type="button"
                            class="h-14 px-7 rounded-2xl bg-primary text-white font-semibold flex items-center justify-center gap-3 hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">

                        <i data-lucide="scale"
                           class="w-5 h-5"></i>

                        <span id="compareText">
                            Compare Prices
                        </span>

                        <span id="compareLoader"
                              class="loader hidden"></span>

                    </button>

                </div>

            </div>

        </section>


        <!-- =====================================================
             EMPTY STATE
        ====================================================== -->

        <section id="emptyState"
                 class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

            <div class="border border-dashed border-border rounded-3xl py-20 text-center">

                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-5">

                    <i data-lucide="scale"
                       class="w-8 h-8 text-primary"></i>

                </div>

                <h2 class="display-font text-2xl font-semibold">
                    Compare market prices
                </h2>

                <p class="text-muted-foreground mt-2">
                    Select a product above to see prices from different markets.
                </p>

            </div>

        </section>


        <!-- =====================================================
             RESULTS
        ====================================================== -->

        <section id="resultsSection"
                 class="hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

            <!-- Result Header -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">

                <div>

                    <p class="text-sm text-muted-foreground mb-1">
                        Comparing prices for
                    </p>

                    <h2 id="resultProduct"
                        class="display-font text-3xl sm:text-4xl font-semibold">
                        Tomatoes
                    </h2>

                </div>


                <!-- Best Price -->
                <div class="bg-primary text-white rounded-2xl px-6 py-4">

                    <div class="flex items-center gap-2 text-sm opacity-90">

                        <i data-lucide="badge-check"
                           class="w-4 h-4"></i>

                        Lowest available price

                    </div>

                    <div class="mt-1">

                        <span id="lowestPrice"
                              class="price-number text-3xl font-bold">
                            Rs. 0
                        </span>

                        <span id="lowestUnit"
                              class="text-sm opacity-80">
                            /kg
                        </span>

                    </div>

                </div>

            </div>


            <!-- Cards -->
            <div id="comparisonGrid"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            </div>


            <!-- No Results -->
            <div id="noResults"
                 class="hidden border border-border rounded-3xl py-16 text-center">

                <div class="w-14 h-14 rounded-2xl bg-muted flex items-center justify-center mx-auto mb-4">

                    <i data-lucide="search-x"
                       class="w-7 h-7 text-muted-foreground"></i>

                </div>

                <h3 class="display-font text-2xl font-semibold">
                    No comparison data found
                </h3>

                <p class="text-muted-foreground mt-2">
                    This product is not currently available in multiple markets.
                </p>

            </div>

        </section>

    </main>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>

        const compareUrl = @json(route('price-compare.compare'));
        const csrfToken = @json(csrf_token());
        const cartUrl = @json(route('cart.add'));

        const productSelect = document.getElementById('productSelect');
        const compareBtn = document.getElementById('compareBtn');

        const compareText = document.getElementById('compareText');
        const compareLoader = document.getElementById('compareLoader');

        const emptyState = document.getElementById('emptyState');
        const resultsSection = document.getElementById('resultsSection');

        const resultProduct = document.getElementById('resultProduct');
        const lowestPrice = document.getElementById('lowestPrice');
        const lowestUnit = document.getElementById('lowestUnit');

        const comparisonGrid = document.getElementById('comparisonGrid');
        const noResults = document.getElementById('noResults');


        // =====================================================
        // COMPARE
        // =====================================================

        compareBtn.addEventListener('click', async function () {

            const productId = productSelect.value;

            if (!productId) {

                productSelect.focus();

                productSelect.classList.add(
                    'border-red-400',
                    'ring-2',
                    'ring-red-100'
                );

                setTimeout(() => {

                    productSelect.classList.remove(
                        'border-red-400',
                        'ring-2',
                        'ring-red-100'
                    );

                }, 1500);

                return;
            }


            compareBtn.disabled = true;

            compareText.textContent = 'Comparing...';

            compareLoader.classList.remove('hidden');


            try {

                const response = await fetch(compareUrl, {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },

                    body: JSON.stringify({
                        product_id: productId
                    })

                });


                const data = await response.json();


                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message || 'Unable to compare prices.'
                    );

                }


                renderResults(data);

            } catch (error) {

                console.error(error);

                alert(
                    error.message ||
                    'Something went wrong while comparing prices.'
                );

            } finally {

                compareBtn.disabled = false;

                compareText.textContent = 'Compare Prices';

                compareLoader.classList.add('hidden');

            }

        });


        // =====================================================
        // RENDER RESULTS
        // =====================================================

        function renderResults(data) {

            emptyState.classList.add('hidden');

            resultsSection.classList.remove('hidden');

            resultsSection.classList.add('fade-up');


            resultProduct.textContent = data.product;


            if (data.lowest_price !== null) {

                lowestPrice.textContent =
                    'Rs. ' + formatPrice(data.lowest_price);

            } else {

                lowestPrice.textContent = 'Not available';

            }


            lowestUnit.textContent =
                data.unit ? '/' + data.unit : '';


            comparisonGrid.innerHTML = '';

            noResults.classList.add('hidden');


            if (!data.comparisons || data.comparisons.length === 0) {

                noResults.classList.remove('hidden');

                return;

            }


            const cheapestPrice =
                Math.min(
                    ...data.comparisons.map(item => Number(item.price))
                );


            data.comparisons.forEach((item, index) => {

                const isBest =
                    Number(item.price) === cheapestPrice;


                comparisonGrid.innerHTML += createComparisonCard(
                    item,
                    isBest,
                    index
                );

            });


            lucide.createIcons();

        }


        // =====================================================
        // CARD
        // =====================================================

        function createComparisonCard(item, isBest, index) {

            const imageHtml = item.image
                ? `
                    <img
                        src="/storage/${escapeHtml(item.image)}"
                        alt="${escapeHtml(item.product_name)}"
                        class="w-full h-full object-cover"
                        onerror="this.style.display='none';"
                    >
                  `
                : `
                    <div class="w-full h-full flex items-center justify-center bg-muted">

                        <i data-lucide="shopping-basket"
                           class="w-8 h-8 text-primary/40"></i>

                    </div>
                  `;


            return `

                <div class="
                    compare-card
                    ${isBest ? 'best-card' : 'border border-border'}
                    bg-white
                    rounded-3xl
                    overflow-hidden
                    fade-up
                "
                style="animation-delay:${index * 70}ms">

                    <!-- Product Image -->

                    <div class="relative h-52 bg-muted">

                        ${imageHtml}


                        ${
                            isBest
                            ? `
                                <div class="absolute top-4 left-4">

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-primary text-white text-xs font-bold shadow">

                                        <i data-lucide="badge-check"
                                           class="w-4 h-4"></i>

                                        BEST PRICE

                                    </span>

                                </div>
                              `
                            : ''
                        }

                    </div>


                    <!-- Content -->

                    <div class="p-6">

                        <!-- Market -->

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-xs text-muted-foreground uppercase tracking-wider font-semibold">
                                    Market
                                </p>

                                <h3 class="display-font text-2xl font-semibold mt-1">
                                    ${escapeHtml(item.market_name)}
                                </h3>

                            </div>


                            <div class="text-right">

                                <p class="price-number text-3xl font-bold text-primary">
                                    Rs. ${formatPrice(item.price)}
                                </p>

                                <p class="text-xs text-muted-foreground">
                                    per ${escapeHtml(item.unit)}
                                </p>

                            </div>

                        </div>


                        <!-- Location -->

                        <div class="mt-5 space-y-2">

                            ${
                                item.market_location
                                ? `
                                    <div class="flex items-center gap-2 text-sm text-muted-foreground">

                                        <i data-lucide="map-pin"
                                           class="w-4 h-4 text-primary"></i>

                                        ${escapeHtml(item.market_location)}

                                    </div>
                                  `
                                : ''
                            }


                            ${
                                item.market_timing
                                ? `
                                    <div class="flex items-center gap-2 text-sm text-muted-foreground">

                                        <i data-lucide="clock"
                                           class="w-4 h-4 text-primary"></i>

                                        ${escapeHtml(item.market_timing)}

                                    </div>
                                  `
                                : ''
                            }


                            <div class="flex items-center gap-2 text-sm text-muted-foreground">

                                <i data-lucide="package-check"
                                   class="w-4 h-4 text-primary"></i>

                                ${item.stock_quantity} ${escapeHtml(item.unit)} available

                            </div>

                        </div>


                        <!-- Price Difference -->

                        ${
                            isBest
                            ? `
                                <div class="mt-5 p-3 rounded-xl bg-primary/10 text-primary text-sm font-semibold flex items-center gap-2">

                                    <i data-lucide="trending-down"
                                       class="w-4 h-4"></i>

                                    Lowest price available

                                </div>
                              `
                            : `
                                <div class="mt-5 p-3 rounded-xl bg-background text-muted-foreground text-sm">

                                    Compare with the best price above.

                                </div>
                              `
                        }


                        <!-- Add To Cart -->

                        <form
                            action="${cartUrl}"
                            method="POST"
                            class="mt-5"
                        >

                            <input
                                type="hidden"
                                name="_token"
                                value="${csrfToken}"
                            >

                            <input
                                type="hidden"
                                name="product_id"
                                value="${item.product_id}"
                            >

                            <input
                                type="hidden"
                                name="quantity"
                                value="1"
                            >

                            <button
                                type="submit"
                                class="
                                    w-full
                                    h-12
                                    rounded-xl
                                    ${isBest
                                        ? 'bg-primary text-white'
                                        : 'bg-muted text-foreground'}
                                    font-semibold
                                    flex
                                    items-center
                                    justify-center
                                    gap-2
                                    hover:opacity-90
                                    transition
                                "
                            >

                                <i data-lucide="shopping-cart"
                                   class="w-4 h-4"></i>

                                Add This Price to Cart

                            </button>

                        </form>

                    </div>

                </div>

            `;
        }


        // =====================================================
        // FORMAT PRICE
        // =====================================================

        function formatPrice(price) {

            return Number(price).toLocaleString(
                'en-PK',
                {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                }
            );

        }


        // =====================================================
        // ESCAPE HTML
        // =====================================================

        function escapeHtml(value) {

            if (value === null || value === undefined) {
                return '';
            }

            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }


        // =====================================================
        // MOBILE MENU
        // =====================================================

        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');


        menuBtn.addEventListener('click', () => {

            mobileMenu.classList.toggle('hidden');

            menuIcon.classList.toggle('hidden');

            closeIcon.classList.toggle('hidden');

        });


        // Lucide
        lucide.createIcons();

    </script>

</body>

</html>