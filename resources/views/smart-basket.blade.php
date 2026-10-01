<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>Smart Basket · MarketLink</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Work Sans', sans-serif;
            background: #fdfbf7;
            color: #173b29;
        }

        .fraunces {
            font-family: 'Fraunces', serif;
        }

        .primary {
            background: #005327;
        }

        .primary:hover {
            background: #003f1d;
        }

        .orange {
            color: #ca6232;
        }

        .soft-card {
            background: white;
            border: 1px solid #eee8df;
            box-shadow: 0 12px 35px rgba(0, 83, 39, 0.07);
        }

        .input-box {
            width: 100%;
            border: 1px solid #ddd8cf;
            border-radius: 14px;
            padding: 13px 15px;
            outline: none;
            transition: .2s;
            background: #fff;
        }

        .input-box:focus {
            border-color: #005327;
            box-shadow: 0 0 0 3px rgba(0, 83, 39, .08);
        }

        .option-card {
            border: 1px solid #e4dfd7;
            border-radius: 14px;
            padding: 13px;
            cursor: pointer;
            transition: .2s;
            background: white;
        }

        .option-card:hover {
            border-color: #005327;
        }

        .option-card.selected {
            border-color: #005327;
            background: #f0f8f3;
        }

        .basket-item {
            border-bottom: 1px solid #eee9e1;
            padding: 17px 0;
        }

        .basket-item:last-child {
            border-bottom: none;
        }

        .product-img {
            width: 65px;
            height: 65px;
            border-radius: 13px;
            object-fit: cover;
            background: #f3f1ec;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ded9d0;
            border-radius: 10px;
            padding: 4px;
            width: fit-content;
        }

        .qty-btn {
            width: 29px;
            height: 29px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f2ed;
            cursor: pointer;
            border: none;
        }

        .qty-btn:hover {
            background: #e9e6df;
        }

        .loader {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .success-box {
            background: #effaf3;
            border: 1px solid #ccebd7;
            color: #176638;
        }

        .error-box {
            background: #fff3f1;
            border: 1px solid #f3c9c2;
            color: #a63b2b;
        }

        @media (max-width: 768px) {

            .basket-layout {
                grid-template-columns: 1fr !important;
            }

            .hero-title {
                font-size: 35px !important;
            }

        }
    </style>

</head>

<body>

    <!-- =========================================================
     HEADER / NAVBAR
========================================================== -->

    <header class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-20 items-center justify-between">

            <!-- Logo -->

            <a href="{{ route('homepage') }}" class="flex items-center gap-2.5">

                <span
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-primary text-primary-foreground">

                    <i data-lucide="leaf" class="size-5"></i>

                </span>

                <span class="font-display text-2xl font-bold text-primary">
                    MarketLink
                </span>

            </a>


            <!-- Desktop Navigation -->

            <nav class="hidden items-center gap-8 md:flex">

                <a href="{{ route('products') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">
                    Fresh Picks
                </a>

                <a href="{{ route('smart-basket.index') }}"
                    class="text-primary font-semibold border-b-2 border-primary pb-1">
                    Smart Basket
                </a>

                <a href="{{ route('price-compare.index') }}"
                    class="text-sm font-medium text-foreground/70 hover:text-primary transition">
                    Price Compare
                </a>

                <a href="{{ route('compare-shopping.index') }}"
                    class="hover:text-[#005327] transition">
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


            <!-- Right Side -->

            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Favorites -->

                <a
                    href="/favorites"
                    aria-label="Favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i data-lucide="heart" class="size-5"></i>

                </a>


                <!-- Cart -->

                <a
                    href="{{ route('cart.index') }}"
                    aria-label="Cart"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors relative">

                    <i data-lucide="shopping-basket" class="size-5"></i>

                    @php

                    $cartCount = collect(session('cart', []))
                    ->sum(fn($item) => (int)($item['quantity'] ?? 0));

                    @endphp


                    @if($cartCount > 0)

                    <span
                        class="absolute -top-1 -right-1 min-w-[17px] h-[17px] px-1 rounded-full bg-accent text-white text-[9px] font-bold flex items-center justify-center">

                        {{ $cartCount }}

                    </span>

                    @endif

                </a>


                <!-- Sign In / User -->

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


                <!-- Mobile Menu Button -->

                <button
                    id="menuBtn"
                    class="p-2 md:hidden text-foreground hover:text-primary transition focus:outline-none"
                    aria-label="Toggle Navigation">

                    <i
                        data-lucide="menu"
                        id="menuIcon"
                        class="size-6">
                    </i>

                    <i
                        data-lucide="x"
                        id="closeIcon"
                        class="size-6 hidden">
                    </i>

                </button>

            </div>

        </div>


        <!-- Mobile Drawer Menu -->

        <div
            id="mobileMenu"
            class="hidden md:hidden border-b border-border bg-background px-6 py-5 shadow-lg transition-all duration-300">

            <nav class="flex flex-col gap-4">


                <!-- Markets -->

                <a
                    href="{{ route('markets') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Markets

                </a>


                <!-- Fresh Picks -->

                <a
                    href="{{ route('products') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Fresh Picks

                </a>


                <!-- Smart Basket -->

                <a
                    href="{{ route('smart-basket.index') }}"
                    class="text-base font-semibold text-primary transition">

                    <i class="fa-solid fa-basket-shopping mr-1"></i>

                    Smart Basket

                </a>


                <!-- My Orders -->

                <a
                    href="{{ route('customer.orders') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    My Orders

                </a>


                <!-- Order History -->

                <a
                    href="{{ route('history') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Order History

                </a>


                <!-- Dashboard -->

                <a
                    href="{{ route('customer.dashboard') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    My Dashboard

                </a>


                <!-- Cart -->

                <a
                    href="{{ route('cart.index') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    <i class="fa-solid fa-cart-shopping mr-1"></i>

                    Cart

                </a>


                <!-- Login -->

                <div class="pt-2 border-t border-border">

                    @auth

                    <a
                        href="{{ route('customer.dashboard') }}"
                        class="block w-full">

                        <button
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white transition">

                            My Dashboard

                        </button>

                    </a>

                    @else

                    <a
                        href="{{ route('login') }}"
                        class="block w-full">

                        <button
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white transition">

                            Sign in

                        </button>

                    </a>

                    @endauth

                </div>

            </nav>

        </div>

    </header>

    <!-- HERO -->

    <section class="pt-14 pb-10 px-5">

        <div class="max-w-5xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#edf7f0] text-[#005327] text-sm font-semibold mb-5">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                AI Powered Shopping

            </div>

            <h1 class="fraunces hero-title text-5xl font-bold text-[#173b29]">

                Build Your
                <span class="text-[#ca6232]">
                    Smart Basket
                </span>

            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-gray-600 leading-7">

                Tell MarketLink your budget, family size and shopping needs.
                We'll create a personalized basket using available products
                from local farmers.

            </p>

        </div>

    </section>


    <!-- MAIN -->

    <main class="max-w-6xl mx-auto px-5 pb-20">

        <div class="grid grid-cols-1 lg:grid-cols-[390px_1fr] gap-7 basket-layout">

            <!-- FORM -->

            <div class="soft-card rounded-3xl p-6 h-fit">

                <div class="mb-6">

                    <h2 class="fraunces text-2xl font-bold">
                        Tell us what you need
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        We'll build your basket automatically.
                    </p>

                </div>


                <form id="basketForm">

                    <!-- PEOPLE -->

                    <div class="mb-5">

                        <label class="block font-semibold text-sm mb-2">
                            <i class="fa-solid fa-users text-[#005327] mr-1"></i>
                            How many people?
                        </label>

                        <div class="flex items-center gap-3">

                            <button type="button"
                                id="peopleMinus"
                                class="qty-btn">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>

                            <input type="number"
                                id="people"
                                name="people"
                                value="4"
                                min="1"
                                max="20"
                                class="input-box text-center font-semibold">

                            <button type="button"
                                id="peoplePlus"
                                class="qty-btn">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>

                        </div>

                    </div>


                    <!-- DAYS -->

                    <div class="mb-5">

                        <label class="block font-semibold text-sm mb-2">
                            <i class="fa-regular fa-calendar text-[#005327] mr-1"></i>
                            Shopping duration
                        </label>

                        <div class="grid grid-cols-3 gap-2">

                            <label class="option-card text-center">

                                <input type="radio"
                                    name="days"
                                    value="1"
                                    class="hidden">

                                <div class="font-semibold text-sm">
                                    1 Day
                                </div>

                            </label>

                            <label class="option-card selected text-center">

                                <input type="radio"
                                    name="days"
                                    value="3"
                                    checked
                                    class="hidden">

                                <div class="font-semibold text-sm">
                                    3 Days
                                </div>

                            </label>

                            <label class="option-card text-center">

                                <input type="radio"
                                    name="days"
                                    value="7"
                                    class="hidden">

                                <div class="font-semibold text-sm">
                                    7 Days
                                </div>

                            </label>

                        </div>

                    </div>


                    <!-- BUDGET -->

                    <div class="mb-5">

                        <label class="block font-semibold text-sm mb-2">

                            <i class="fa-solid fa-wallet text-[#005327] mr-1"></i>

                            What's your budget?

                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-gray-500">
                                Rs.
                            </span>

                            <input type="number"
                                id="budget"
                                name="budget"
                                value="2000"
                                min="100"
                                step="50"
                                class="input-box pl-12 text-lg font-semibold">

                        </div>

                    </div>


                    <!-- TYPES -->

                    <div class="mb-5">

                        <label class="block font-semibold text-sm mb-2">

                            <i class="fa-solid fa-basket-shopping text-[#005327] mr-1"></i>

                            What do you need?

                        </label>

                        <div class="grid grid-cols-2 gap-2">

                            <label class="option-card">

                                <input type="checkbox"
                                    name="types[]"
                                    value="Vegetables"
                                    class="type-check hidden">

                                <div class="flex items-center gap-2">

                                    <span class="type-icon">
                                        🥬
                                    </span>

                                    <span class="text-sm font-medium">
                                        Vegetables
                                    </span>

                                </div>

                            </label>


                            <label class="option-card">

                                <input type="checkbox"
                                    name="types[]"
                                    value="Fruits"
                                    class="type-check hidden">

                                <div class="flex items-center gap-2">

                                    <span>
                                        🍎
                                    </span>

                                    <span class="text-sm font-medium">
                                        Fruits
                                    </span>

                                </div>

                            </label>


                            <label class="option-card">

                                <input type="checkbox"
                                    name="types[]"
                                    value="Grocery"
                                    class="type-check hidden">

                                <div class="flex items-center gap-2">

                                    <span>
                                        🛒
                                    </span>

                                    <span class="text-sm font-medium">
                                        Grocery
                                    </span>

                                </div>

                            </label>


                            <label class="option-card">

                                <input type="checkbox"
                                    name="types[]"
                                    value="Herbs"
                                    class="type-check hidden">

                                <div class="flex items-center gap-2">

                                    <span>
                                        🌿
                                    </span>

                                    <span class="text-sm font-medium">
                                        Herbs
                                    </span>

                                </div>

                            </label>

                        </div>

                        <p class="text-xs text-gray-400 mt-2">
                            Leave all unchecked to use all available categories.
                        </p>

                    </div>


                    <!-- PREFERENCE -->

                    <div class="mb-6">

                        <label class="block font-semibold text-sm mb-2">

                            <i class="fa-solid fa-sliders text-[#005327] mr-1"></i>

                            Preference

                        </label>

                        <select
                            id="preference"
                            name="preference"
                            class="input-box">

                            <option value="normal">
                                Normal balanced basket
                            </option>

                            <option value="cheapest">
                                Cheapest possible
                            </option>

                            <option value="premium">
                                Premium products
                            </option>

                        </select>

                    </div>


                    <!-- ERROR -->

                    <div id="errorBox"
                        class="error-box rounded-xl p-3 text-sm hidden mb-4">
                    </div>


                    <!-- BUTTON -->

                    <button type="submit"
                        id="generateBtn"
                        class="primary w-full text-white rounded-xl py-3.5 font-semibold flex items-center justify-center gap-2">

                        <span id="generateText">
                            <i class="fa-solid fa-wand-magic-sparkles mr-1"></i>
                            Generate My Basket
                        </span>

                        <span id="generateLoader"
                            class="loader hidden"></span>

                    </button>

                </form>

            </div>


            <!-- RESULT -->

            <div>

                <div id="emptyState"
                    class="soft-card rounded-3xl min-h-[500px] flex items-center justify-center text-center p-10">

                    <div>

                        <div class="w-20 h-20 rounded-3xl bg-[#edf7f0] text-[#005327] flex items-center justify-center mx-auto mb-5">

                            <i class="fa-solid fa-basket-shopping text-3xl"></i>

                        </div>

                        <h2 class="fraunces text-3xl font-bold">
                            Your basket is waiting
                        </h2>

                        <p class="text-gray-500 max-w-md mx-auto mt-3 leading-6">

                            Enter your budget and requirements on the left.
                            MarketLink will create a personalized basket
                            from currently available products.

                        </p>

                    </div>

                </div>


                <!-- BASKET RESULT -->

                <div id="basketResult"
                    class="hidden">

                    <div class="soft-card rounded-3xl p-6">

                        <!-- RESULT HEADER -->

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                            <div>

                                <div class="flex items-center gap-2">

                                    <span class="w-10 h-10 rounded-xl bg-[#edf7f0] text-[#005327] flex items-center justify-center">

                                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                                    </span>

                                    <div>

                                        <h2 class="fraunces text-2xl font-bold">
                                            Your Smart Basket
                                        </h2>

                                        <p id="basketMeta"
                                            class="text-xs text-gray-500">
                                        </p>

                                    </div>

                                </div>

                            </div>

                            <span class="px-3 py-1.5 rounded-full bg-[#fff4ed] text-[#ca6232] text-xs font-semibold">

                                AI Recommended

                            </span>

                        </div>


                        <!-- SUCCESS -->

                        <div id="successBox"
                            class="success-box rounded-xl p-3 text-sm hidden mb-4">
                        </div>


                        <!-- ITEMS -->

                        <div id="basketItems">
                        </div>


                        <!-- TOTAL -->

                        <div class="border-t border-[#eee8df] mt-4 pt-5">

                            <div class="grid grid-cols-3 gap-3">

                                <div class="bg-[#f8f6f1] rounded-2xl p-4">

                                    <p class="text-xs text-gray-500">
                                        Your Budget
                                    </p>

                                    <p id="budgetValue"
                                        class="font-bold text-lg mt-1">
                                        Rs. 0
                                    </p>

                                </div>


                                <div class="bg-[#f8f6f1] rounded-2xl p-4">

                                    <p class="text-xs text-gray-500">
                                        Basket Total
                                    </p>

                                    <p id="totalValue"
                                        class="font-bold text-lg mt-1 text-[#005327]">
                                        Rs. 0
                                    </p>

                                </div>


                                <div class="bg-[#f8f6f1] rounded-2xl p-4">

                                    <p class="text-xs text-gray-500">
                                        Remaining
                                    </p>

                                    <p id="remainingValue"
                                        class="font-bold text-lg mt-1 text-[#ca6232]">
                                        Rs. 0
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- ACTIONS -->

                        <div class="flex flex-col sm:flex-row gap-3 mt-6">

                            <button type="button"
                                id="updateBasketBtn"
                                class="flex-1 border border-[#005327] text-[#005327] rounded-xl py-3 font-semibold hover:bg-[#edf7f0]">

                                <i class="fa-solid fa-rotate mr-1"></i>

                                Update Basket

                            </button>


                            <button type="button"
                                id="addBasketBtn"
                                class="flex-1 primary text-white rounded-xl py-3 font-semibold">

                                <i class="fa-solid fa-cart-plus mr-1"></i>

                                Add Entire Basket

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


    <script>
        const csrfToken =
            document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        let currentBasket = null;


        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function money(value) {

            return 'Rs. ' + Number(value).toLocaleString('en-PK', {
                maximumFractionDigits: 2
            });

        }


        function escapeHtml(text) {

            const div = document.createElement('div');

            div.textContent = text ?? '';

            return div.innerHTML;

        }


        function showError(message) {

            const box = document.getElementById('errorBox');

            box.textContent = message;

            box.classList.remove('hidden');

        }


        function hideError() {

            document.getElementById('errorBox')
                .classList.add('hidden');

        }


        function showSuccess(message) {

            const box = document.getElementById('successBox');

            box.textContent = message;

            box.classList.remove('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | People +/-
        |--------------------------------------------------------------------------
        */

        document.getElementById('peopleMinus')
            .addEventListener('click', function() {

                const input = document.getElementById('people');

                let value = parseInt(input.value) || 1;

                if (value > 1) {
                    value--;
                }

                input.value = value;

            });


        document.getElementById('peoplePlus')
            .addEventListener('click', function() {

                const input = document.getElementById('people');

                let value = parseInt(input.value) || 1;

                if (value < 20) {
                    value++;
                }

                input.value = value;

            });


        /*
        |--------------------------------------------------------------------------
        | Option card selection
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('input[name="days"]')
            .forEach(function(input) {

                input.addEventListener('change', function() {

                    document.querySelectorAll('input[name="days"]')
                        .forEach(function(radio) {

                            radio.closest('.option-card')
                                .classList.remove('selected');

                        });

                    this.closest('.option-card')
                        .classList.add('selected');

                });

            });


        document.querySelectorAll('.type-check')
            .forEach(function(input) {

                input.addEventListener('change', function() {

                    if (this.checked) {

                        this.closest('.option-card')
                            .classList.add('selected');

                    } else {

                        this.closest('.option-card')
                            .classList.remove('selected');

                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | Generate Basket
        |--------------------------------------------------------------------------
        */

        document.getElementById('basketForm')
            .addEventListener('submit', async function(e) {

                e.preventDefault();

                hideError();

                const button =
                    document.getElementById('generateBtn');

                const text =
                    document.getElementById('generateText');

                const loader =
                    document.getElementById('generateLoader');

                button.disabled = true;

                text.classList.add('hidden');

                loader.classList.remove('hidden');

                const formData =
                    new FormData(this);

                try {

                    const response = await fetch('{{ route('smart-basket.generate')}}', {
                         method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },

                            body: formData

                        });


                    const data =
                        await response.json();


                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to generate basket.'
                        );

                    }


                    currentBasket =
                        data.basket;

                    renderBasket(currentBasket);

                } catch (error) {

                    showError(error.message);

                } finally {

                    button.disabled = false;

                    text.classList.remove('hidden');

                    loader.classList.add('hidden');

                }

            });


        /*
        |--------------------------------------------------------------------------
        | Render Basket
        |--------------------------------------------------------------------------
        */

        function renderBasket(basket) {

            document.getElementById('emptyState')
                .classList.add('hidden');

            document.getElementById('basketResult')
                .classList.remove('hidden');

            document.getElementById('basketMeta').textContent =
                `${basket.people} people · ${basket.days} days · ${basket.preference}`;


            document.getElementById('budgetValue').textContent =
                money(basket.budget);

            document.getElementById('totalValue').textContent =
                money(basket.total);

            document.getElementById('remainingValue').textContent =
                money(basket.remaining);


            const container =
                document.getElementById('basketItems');

            container.innerHTML = '';


            basket.items.forEach(function(item, index) {

                const image =
                    item.image ?
                    `/storage/${item.image}` :
                    'https://via.placeholder.com/100?text=Product';


                const row =
                    document.createElement('div');

                row.className =
                    'basket-item flex flex-col sm:flex-row sm:items-center gap-4';


                row.innerHTML = `

                <img
                    src="${escapeHtml(image)}"
                    class="product-img"
                    alt="${escapeHtml(item.name)}"
                    onerror="this.src='https://via.placeholder.com/100?text=Product'"
                >

                <div class="flex-1">

                    <h3 class="font-semibold text-[#173b29]">
                        ${escapeHtml(item.name)}
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        ${money(item.price)} / ${escapeHtml(item.unit || 'unit')}
                    </p>

                </div>


                <div class="qty-box">

                    <button
                        type="button"
                        class="qty-btn"
                        onclick="changeBasketQuantity(${index}, -1)"
                    >
                        <i class="fa-solid fa-minus text-xs"></i>
                    </button>


                    <span
                        id="qty-${index}"
                        class="w-7 text-center text-sm font-semibold"
                    >
                        ${item.quantity}
                    </span>


                    <button
                        type="button"
                        class="qty-btn"
                        onclick="changeBasketQuantity(${index}, 1)"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>

                </div>


                <div class="sm:w-24 text-left sm:text-right">

                    <p
                        id="subtotal-${index}"
                        class="font-bold text-[#005327]"
                    >
                        ${money(item.subtotal)}
                    </p>

                </div>


                <button
                    type="button"
                    onclick="removeBasketItem(${index})"
                    class="w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-100"
                    title="Remove"
                >

                    <i class="fa-solid fa-trash text-xs"></i>

                </button>

            `;


                container.appendChild(row);

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Change Quantity
        |--------------------------------------------------------------------------
        */

        function changeBasketQuantity(index, change) {

            if (!currentBasket) {
                return;
            }

            const item =
                currentBasket.items[index];

            let quantity =
                parseInt(item.quantity) + change;


            if (quantity < 0) {
                quantity = 0;
            }


            if (quantity > parseInt(item.stock)) {
                quantity = parseInt(item.stock);
            }


            item.quantity = quantity;


            recalculateLocalBasket();

        }


        /*
        |--------------------------------------------------------------------------
        | Remove item
        |--------------------------------------------------------------------------
        */

        function removeBasketItem(index) {

            if (!currentBasket) {
                return;
            }

            currentBasket.items.splice(index, 1);

            recalculateLocalBasket();

        }


        /*
        |--------------------------------------------------------------------------
        | Local calculation
        |--------------------------------------------------------------------------
        */

        function recalculateLocalBasket() {

            const budget =
                Number(currentBasket.budget);


            currentBasket.items =
                currentBasket.items.filter(function(item) {

                    return Number(item.quantity) > 0;

                });


            let total = 0;


            currentBasket.items.forEach(function(item) {

                item.subtotal =
                    Number(item.price) *
                    Number(item.quantity);

                total += item.subtotal;

            });


            currentBasket.total =
                Number(total.toFixed(2));


            currentBasket.remaining =
                Number(
                    Math.max(0, budget - total)
                    .toFixed(2)
                );


            renderBasket(currentBasket);

        }


        /*
        |--------------------------------------------------------------------------
        | Update Basket in Session
        |--------------------------------------------------------------------------
        */

        document.getElementById('updateBasketBtn')
            .addEventListener('click', async function() {

                if (!currentBasket) {
                    return;
                }


                if (!currentBasket.items.length) {

                    showError(
                        'Your basket cannot be empty.'
                    );

                    return;

                }


                hideError();


                const button = this;

                button.disabled = true;

                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Updating...';


                try {

                    const updateResponse = await fetch('{{ route('smart-basket.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                items: basketItems
                            })
                        }
                    );


                    const data =
                        await response.json();


                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to update basket.'
                        );

                    }


                    currentBasket =
                        data.basket;

                    renderBasket(currentBasket);

                    showSuccess(
                        'Basket updated successfully.'
                    );


                } catch (error) {

                    showError(error.message);

                } finally {

                    button.disabled = false;

                    button.innerHTML =
                        '<i class="fa-solid fa-rotate mr-1"></i> Update Basket';

                }

            });


        /*
        |--------------------------------------------------------------------------
        | Add Entire Basket
        |--------------------------------------------------------------------------
        */

        document.getElementById('addBasketBtn')
            .addEventListener('click', async function() {

                if (!currentBasket ||
                    !currentBasket.items.length) {

                    showError(
                        'Your basket is empty.'
                    );

                    return;

                }


                hideError();


                const button = this;

                button.disabled = true;

                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Adding...';


                try {

                    /*
                     * First save the latest quantities
                     */
                    const updateResponse = await fetch('{{ route('smart-basket.update') }}', {

                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },

                                body: JSON.stringify({
                                    items: currentBasket.items.map(item => ({
                                        id: item.id,
                                        quantity: item.quantity
                                    }))
                                })

                            }
                        );


                    const updateData =
                        await updateResponse.json();


                    if (!updateResponse.ok ||
                        !updateData.success) {

                        throw new Error(
                            updateData.message ||
                            'Unable to update basket.'
                        );

                    }


                    currentBasket =
                        updateData.basket;


                    /*
                     * Now add complete basket to cart
                     */

                    const response = await fetch('{{ route('smart-basket.add-to-cart') }}', {

                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }

                            }
                        );


                    const data =
                        await response.json();


                    if (!response.ok || !data.success) {

                        throw new Error(
                            data.message ||
                            'Unable to add basket to cart.'
                        );

                    }


                    button.innerHTML =
                        '<i class="fa-solid fa-check mr-1"></i> Added to Cart';


                    showSuccess(
                        'Your complete Smart Basket has been added to the cart!'
                    );


                    /*
                     * Go to cart after short delay
                     */

                    setTimeout(function() {

                        window.location.href =
                            data.redirect;

                    }, 800);


                } catch (error) {

                    showError(error.message);

                    button.disabled = false;

                    button.innerHTML =
                        '<i class="fa-solid fa-cart-plus mr-1"></i> Add Entire Basket';

                }

            });
    </script>

</body>

</html>