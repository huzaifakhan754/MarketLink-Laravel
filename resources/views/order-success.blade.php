<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Order Placed — MarketLink</title>


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
         HEADER / NAVBAR
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


            <!-- RIGHT -->

            <div class="flex items-center gap-2 sm:gap-3">

                <a
                    href="/favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i
                        data-lucide="heart"
                        class="size-5">
                    </i>

                </a>


                <a
                    href="{{ route('cart.index') }}"
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
                    class="text-base font-semibold text-foreground/80 hover:text-primary">

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

                @auth

                <div class="pt-2 border-t border-border">

                    <span
                        class="text-sm font-semibold text-primary capitalize">

                        {{ auth()->user()->role ?? 'customer' }}

                    </span>

                </div>

                @endauth

            </nav>

        </div>

    </header>


    <!-- =========================================================
         SUCCESS
    ========================================================== -->

    <main
        class="flex-grow flex items-center justify-center px-4 py-20">

        <div
            class="w-full max-w-2xl text-center">


            <!-- SUCCESS ICON -->

            <div
                class="mx-auto w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary">

                <div
                    class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-white shadow-sm">

                    <i
                        data-lucide="check"
                        class="w-8 h-8">
                    </i>

                </div>

            </div>


            <!-- LABEL -->

            <span
                class="inline-block mt-7 text-xs font-bold tracking-widest uppercase text-accent">

                Reservation confirmed

            </span>


            <!-- TITLE -->

            <h1
                class="font-display text-4xl sm:text-6xl font-bold text-primary mt-2">

                Your order is placed!

            </h1>


            <!-- TEXT -->

            <p
                class="mt-5 max-w-xl mx-auto text-muted-foreground text-base sm:text-lg leading-7">

                Your growers are preparing everything.
                Your order will be ready for pickup at the selected time.

            </p>


            <!-- CASH INFO -->

            <div
                class="max-w-md mx-auto mt-7 rounded-xl border border-border bg-card p-4">

                <div class="flex items-center justify-center gap-2">

                    <i
                        data-lucide="banknote"
                        class="w-5 h-5 text-accent">
                    </i>

                    <span
                        class="text-sm font-semibold text-primary">

                        Pay in cash at pickup

                    </span>

                </div>

            </div>


            <!-- ACTIONS -->

            <div
                class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">

                <a
                    href="{{ route('customer.orders') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-7 py-3 text-sm font-semibold text-white hover:bg-[#003d1c] transition shadow-sm">

                    <i
                        data-lucide="clipboard-list"
                        class="w-4 h-4">
                    </i>

                    View Order

                </a>


                <a
                    href="{{ route('products') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg border border-border bg-card px-7 py-3 text-sm font-semibold text-primary hover:bg-primary/5 transition">

                    <i
                        data-lucide="shopping-basket"
                        class="w-4 h-4">
                    </i>

                    Continue Shopping

                </a>

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
                        href="{{ route('markets') }}"
                        class="hover:text-primary transition">

                        Markets

                    </a>

                    <a
                        href="{{ route('products') }}"
                        class="hover:text-primary transition">

                        Fresh picks

                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="hover:text-primary transition">

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