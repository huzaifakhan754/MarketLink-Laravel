<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Basket — MarketLink</title>

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

        /* AJAX loading effect */
        .cart-loading {
            opacity: 0.55;
            pointer-events: none;
        }

        .cart-button-loading {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body class="min-h-screen bg-background text-foreground antialiased flex flex-col">

    <!-- ===================================================== -->
    <!-- TOP ANNOUNCEMENT -->
    <!-- ===================================================== -->

    <div class="bg-primary text-primary-foreground text-center py-2 text-xs font-semibold tracking-wide">
        Autumn harvest pre-orders are now open.
    </div>


    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

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
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                    Markets

                </a>

                <a
                    href="{{ url('/products') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">

                    Fresh Picks

                </a>
                <a
                    href="{{ route('customer.orders') }}"
                    class="text-primary font-semibold border-b-2 border-primary pb-1">

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


                    <span id="cartCountBadge"
                        class="absolute -top-1 -right-1 bg-[#1b4d3e] text-white text-[10px] font-bold w-5 h-5 items-center justify-center rounded-full shadow-xs {{ $cartCount > 0 ? 'flex' : 'hidden' }}">

                        {{ $cartCount }}

                    </span>

                </a>


                <!-- SIGN IN -->
                <a href="/login" class="hidden sm:block">

                    <button class="border border-border bg-background hover:bg-black/5 h-8 rounded-md px-3 text-xs font-medium transition-colors">

                        Sign in

                    </button>

                </a>


                <!-- MOBILE MENU -->
                <button id="menuBtn"
                    type="button"
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
                    class="text-base font-semibold text-foreground/80 hover:text-primary">
                    Markets
                </a>

                <a href="/products"
                    class="text-base font-semibold text-primary">
                    Fresh Picks
                </a>

                <a href="/dashboard"
                    class="text-base font-semibold text-foreground/80 hover:text-primary">
                    Farmer Studio
                </a>

                <a href="/admin"
                    class="text-base font-semibold text-foreground/80 hover:text-primary">
                    Admin
                </a>

                <div class="pt-2 border-t border-border">

                    <a href="/login" class="block w-full">

                        <button type="button"
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white">

                            Sign in

                        </button>

                    </a>

                </div>

            </nav>

        </div>

    </header>


    <!-- ===================================================== -->
    <!-- MAIN CART AREA -->
    <!-- ===================================================== -->

    <main class="bg-[#fcfbf7] min-h-screen py-10 px-4 sm:px-6 lg:px-8 flex-grow">

        <div class="max-w-6xl mx-auto space-y-8">

            <!-- PAGE HEADER -->

            <div>

                <span class="text-xs font-bold uppercase tracking-widest text-[#b85a3a]">
                    YOUR BASKET
                </span>

                <h1 class="text-4xl sm:text-5xl font-serif font-bold text-[#1b4d3e] mt-1">
                    Market pickup order
                </h1>

                <p class="text-xs text-gray-500 mt-2">
                    Items are reserved for pickup on market day.
                    Pay the farmer directly when you collect.
                </p>

            </div>


            <!-- AJAX MESSAGE -->

            <div id="ajaxMessage"
                class="hidden p-4 rounded-xl text-sm font-semibold">
            </div>


            <!-- CART CONTENT -->

            <div id="cartContainer">

                @if(!empty($cart))

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">


                    <!-- ================================================= -->
                    <!-- PRODUCTS -->
                    <!-- ================================================= -->

                    <div class="lg:col-span-2 space-y-4">

                        @php
                        $totalPrice = 0;
                        @endphp


                        @foreach($cart as $id => $details)

                        @php

                        $quantity = $details['quantity'] ?? 0;
                        $price = $details['price'] ?? 0;
                        $itemTotal = $price * $quantity;

                        $totalPrice += $itemTotal;

                        @endphp


                        <!-- PRODUCT CARD -->

                        <div class="cart-item bg-white rounded-2xl border border-gray-200/80 p-4 sm:p-5 shadow-2xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                            data-product-id="{{ $id }}"
                            data-price="{{ $price }}">


                            <!-- PRODUCT DETAILS -->

                            <div class="flex items-center gap-4">

                                <!-- IMAGE -->

                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-xl overflow-hidden shrink-0 border border-gray-100">

                                    @if(!empty($details['image']))

                                    <img src="{{ asset('storage/' . $details['image']) }}"
                                        alt="{{ $details['name'] }}"
                                        class="w-full h-full object-cover">

                                    @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-300">

                                        <i class="fa-solid fa-wheat-awn text-2xl"></i>

                                    </div>

                                    @endif

                                </div>


                                <!-- NAME / PRICE -->

                                <div class="space-y-1">

                                    <h3 class="font-serif text-base sm:text-lg font-bold text-gray-900 leading-snug">

                                        {{ $details['name'] }}

                                    </h3>

                                    <p class="text-xs text-[#b85a3a] font-bold">

                                        PKR {{ number_format($price, 2) }}

                                        /

                                        {{ $details['unit'] ?? 'unit' }}

                                    </p>

                                </div>

                            </div>


                            <!-- CONTROLS -->

                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4 sm:gap-6 border-t sm:border-0 pt-3 sm:pt-0 border-gray-100">


                                <!-- QUANTITY -->

                                <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50/80 p-1">

                                    <!-- DECREASE -->

                                    <button type="button"
                                        class="quantity-btn decrease-btn w-7 h-7 flex items-center justify-center text-gray-600 hover:text-black font-bold text-sm rounded-lg hover:bg-white transition"
                                        data-product-id="{{ $id }}"
                                        data-action="decrease">

                                        −

                                    </button>


                                    <!-- QUANTITY -->

                                    <span class="quantity-value w-8 text-center text-xs font-bold text-gray-900">

                                        {{ $quantity }}

                                    </span>


                                    <!-- INCREASE -->

                                    <button type="button"
                                        class="quantity-btn increase-btn w-7 h-7 flex items-center justify-center text-gray-600 hover:text-black font-bold text-sm rounded-lg hover:bg-white transition"
                                        data-product-id="{{ $id }}"
                                        data-action="increase">

                                        +

                                    </button>

                                </div>


                                <!-- ITEM TOTAL -->

                                <div class="text-right min-w-[80px]">

                                    <span class="item-total font-serif text-base font-bold text-[#1b4d3e]">

                                        PKR {{ number_format($itemTotal, 2) }}

                                    </span>

                                </div>


                                <!-- REMOVE -->

                                <button type="button"
                                    class="remove-btn text-gray-400 hover:text-red-500 transition p-1"
                                    data-product-id="{{ $id }}"
                                    title="Remove item">

                                    <i class="fa-regular fa-trash-can text-sm"></i>

                                </button>

                            </div>

                        </div>

                        @endforeach


                        <!-- CONTINUE SHOPPING -->

                        <div class="pt-2">

                            <a href="{{ route('products') }}"
                                class="inline-flex items-center gap-2 text-xs font-bold text-[#1b4d3e] hover:underline">

                                ← Continue browsing products

                            </a>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- SUMMARY -->
                    <!-- ================================================= -->

                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-2xs space-y-5 lg:sticky lg:top-24">

                        <h2 class="font-serif text-xl font-bold text-gray-900 border-b border-gray-100 pb-3">
                            Reservation Summary
                        </h2>


                        <div class="space-y-3 text-xs font-medium text-gray-600">

                            <!-- ITEMS -->

                            <div class="flex justify-between">

                                <span>
                                    Reserved Items
                                </span>

                                <span id="reservedItems"
                                    class="font-bold text-gray-900">

                                    {{ array_sum(array_column($cart, 'quantity')) }}

                                </span>

                            </div>


                            <!-- SUBTOTAL -->

                            <div class="flex justify-between">

                                <span>
                                    Subtotal
                                </span>

                                <span id="subtotal"
                                    class="font-bold text-gray-900">

                                    PKR {{ number_format($totalPrice, 2) }}

                                </span>

                            </div>


                            <!-- PICKUP -->

                            <div class="flex justify-between text-emerald-700 font-semibold">

                                <span>
                                    Pickup Fee
                                </span>

                                <span>
                                    FREE
                                </span>

                            </div>

                        </div>


                        <!-- TOTAL -->

                        <div class="border-t border-gray-100 pt-4 flex items-baseline justify-between">

                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">
                                Estimated Total
                            </span>

                            <span id="estimatedTotal"
                                class="font-serif text-2xl font-bold text-[#1b4d3e]">

                                PKR {{ number_format($totalPrice, 2) }}

                            </span>

                        </div>


                        <!-- INFO -->

                        <p class="text-[11px] text-gray-400 leading-relaxed bg-amber-50/50 p-3 rounded-xl border border-amber-100/60">

                            📌 No online payment required now.
                            Reservation confirms your stock with the local farmer.

                        </p>


                        <!-- CHECKOUT -->

                        <a href="{{ route('cart.checkout') }}"
                            class="w-full inline-flex items-center justify-center bg-[#005327] hover:bg-[#003d1c] text-white font-semibold rounded-full py-3 px-6 transition-all duration-200 shadow-sm hover:shadow-md">
                            Confirm Reservation
                        </a>

                    </div>

                </div>

                @else

                <!-- EMPTY CART -->

                <div class="bg-white rounded-2xl border border-gray-200/80 p-16 text-center max-w-lg mx-auto space-y-4">

                    <div class="w-16 h-16 bg-emerald-50 text-[#1b4d3e] rounded-full flex items-center justify-center mx-auto text-2xl">

                        <i class="fa-solid fa-basket-shopping"></i>

                    </div>

                    <div>

                        <h3 class="font-serif text-xl font-bold text-gray-900">
                            Your basket is empty
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            You haven't reserved any market items yet.
                        </p>

                    </div>

                    <a href="{{ route('products') }}"
                        class="inline-block bg-[#1b4d3e] hover:bg-[#143b2f] text-white text-xs font-bold px-6 py-3 rounded-xl transition">

                        Explore Fresh Picks

                    </a>

                </div>

                @endif

            </div>

        </div>

    </main>


    <!-- ===================================================== -->
    <!-- FOOTER -->
    <!-- ===================================================== -->

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


    <!-- ===================================================== -->
    <!-- JAVASCRIPT -->
    <!-- ===================================================== -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            lucide.createIcons();


            /* =====================================================
               MOBILE MENU
            ===================================================== */

            const menuBtn = document.getElementById('menuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');


            if (menuBtn) {

                menuBtn.addEventListener('click', function() {

                    mobileMenu.classList.toggle('hidden');

                    menuIcon.classList.toggle('hidden');

                    closeIcon.classList.toggle('hidden');

                });

            }


            /* =====================================================
               CSRF TOKEN
            ===================================================== */

            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                '{{ csrf_token() }}';


            /* =====================================================
               ELEMENTS
            ===================================================== */

            const cartContainer =
                document.getElementById('cartContainer');

            const ajaxMessage =
                document.getElementById('ajaxMessage');


            /* =====================================================
               SHOW MESSAGE
            ===================================================== */

            function showMessage(message, type = 'success') {

                ajaxMessage.textContent = message;

                ajaxMessage.className =
                    'p-4 rounded-xl text-sm font-semibold mb-4';


                if (type === 'error') {

                    ajaxMessage.classList.add(
                        'bg-red-100',
                        'border',
                        'border-red-200',
                        'text-red-800'
                    );

                } else {

                    ajaxMessage.classList.add(
                        'bg-green-100',
                        'border',
                        'border-green-200',
                        'text-green-800'
                    );

                }


                ajaxMessage.classList.remove('hidden');


                setTimeout(function() {

                    ajaxMessage.classList.add('hidden');

                }, 3000);

            }


            /* =====================================================
               FORMAT PRICE
            ===================================================== */

            function formatPrice(value) {

                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);

            }


            /* =====================================================
               UPDATE CART SUMMARY
            ===================================================== */

            function updateSummary(data) {

                const reservedItems =
                    document.getElementById('reservedItems');

                const subtotal =
                    document.getElementById('subtotal');

                const estimatedTotal =
                    document.getElementById('estimatedTotal');

                const cartCountBadge =
                    document.getElementById('cartCountBadge');


                if (reservedItems) {

                    reservedItems.textContent =
                        data.cartCount;

                }


                if (subtotal) {

                    subtotal.textContent =
                        'PKR ' + formatPrice(data.total);

                }


                if (estimatedTotal) {

                    estimatedTotal.textContent =
                        'PKR ' + formatPrice(data.total);

                }


                /* HEADER CART COUNT */

                if (cartCountBadge) {

                    cartCountBadge.textContent =
                        data.cartCount;


                    if (data.cartCount > 0) {

                        cartCountBadge.classList.remove('hidden');

                        cartCountBadge.classList.add('flex');

                    } else {

                        cartCountBadge.classList.remove('flex');

                        cartCountBadge.classList.add('hidden');

                    }

                }

            }


            /* =====================================================
               EMPTY CART HTML
            ===================================================== */

            function showEmptyCart() {

                cartContainer.innerHTML = `

            <div class="bg-white rounded-2xl border border-gray-200/80 p-16 text-center max-w-lg mx-auto space-y-4">

                <div class="w-16 h-16 bg-emerald-50 text-[#1b4d3e] rounded-full flex items-center justify-center mx-auto text-2xl">

                    <i class="fa-solid fa-basket-shopping"></i>

                </div>

                <div>

                    <h3 class="font-serif text-xl font-bold text-gray-900">

                        Your basket is empty

                    </h3>

                    <p class="text-xs text-gray-500 mt-1">

                        You haven't reserved any market items yet.

                    </p>

                </div>

                <a href="{{ route('products') }}"
                   class="inline-block bg-[#1b4d3e] hover:bg-[#143b2f] text-white text-xs font-bold px-6 py-3 rounded-xl transition">

                    Explore Fresh Picks

                </a>

            </div>

        `;

                lucide.createIcons();

            }


            /* =====================================================
               UPDATE QUANTITY
            ===================================================== */

            async function updateQuantity(productId, action, button) {

                const card =
                    document.querySelector(
                        `.cart-item[data-product-id="${productId}"]`
                    );


                if (!card) {
                    return;
                }


                /* Prevent double clicking */

                if (card.classList.contains('cart-loading')) {
                    return;
                }


                card.classList.add('cart-loading');


                if (button) {
                    button.classList.add('cart-button-loading');
                }


                try {

                    const response =
                        await fetch('{{ route('cart.update')}}',{

                                method: 'POST',

                                headers: {

                                    'Content-Type': 'application/json',

                                    'Accept': 'application/json',

                                    'X-CSRF-TOKEN': csrfToken,

                                    'X-Requested-With': 'XMLHttpRequest'

                                },

                                body: JSON.stringify({

                                    product_id: productId,

                                    action: action

                                })

                            });


                    const data =
                        await response.json();


                    if (!response.ok || !data.success) {

                        showMessage(
                            data.message || 'Something went wrong.',
                            'error'
                        );

                        return;
                    }


                    /* ==========================================
                       ITEM REMOVED WHEN QUANTITY BECOMES ZERO
                    ========================================== */

                    if (
                        data.removed === true ||
                        data.quantity <= 0
                    ) {

                        card.remove();

                    } else {

                        /* ======================================
                           UPDATE QUANTITY
                        ====================================== */

                        const quantityElement =
                            card.querySelector('.quantity-value');


                        if (quantityElement) {

                            quantityElement.textContent =
                                data.quantity;

                        }


                        /* ======================================
                           UPDATE ITEM TOTAL
                        ====================================== */

                        const itemTotal =
                            card.querySelector('.item-total');


                        if (itemTotal) {

                            itemTotal.textContent =
                                'PKR ' + formatPrice(data.item_total);

                        }

                    }


                    /* ==========================================
                       UPDATE SUMMARY
                    ========================================== */

                    updateSummary(data);


                    /* ==========================================
                       CART EMPTY
                    ========================================== */

                    if (data.cartCount <= 0) {

                        showEmptyCart();

                    }


                    showMessage(
                        data.message || 'Cart updated successfully.',
                        'success'
                    );

                } catch (error) {

                    console.error(error);

                    showMessage(
                        'Cart update nahi ho saka. Please try again.',
                        'error'
                    );

                } finally {

                    card.classList.remove('cart-loading');

                    if (button) {

                        button.classList.remove(
                            'cart-button-loading'
                        );

                    }

                }

            }


            /* =====================================================
               REMOVE PRODUCT
            ===================================================== */

            async function removeProduct(productId, button) {

                const card =
                    document.querySelector(
                        `.cart-item[data-product-id="${productId}"]`
                    );


                if (!card) {
                    return;
                }


                if (card.classList.contains('cart-loading')) {
                    return;
                }


                card.classList.add('cart-loading');


                if (button) {

                    button.classList.add(
                        'cart-button-loading'
                    );

                }


                try {

                    const response =
                        await fetch('{{ route('cart.remove') }}', {

                                method: 'POST',

                                headers: {

                                    'Content-Type': 'application/json',

                                    'Accept': 'application/json',

                                    'X-CSRF-TOKEN': csrfToken,

                                    'X-Requested-With': 'XMLHttpRequest'

                                },

                                body: JSON.stringify({

                                    product_id: productId

                                })

                            });


                    const data =
                        await response.json();


                    if (!response.ok || !data.success) {

                        showMessage(
                            data.message || 'Item remove nahi ho saka.',
                            'error'
                        );

                        return;
                    }


                    /* REMOVE CARD WITHOUT REFRESH */

                    card.remove();


                    /* UPDATE HEADER + SUMMARY */

                    updateSummary(data);


                    /* IF CART EMPTY */

                    if (data.cartCount <= 0) {

                        showEmptyCart();

                    }


                    showMessage(
                        data.message || 'Item removed successfully!',
                        'success'
                    );

                } catch (error) {

                    console.error(error);

                    showMessage(
                        'Item remove nahi ho saka. Please try again.',
                        'error'
                    );

                } finally {

                    card.classList.remove('cart-loading');

                    if (button) {

                        button.classList.remove(
                            'cart-button-loading'
                        );

                    }

                }

            }


            /* =====================================================
               QUANTITY BUTTON EVENTS
            ===================================================== */

            document.addEventListener('click', function(event) {

                const quantityButton =
                    event.target.closest('.quantity-btn');


                if (!quantityButton) {
                    return;
                }


                event.preventDefault();


                const productId =
                    quantityButton.dataset.productId;


                const action =
                    quantityButton.dataset.action;


                updateQuantity(
                    productId,
                    action,
                    quantityButton
                );

            });


            /* =====================================================
               DELETE BUTTON EVENTS
            ===================================================== */

            document.addEventListener('click', function(event) {

                const removeButton =
                    event.target.closest('.remove-btn');


                if (!removeButton) {
                    return;
                }


                event.preventDefault();


                const productId =
                    removeButton.dataset.productId;


                removeProduct(
                    productId,
                    removeButton
                );

            });

        });
    </script>
@include('components.ai-chatbot')
</body>

</html>