<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>My Orders — MarketLink</title>


    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

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


<body
    class="min-h-screen bg-background text-foreground antialiased flex flex-col">


    <!-- =========================================================
         TOP BAR
    ========================================================== -->

    <div
        class="bg-primary text-white text-center text-xs font-semibold py-2">

        Autumn harvest pre-orders are now open.

    </div>


    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <header
        class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-20 items-center justify-between">


            <!-- LOGO -->

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


            <!-- NAV -->

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


            <!-- RIGHT -->

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
                            class="border border-border bg-background hover:bg-black/5 h-8 rounded-md px-3 text-xs font-medium">

                            Sign in

                        </button>

                    </a>

                @endauth


                <!-- MOBILE -->

                <button
                    id="menuBtn"
                    class="p-2 md:hidden text-foreground hover:text-primary">

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


        <!-- MOBILE MENU -->

        <div
            id="mobileMenu"
            class="hidden md:hidden border-b border-border bg-background px-6 py-5 shadow-lg">

            <nav class="flex flex-col gap-4">

                <a
                    href="{{ route('markets') }}"
                    class="text-base font-semibold text-primary">

                    Markets

                </a>

                <a
                    href="{{ route('products') }}"
                    class="text-base font-semibold text-foreground/80 hover:text-primary">

                    Fresh Picks

                </a>

                <a
                    href="#"
                    class="text-base font-semibold text-foreground/80 hover:text-primary">

                    Farmer Studio

                </a>

                <div class="pt-2 border-t border-border">

                    <span
                        class="text-sm font-semibold text-primary capitalize">

                        {{ auth()->user()->role ?? 'customer' }}

                    </span>

                </div>

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

                Customer account

            </span>

            <h1
                class="font-display text-4xl sm:text-6xl font-bold mt-2 text-primary">

                My Orders.

            </h1>

            <p
                class="mt-3 max-w-2xl text-muted-foreground">

                Here you can see all the orders you have placed and manage your pending reservations.

            </p>

        </section>


        @if($orders->count() > 0)


            <!-- =================================================
                 ORDERS
            ================================================== -->

            <div class="space-y-5">


                @foreach($orders as $order)


                    @php

                        $total =
                            $order->price *
                            $order->quantity;

                        $status =
                            strtolower($order->status);

                    @endphp


                    <!-- ORDER CARD -->

                    <div
                        class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">


                        <!-- ORDER HEADER -->

                        <div
                            class="px-5 sm:px-6 py-4 border-b border-border bg-background/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">


                            <div>

                                <div
                                    class="flex items-center gap-2">

                                    <i
                                        data-lucide="receipt"
                                        class="w-4 h-4 text-primary">
                                    </i>

                                    <span
                                        class="text-sm font-bold text-primary">

                                        Order #{{ $order->id }}

                                    </span>

                                </div>


                                <p
                                    class="mt-1 text-xs text-muted-foreground">

                                    Placed on
                                    {{ $order->created_at->format('d M Y, h:i A') }}

                                </p>

                            </div>


                            <!-- STATUS -->

                            @if($status === 'pending')

                                <span
                                    class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-yellow-100 text-yellow-800 px-3 py-1.5 text-xs font-bold">

                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-600">
                                    </span>

                                    Pending

                                </span>

                            @elseif($status === 'completed')

                                <span
                                    class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-green-100 text-green-800 px-3 py-1.5 text-xs font-bold">

                                    <i
                                        data-lucide="check"
                                        class="w-3.5 h-3.5">
                                    </i>

                                    Completed

                                </span>

                            @elseif($status === 'cancelled')

                                <span
                                    class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-red-100 text-red-700 px-3 py-1.5 text-xs font-bold">

                                    <i
                                        data-lucide="x"
                                        class="w-3.5 h-3.5">
                                    </i>

                                    Cancelled

                                </span>

                            @elseif($status === 'rejected')

                                <span
                                    class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-red-100 text-red-700 px-3 py-1.5 text-xs font-bold">

                                    <i
                                        data-lucide="ban"
                                        class="w-3.5 h-3.5">
                                    </i>

                                    Rejected

                                </span>

                            @else

                                <span
                                    class="inline-flex items-center rounded-full bg-primary/10 text-primary px-3 py-1.5 text-xs font-bold capitalize">

                                    {{ $order->status }}

                                </span>

                            @endif

                        </div>


                        <!-- ORDER BODY -->

                        <div class="p-5 sm:p-6">


                            <!-- PRODUCT -->

                            <div
                                class="flex flex-col sm:flex-row gap-5">


                                <!-- IMAGE -->

                                @if($order->product && $order->product->image)

                                    <img
                                        src="{{ asset('storage/' . $order->product->image) }}"
                                        alt="{{ $order->product->name }}"
                                        class="w-full sm:w-24 h-48 sm:h-24 rounded-xl object-cover border border-border">

                                @else

                                    <div
                                        class="w-full sm:w-24 h-48 sm:h-24 rounded-xl bg-muted/40 border border-border flex items-center justify-center">

                                        <i
                                            data-lucide="image"
                                            class="w-8 h-8 text-muted-foreground">
                                        </i>

                                    </div>

                                @endif


                                <!-- INFO -->

                                <div class="flex-1">

                                    <h2
                                        class="font-display text-2xl font-bold text-primary">

                                        {{ $order->product->name ?? 'Product removed' }}

                                    </h2>


                                    <div
                                        class="mt-2 text-sm text-muted-foreground space-y-1">

                                        <p>

                                            Quantity:
                                            <strong class="text-foreground">

                                                {{ $order->quantity }}

                                            </strong>

                                        </p>


                                        <p>

                                            Price:
                                            <strong class="text-foreground">

                                                Rs {{ number_format($order->price, 2) }}

                                            </strong>

                                            @if($order->product && $order->product->unit)

                                                / {{ $order->product->unit }}

                                            @endif

                                        </p>

                                    </div>

                                </div>


                                <!-- ITEM TOTAL -->

                                <div
                                    class="sm:text-right">

                                    <p
                                        class="text-xs uppercase tracking-wide font-semibold text-muted-foreground">

                                        Item total

                                    </p>

                                    <p
                                        class="font-display text-2xl font-bold text-primary mt-1">

                                        Rs {{ number_format($total, 2) }}

                                    </p>

                                </div>

                            </div>


                            <!-- DETAILS -->

                            <div
                                class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">


                                <!-- FARMER -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="tractor"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Farmer

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        {{ $order->farmer->farm_name ?? 'N/A' }}

                                    </p>

                                </div>


                                <!-- PICKUP -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="user-round"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Pickup Name

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        {{ $order->pickup_name ?? 'N/A' }}

                                    </p>

                                </div>


                                <!-- PICKUP DATE -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="calendar-days"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Pickup Date

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        @if($order->pickup_date)

                                            {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}

                                        @else

                                            N/A

                                        @endif

                                    </p>

                                </div>


                                <!-- TIME -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="clock-3"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Time Slot

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        {{ $order->time_slot ?? 'N/A' }}

                                    </p>

                                </div>


                                <!-- CUSTOMER -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="user"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Customer

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        {{ $order->customer_name ?? auth()->user()->name }}

                                    </p>

                                </div>


                                <!-- PHONE -->

                                <div
                                    class="rounded-lg border border-border bg-background p-4">

                                    <div
                                        class="flex items-center gap-2 text-muted-foreground">

                                        <i
                                            data-lucide="phone"
                                            class="w-4 h-4">
                                        </i>

                                        <span
                                            class="text-[11px] uppercase tracking-wide font-bold">

                                            Phone

                                        </span>

                                    </div>

                                    <p
                                        class="mt-2 text-sm font-semibold text-foreground">

                                        {{ $order->customer_phone ?? auth()->user()->phone ?? 'N/A' }}

                                    </p>

                                </div>

                            </div>


                            <!-- FOOTER -->

                            <div
                                class="mt-6 pt-5 border-t border-border flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">


                                <!-- CANCEL -->

                                <div>

                                    @if($status === 'pending')

                                        <form
                                            action="{{ route('customer.orders.cancel', $order->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this order?');">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-200">

                                                <i
                                                    data-lucide="x-circle"
                                                    class="w-4 h-4">
                                                </i>

                                                Cancel Order

                                            </button>

                                        </form>

                                    @elseif($status === 'cancelled')

                                        <div
                                            class="inline-flex items-center gap-2 text-sm font-medium text-red-700">

                                            <i
                                                data-lucide="circle-x"
                                                class="w-4 h-4">
                                            </i>

                                            This order was cancelled.

                                        </div>

                                    @elseif($status === 'completed')

                                        <div
                                            class="inline-flex items-center gap-2 text-sm font-medium text-primary">

                                            <i
                                                data-lucide="circle-check"
                                                class="w-4 h-4">
                                            </i>

                                            Order completed.

                                        </div>

                                    @endif

                                </div>


                                <!-- TOTAL -->

                                <div
                                    class="flex items-center justify-between sm:justify-end gap-3">

                                    <span
                                        class="text-sm text-muted-foreground">

                                        Order Total

                                    </span>

                                    <span
                                        class="font-display text-2xl font-bold text-primary">

                                        Rs {{ number_format($total, 2) }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


        @else


            <!-- =================================================
                 EMPTY ORDERS
            ================================================== -->

            <div
                class="bg-card border border-border rounded-xl p-10 sm:p-16 text-center shadow-sm">

                <div
                    class="mx-auto w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">

                    <i
                        data-lucide="shopping-basket"
                        class="w-7 h-7">
                    </i>

                </div>


                <span
                    class="block mt-6 text-xs font-bold tracking-widest uppercase text-accent">

                    Nothing here yet

                </span>


                <h2
                    class="font-display text-3xl font-bold text-primary mt-2">

                    No orders yet.

                </h2>


                <p
                    class="mt-3 max-w-md mx-auto text-sm text-muted-foreground leading-6">

                    You haven't placed any orders yet.
                    Explore our fresh picks and reserve something from a local grower.

                </p>


                <a
                    href="{{ route('products') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-white hover:bg-[#003d1c] transition">

                    <i
                        data-lucide="shopping-basket"
                        class="w-4 h-4">
                    </i>

                    Start Shopping

                </a>

            </div>


        @endif

    </main>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <footer
        class="border-t border-border bg-card w-full mt-auto">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 py-12 md:grid-cols-[1.2fr_0.8fr_0.8fr]">


            <!-- ABOUT -->

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


            <!-- EXPLORE -->

            <div>

                <h3
                    class="text-base font-bold text-primary">

                    Explore

                </h3>

                <div
                    class="mt-4 grid gap-2 text-sm text-muted-foreground">

                    <a
                        href="{{ route('markets') }}"
                        class="hover:text-primary transition-colors">

                        Markets

                    </a>

                    <a
                        href="{{ route('products') }}"
                        class="hover:text-primary transition-colors">

                        Fresh picks

                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="hover:text-primary transition-colors">

                        Grower access

                    </a>

                </div>

            </div>


            <!-- VISIT -->

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


    <!-- =========================================================
         JS
    ========================================================== -->

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