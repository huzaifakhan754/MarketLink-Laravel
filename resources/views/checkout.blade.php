<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Checkout — MarketLink</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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

</head>


<body class="min-h-screen bg-background text-foreground antialiased flex flex-col">


    <!-- =========================================================
         TOP ANNOUNCEMENT
    ========================================================== -->

    <div class="bg-primary text-white text-center text-xs font-semibold py-2">

        Autumn harvest pre-orders are now open.

    </div>


    <!-- =========================================================
         HEADER / NAVBAR
    ========================================================== -->

    <header class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-20 items-center justify-between">

            <!-- Logo -->

            <a
                href="/"
                class="flex items-center gap-2.5">

                <span
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-primary text-primary-foreground">

                    <i
                        data-lucide="leaf"
                        class="size-5">
                    </i>

                </span>

                <span
                    class="font-display text-2xl font-bold text-primary">

                    MarketLink

                </span>

            </a>


            <!-- Desktop Navigation -->

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


            <!-- Right Side -->

            <div class="flex items-center gap-2 sm:gap-3">

                <a
                    href="/favorites"
                    aria-label="Favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i
                        data-lucide="heart"
                        class="size-5">
                    </i>

                </a>


                <a
                    href="{{ route('cart.index') }}"
                    aria-label="Cart"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i
                        data-lucide="shopping-basket"
                        class="size-5">
                    </i>

                </a>


                @auth

                <span
                    class="hidden sm:inline-flex border border-border bg-background rounded-md px-3 py-2 text-xs font-medium capitalize">

                    {{ auth()->user()->role ?? 'customer' }}

                </span>

                @else

                <a
                    href="{{ route('login') }}"
                    class="hidden sm:block">

                    <button
                        class="border border-border bg-background hover:bg-black/5 h-8 rounded-md px-3 text-xs font-medium transition-colors">

                        Sign in

                    </button>

                </a>

                @endauth


                <!-- Mobile Button -->

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


        <!-- Mobile Menu -->

        <div
            id="mobileMenu"
            class="hidden md:hidden border-b border-border bg-background px-6 py-5 shadow-lg">

            <nav class="flex flex-col gap-4">

                <a
                    href="{{ route('markets') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Markets

                </a>

                <a
                    href="{{ route('products') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Fresh Picks

                </a>

                <a
                    href="#"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Farmer Studio

                </a>

                @auth

                <div class="pt-2 border-t border-border">

                    <span
                        class="block text-sm font-semibold text-primary capitalize">

                        {{ auth()->user()->role ?? 'customer' }}

                    </span>

                </div>

                @else

                <div class="pt-2 border-t border-border">

                    <a
                        href="{{ route('login') }}"
                        class="block w-full">

                        <button
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white">

                            Sign in

                        </button>

                    </a>

                </div>

                @endauth

            </nav>

        </div>

    </header>


    <!-- =========================================================
         MAIN
    ========================================================== -->

    <main
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20 w-full flex-grow">


        <!-- PAGE HEADER -->

        <section class="mb-8">

            <span
                class="text-xs font-bold tracking-widest uppercase text-accent">

                Checkout · MarketLink

            </span>

            <h1
                class="font-display text-4xl sm:text-5xl font-bold mt-2 text-primary">

                Pickup details.

            </h1>

            <p
                class="mt-3 max-w-2xl text-muted-foreground">

                Enter your pickup information and review your reservation before placing the order.

            </p>

        </section>


        <!-- ERRORS -->

        @if ($errors->any())

        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <div class="flex items-start gap-3">

                <i
                    data-lucide="circle-alert"
                    class="w-5 h-5 shrink-0">
                </i>

                <div>

                    @foreach ($errors->all() as $error)

                    <div class="mb-1 last:mb-0">
                        {{ $error }}
                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        @endif


        <!-- =====================================================
             CHECKOUT GRID
        ====================================================== -->

        <div class="grid gap-8 lg:grid-cols-[1fr_380px]">


            <!-- =================================================
                 PICKUP DETAILS
            ================================================== -->

            <div
                class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">

                <div
                    class="border-b border-border px-6 py-5">

                    <div class="flex items-center gap-3">

                        <span
                            class="grid h-10 w-10 place-items-center rounded-full bg-primary/10 text-primary">

                            <i
                                data-lucide="clipboard-list"
                                class="w-5 h-5">
                            </i>

                        </span>

                        <div>

                            <h2
                                class="font-display text-2xl font-bold text-primary">

                                Pickup details

                            </h2>

                            <p
                                class="text-sm text-muted-foreground mt-1">

                                Tell us how you will collect your order.

                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route('cart.placeOrder') }}"
                    method="POST"
                    class="p-6">

                    @csrf


                    <div class="grid gap-5 sm:grid-cols-2">


                        <!-- NAME -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Your Name

                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                placeholder="Enter your name"
                                required
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                        </div>


                        <!-- PHONE -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Phone Number

                            </label>

                            <input
                                type="text"
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                placeholder="03XXXXXXXXX"
                                required
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                        </div>


                        <!-- EMAIL -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Email

                            </label>

                            <input
                                type="email"
                                name="customer_email"
                                value="{{ old('customer_email') }}"
                                placeholder="you@example.com"
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                        </div>


                        <!-- PICKUP NAME -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Pickup Name

                            </label>

                            <input
                                type="text"
                                name="pickup_name"
                                value="{{ old('pickup_name') }}"
                                placeholder="Name for pickup"
                                required
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                        </div>


                        <!-- DATE -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Pickup Date

                            </label>

                            <input
                                type="date"
                                name="pickup_date"
                                value="{{ old('pickup_date') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                        </div>


                        <!-- TIME -->

                        <div>

                            <label
                                class="block text-xs font-bold uppercase tracking-wide text-muted-foreground mb-2">

                                Time Slot

                            </label>

                            <select
                                name="time_slot"
                                required
                                class="w-full h-11 rounded-lg border border-border bg-background px-4 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition">

                                <option value="">
                                    Select Time
                                </option>

                                <option value="10:30am">10:30am</option>
                                <option value="11:00am">11:00am</option>
                                <option value="11:30am">11:30am</option>
                                <option value="12:00pm">12:00pm</option>
                                <option value="12:30pm">12:30pm</option>
                                <option value="1:00pm">1:00pm</option>
                                <option value="1:30pm">1:30pm</option>
                                <option value="2:00pm">2:00pm</option>
                                <option value="2:30pm">2:30pm</option>
                                <option value="3:00pm">3:00pm</option>

                            </select>

                        </div>

                    </div>


                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="mt-7 w-full inline-flex items-center justify-center gap-2 rounded-lg bg-primary py-3.5 px-6 text-sm font-semibold text-white hover:bg-[#003d1c] transition-all duration-200 shadow-sm hover:shadow-md">

                        <i
                            data-lucide="check"
                            class="w-5 h-5">
                        </i>

                        Place pre-order

                    </button>

                </form>

            </div>


            <!-- =================================================
                 ORDER SUMMARY
            ================================================== -->

            <div
                class="bg-card rounded-xl border border-border shadow-sm h-fit overflow-hidden lg:sticky lg:top-28">

                <div
                    class="border-b border-border px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <span
                                class="text-xs font-bold tracking-widest uppercase text-accent">

                                Summary

                            </span>

                            <h2
                                class="font-display text-2xl font-bold text-primary mt-1">

                                Your order

                            </h2>

                        </div>

                        <span
                            class="grid h-10 w-10 place-items-center rounded-full bg-primary/10 text-primary">

                            <i
                                data-lucide="shopping-basket"
                                class="w-5 h-5">
                            </i>

                        </span>

                    </div>

                </div>


                <div class="p-6">

                    @php
                    $grandTotal = 0;
                    @endphp


                    @foreach ($products as $product)

                    @php

                    $itemTotal =
                    $product['price'] *
                    $product['quantity'];

                    $grandTotal += $itemTotal;

                    @endphp


                    <div
                        class="flex gap-3 py-4 border-b border-border last:border-0">

                        @if (!empty($product['image']))

                        <img
                            src="{{ asset('storage/' . $product['image']) }}"
                            alt="{{ $product['name'] }}"
                            class="w-16 h-16 rounded-lg object-cover border border-border">

                        @else

                        <div
                            class="w-16 h-16 rounded-lg bg-muted/50 border border-border flex items-center justify-center">

                            <i
                                data-lucide="image"
                                class="w-5 h-5 text-muted-foreground">
                            </i>

                        </div>

                        @endif


                        <div class="flex-1 min-w-0">

                            <h3
                                class="font-semibold text-primary text-sm truncate">

                                {{ $product['name'] }}

                            </h3>

                            <p
                                class="text-xs text-muted-foreground mt-1">

                                Qty:
                                {{ $product['quantity'] }}

                                @if (!empty($product['unit']))

                                {{ $product['unit'] }}

                                @endif

                            </p>

                            <p
                                class="text-sm font-bold text-primary mt-1">

                                Rs {{ number_format($itemTotal, 2) }}

                            </p>

                        </div>

                    </div>

                    @endforeach


                    <!-- TOTAL -->

                    <div
                        class="mt-5 pt-5 border-t border-border flex items-center justify-between">

                        <span
                            class="font-semibold text-muted-foreground">

                            Total

                        </span>

                        <span
                            class="font-display text-2xl font-bold text-primary">

                            Rs {{ number_format($grandTotal, 2) }}

                        </span>

                    </div>


                    <div
                        class="mt-4 rounded-lg bg-accent/10 border border-accent/20 p-3">

                        <div class="flex gap-2">

                            <i
                                data-lucide="info"
                                class="w-4 h-4 text-accent shrink-0 mt-0.5">
                            </i>

                            <p
                                class="text-xs text-muted-foreground leading-5">

                                Payment is made in cash when you collect your order.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <footer
        class="border-t border-border bg-card w-full mt-auto">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 py-12 md:grid-cols-[1.2fr_0.8fr_0.8fr]">

            <div>

                <div
                    class="flex items-center gap-2 text-primary">

                    <i
                        data-lucide="leaf"
                        class="size-6">
                    </i>

                    <span
                        class="font-display text-2xl font-bold">

                        MarketLink

                    </span>

                </div>

                <p
                    class="mt-4 max-w-sm text-sm leading-6 text-muted-foreground">

                    Weekly harvests from the growers who make our
                    neighborhoods taste like home.

                </p>

            </div>


            <div>

                <h3
                    class="text-base font-bold text-primary">

                    Explore

                </h3>

                <div
                    class="mt-4 grid gap-2 text-sm text-muted-foreground">

                    <a
                        class="hover:text-primary transition-colors"
                        href="{{ route('markets') }}">

                        Markets

                    </a>

                    <a
                        class="hover:text-primary transition-colors"
                        href="{{ route('products') }}">

                        Fresh picks

                    </a>

                    <a
                        class="hover:text-primary transition-colors"
                        href="{{ route('login') }}">

                        Grower access

                    </a>

                </div>

            </div>


            <div>

                <h3
                    class="text-base font-bold text-primary">

                    Visit us

                </h3>

                <p
                    class="mt-4 text-sm leading-6 text-muted-foreground">

                    218 Market Lane<br>
                    River District<br>
                    hello@marketlink.local

                </p>

            </div>

        </div>


        <div
            class="border-t border-border py-4 text-center text-xs text-muted-foreground">

            © 2026 MarketLink · Demo experience · Pay in cash at pickup

        </div>

    </footer>


    <script>
        lucide.createIcons();


        const menuBtn =
            document.getElementById('menuBtn');

        const mobileMenu =
            document.getElementById('mobileMenu');

        const menuIcon =
            document.getElementById('menuIcon');

        const closeIcon =
            document.getElementById('closeIcon');


        if (menuBtn) {

            menuBtn.addEventListener('click', () => {

                mobileMenu.classList.toggle('hidden');

                menuIcon.classList.toggle('hidden');

                closeIcon.classList.toggle('hidden');

            });

        }
    </script>
@include('components.ai-chatbot')
</body>

</html>