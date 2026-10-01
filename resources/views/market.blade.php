<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markets — MarketLink</title>

    <!-- 1. Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- 2. Tailwind CSS CDN -->
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

    <!-- 3. Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- 4. Leaflet CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

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

        /*
        |--------------------------------------------------------------------------
        | REAL MAP
        |--------------------------------------------------------------------------
        */

        #marketMap {
            position: relative;
            min-height: 480px;
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #e6dfcf;
            overflow: hidden;
        }

        .leaflet-container {
            font-family: 'Work Sans', sans-serif;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px;
        }

        .leaflet-popup-content {
            margin: 14px 16px;
            min-width: 190px;
        }

        .market-popup-title {
            color: #005327;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 6px;
        }

        .market-popup-location {
            color: #66635b;
            font-size: 13px;
            line-height: 1.5;
        }

        .market-popup-link {
            display: inline-block;
            margin-top: 10px;
            background: #005327;
            color: #ffffff !important;
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .market-popup-link:hover {
            background: #003d1d;
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOM MARKET MARKER
        |--------------------------------------------------------------------------
        */

        .custom-market-marker {
            width: 38px;
            height: 38px;
            background: #ca6232;
            border: 3px solid white;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 3px 10px rgba(0, 0, 0, .25);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-market-marker-inner {
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 50%;
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 640px) {

            #marketMap {
                min-height: 400px;
            }

        }

        .grid.gap-5.sm\\:grid-cols-2 {
            height: auto;
        }
    </style>
</head>


<body class="min-h-screen bg-background text-foreground antialiased flex flex-col justify-between">


    <!-- =========================================================
         HEADER / NAVBAR
    ========================================================== -->

    <header class="sticky top-0 z-50 border-b border-border/70 bg-background/90 backdrop-blur-xl">

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex h-20 items-center justify-between">

            <!-- Logo -->

            <a href="/" class="flex items-center gap-2.5">

                <span
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-primary text-primary-foreground">

                    <i data-lucide="leaf" class="size-5"></i>

                </span>

                <span class="font-display text-2xl font-bold text-primary">
                    MarketLink
                </span>

            </a>


            <!-- Desktop Navigation -->

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


            <!-- Right Side -->

            <div class="flex items-center gap-2 sm:gap-3">

                <a
                    href="/favorites"
                    aria-label="Favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i data-lucide="heart" class="size-5"></i>

                </a>


                <a
                    href="/cart"
                    aria-label="Cart"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">

                    <i data-lucide="shopping-basket" class="size-5"></i>

                </a>


                <a href="/login" class="hidden sm:block">

                    <button
                        class="border border-border bg-background hover:bg-black/5 h-8 rounded-md px-3 text-xs font-medium transition-colors">

                        Sign in

                    </button>

                </a>


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

                <a
                    href="/markets"
                    class="text-base font-semibold text-primary transition">

                    Markets

                </a>

                <a
                    href="/products"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Fresh Picks

                </a>

                <a
                    href="/dashboard"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Farmer Studio

                </a>

                <a
                    href="/admin"
                    class="text-base font-semibold text-foreground/80 hover:text-primary transition">

                    Admin

                </a>

                <div class="pt-2 border-t border-border">

                    <a href="/login" class="block w-full">

                        <button
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white transition">

                            Sign in

                        </button>

                    </a>

                </div>

            </nav>

        </div>

    </header>



    <!-- =========================================================
         MAIN
    ========================================================== -->

    <main
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20 w-full flex-grow">


        <!-- Hero Section -->

        <section class="mb-8">

            <span
                class="text-xs font-bold tracking-widest uppercase text-accent">

                Four neighborhoods · 80 growers

            </span>

            <h1
                class="text-4xl sm:text-6xl font-bold mt-2 text-primary">

                Find your market.

            </h1>

            <p
                class="mt-3 max-w-2xl text-muted-foreground">

                See who is setting up this week, what they are bringing,
                and when to collect your order.

            </p>

        </section>



        <!-- =====================================================
             MAIN CONTENT
        ====================================================== -->

        <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr]">


            <!-- =================================================
                 LEFT SIDE — ORIGINAL MARKET CARDS
            ================================================== -->

            <div class="grid gap-5 sm:grid-cols-2">

                @forelse($markets as $market)

                <a
                    href="{{ url('/markets/' . $market->id) }}"
                    class="group bg-card rounded-xl overflow-hidden border border-border shadow-sm hover:shadow-md transition">


                    <!-- Market Image -->

                    @if($market->image)

                    <img
                        src="{{ asset('storage/' . $market->image) }}"
                        alt="{{ $market->name }}"
                        class="aspect-[4/3] w-full object-cover group-hover:scale-[1.025] transition duration-500">

                    @else

                    <img
                        src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80"
                        alt="{{ $market->name }}"
                        class="aspect-[4/3] w-full object-cover group-hover:scale-[1.025] transition duration-500">

                    @endif


                    <!-- Card Content -->

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <h3
                                    class="text-xl font-bold text-primary leading-snug">

                                    {{ $market->name }}

                                </h3>

                                <p
                                    class="mt-1 text-sm text-muted-foreground">

                                    {{ $market->location }}

                                </p>

                            </div>


                            <i
                                data-lucide="arrow-right"
                                class="size-5 text-accent mt-1 shrink-0">
                            </i>

                        </div>


                        <!-- Card Bottom -->

                        <div
                            class="mt-5 flex items-center justify-between border-t border-border pt-4 text-xs text-muted-foreground">


                            <!-- Day + Time -->

                            <span class="flex items-center gap-1.5">

                                <i
                                    data-lucide="calendar-days"
                                    class="size-4">
                                </i>

                                {{ $market->days }}

                                @if($market->timing)

                                · {{ $market->timing }}

                                @endif

                            </span>


                            <!-- Vendors -->

                            <span>

                                {{ $market->farmers_count }} vendors

                            </span>

                        </div>

                    </div>

                </a>


                @empty


                <!-- No Markets -->

                <div
                    class="sm:col-span-2 bg-white border border-border rounded-xl p-10 text-center">

                    <div class="flex justify-center mb-4">

                        <div
                            class="w-14 h-14 rounded-full bg-[#005327]/10 flex items-center justify-center">

                            <i
                                data-lucide="store"
                                class="w-7 h-7 text-primary">
                            </i>

                        </div>

                    </div>

                    <h3
                        class="text-xl font-bold text-primary">

                        No markets available

                    </h3>

                    <p
                        class="mt-2 text-sm text-muted-foreground">

                        There are currently no markets available.

                    </p>

                </div>


                @endforelse

            </div>



            <!-- =================================================
                 RIGHT SIDE — REAL MAP
            ================================================== -->

            <div class="hidden sm:block">

                <div class="sticky top-24">


                    <!-- Map Heading -->

                    <div
                        class="flex items-center justify-between mb-3">

                        <div>

                            <h2
                                class="text-xl font-bold text-primary">

                                Market Locations

                            </h2>

                            <p
                                class="text-sm text-muted-foreground mt-1">

                                Find our markets near you.

                            </p>

                        </div>


                        <span
                            id="marketCount"
                            class="text-xs font-semibold bg-primary/10 text-primary px-3 py-1.5 rounded-full">

                            {{ $markets->count() }} Markets

                        </span>

                    </div>


                    <!-- REAL MAP -->

                    <div
                        id="marketMap"
                        class="shadow-sm">
                    </div>


                    <!-- Map Footer -->

                    <div
                        class="mt-3 flex items-center justify-between">

                        <div
                            class="flex items-center gap-2 text-xs text-muted-foreground">

                            <span
                                class="w-2.5 h-2.5 rounded-full bg-accent">
                            </span>

                            <span>
                                Market location
                            </span>

                        </div>


                        <span
                            class="text-[11px] text-muted-foreground">

                            OpenStreetMap

                        </span>

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
                        class="text-primary font-semibold"
                        href="/markets">

                        Markets

                    </a>

                    <a
                        class="hover:text-primary transition-colors"
                        href="/products">

                        Fresh picks

                    </a>

                    <a
                        class="hover:text-primary transition-colors"
                        href="/login">

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



    <!-- =========================================================
         LEAFLET JS
    ========================================================== -->

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
    </script>



    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>
        /*
        |--------------------------------------------------------------------------
        | LUCIDE ICONS
        |--------------------------------------------------------------------------
        */

        lucide.createIcons();



        /*
        |--------------------------------------------------------------------------
        | MOBILE MENU
        |--------------------------------------------------------------------------
        */

        const menuBtn =
            document.getElementById('menuBtn');

        const mobileMenu =
            document.getElementById('mobileMenu');

        const menuIcon =
            document.getElementById('menuIcon');

        const closeIcon =
            document.getElementById('closeIcon');


        menuBtn.addEventListener('click', () => {

            mobileMenu.classList.toggle('hidden');

            menuIcon.classList.toggle('hidden');

            closeIcon.classList.toggle('hidden');

        });



        /*
        |--------------------------------------------------------------------------
        | MARKET DATA FROM LARAVEL
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Direct @json($markets) use kiya gaya hai.
        | Isse Blade ParseError nahi aayega.
        |
        */

        const markets = @json($markets);



        /*
        |--------------------------------------------------------------------------
        | CREATE LEAFLET MAP
        |--------------------------------------------------------------------------
        */

        const map =
            L.map('marketMap', {

                scrollWheelZoom: true

            });



        /*
        |--------------------------------------------------------------------------
        | OPENSTREETMAP TILES
        |--------------------------------------------------------------------------
        */

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

                maxZoom: 19,

                attribution: '&copy; OpenStreetMap contributors'

            }
        ).addTo(map);



        /*
        |--------------------------------------------------------------------------
        | DEFAULT MAP POSITION
        |--------------------------------------------------------------------------
        |
        | Agar abhi market locations load nahi hui hain
        | to map Karachi par start hoga.
        |
        */

        map.setView(
            [24.8607, 67.0011],
            11
        );



        /*
        |--------------------------------------------------------------------------
        | MARKERS ARRAY
        |--------------------------------------------------------------------------
        */

        const markers = [];



        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            if (!value) {

                return '';

            }

            return String(value)

                .replace(/&/g, '&amp;')

                .replace(/</g, '&lt;')

                .replace(/>/g, '&gt;')

                .replace(/"/g, '&quot;')

                .replace(/'/g, '&#039;');

        }



        /*
        |--------------------------------------------------------------------------
        | ADD MARKET MARKER
        |--------------------------------------------------------------------------
        */

        async function addMarketMarker(market) {

            if (!market.location) {

                return;

            }


            try {

                /*
                |--------------------------------------------------------------------------
                | GEOCODE MARKET LOCATION
                |--------------------------------------------------------------------------
                */

                const response = await fetch(

                    'https://nominatim.openstreetmap.org/search?' +

                    new URLSearchParams({

                        q: market.location,

                        format: 'json',

                        limit: 1

                    }),

                    {

                        headers: {

                            'Accept': 'application/json'

                        }

                    }

                );


                const data =
                    await response.json();



                /*
                |--------------------------------------------------------------------------
                | LOCATION NOT FOUND
                |--------------------------------------------------------------------------
                */

                if (
                    !data ||
                    data.length === 0
                ) {

                    console.warn(
                        'Location not found:',
                        market.location
                    );

                    return;

                }



                /*
                |--------------------------------------------------------------------------
                | GET COORDINATES
                |--------------------------------------------------------------------------
                */

                const latitude =
                    parseFloat(data[0].lat);

                const longitude =
                    parseFloat(data[0].lon);



                /*
                |--------------------------------------------------------------------------
                | CUSTOM MARKET ICON
                |--------------------------------------------------------------------------
                */

                const marketIcon =
                    L.divIcon({

                        className: '',

                        html: `

                            <div class="custom-market-marker">

                                <div
                                    class="custom-market-marker-inner">
                                </div>

                            </div>

                        `,

                        iconSize: [38, 38],

                        iconAnchor: [19, 38],

                        popupAnchor: [0, -38]

                    });



                /*
                |--------------------------------------------------------------------------
                | CREATE MARKER
                |--------------------------------------------------------------------------
                */

                const marker =
                    L.marker(

                        [
                            latitude,
                            longitude
                        ],

                        {
                            icon: marketIcon
                        }

                    ).addTo(map);



                /*
                |--------------------------------------------------------------------------
                | POPUP
                |--------------------------------------------------------------------------
                */

                let popupContent = `

                    <div>

                        <div class="market-popup-title">

                            ${escapeHtml(market.name)}

                        </div>


                        <div class="market-popup-location">

                            ${escapeHtml(market.location)}

                        </div>

                `;



                /*
                |--------------------------------------------------------------------------
                | DAYS
                |--------------------------------------------------------------------------
                */

                if (market.days) {

                    popupContent += `

                        <div
                            class="market-popup-location"
                            style="margin-top:6px;">

                            📅
                            ${escapeHtml(market.days)}

                        </div>

                    `;

                }



                /*
                |--------------------------------------------------------------------------
                | TIMING
                |--------------------------------------------------------------------------
                */

                if (market.timing) {

                    popupContent += `

                        <div
                            class="market-popup-location">

                            🕐
                            ${escapeHtml(market.timing)}

                        </div>

                    `;

                }



                /*
                |--------------------------------------------------------------------------
                | VIEW MARKET BUTTON
                |--------------------------------------------------------------------------
                */

                popupContent += `

                        <a
                            href="/markets/${market.id}"
                            class="market-popup-link">

                            View Market

                        </a>

                    </div>

                `;



                /*
                |--------------------------------------------------------------------------
                | BIND POPUP
                |--------------------------------------------------------------------------
                */

                marker.bindPopup(
                    popupContent
                );



                /*
                |--------------------------------------------------------------------------
                | SAVE MARKER
                |--------------------------------------------------------------------------
                */

                markers.push(
                    marker
                );



            } catch (error) {

                console.error(

                    'Map location error:',

                    market.location,

                    error

                );

            }

        }



        /*
        |--------------------------------------------------------------------------
        | LOAD ALL MARKETS
        |--------------------------------------------------------------------------
        */

        async function loadMarkets() {

            if (!markets.length) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | LOOP THROUGH MARKETS
            |--------------------------------------------------------------------------
            */

            for (
                const market of markets
            ) {

                await addMarketMarker(
                    market
                );


                /*
                |--------------------------------------------------------------------------
                | WAIT 1 SECOND
                |--------------------------------------------------------------------------
                |
                | Nominatim ko bohat zyada requests ek saath nahi bhejni.
                |
                */

                await new Promise(

                    resolve =>
                    setTimeout(
                        resolve,
                        1000
                    )

                );

            }



            /*
            |--------------------------------------------------------------------------
            | ONE MARKET
            |--------------------------------------------------------------------------
            */

            if (
                markers.length === 1
            ) {

                const position =
                    markers[0].getLatLng();

                map.setView(

                    position,

                    13

                );

            }



            /*
            |--------------------------------------------------------------------------
            | MULTIPLE MARKETS
            |--------------------------------------------------------------------------
            */

            if (
                markers.length > 1
            ) {

                const group =
                    L.featureGroup(
                        markers
                    );

                map.fitBounds(

                    group.getBounds(),

                    {

                        padding: [
                            40,
                            40
                        ],

                        maxZoom: 14

                    }

                );

            }

        }



        /*
        |--------------------------------------------------------------------------
        | START MARKET MAP
        |--------------------------------------------------------------------------
        */

        loadMarkets();
    </script>
@include('components.ai-chatbot')
</body>

</html>