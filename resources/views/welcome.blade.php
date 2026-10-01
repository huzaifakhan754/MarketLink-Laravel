<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MarketLink — Farm Fresh, Just a Click Away</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        background: '#F7F3ED',
                        foreground: '#1C2826',
                        primary: {
                            DEFAULT: '#005327',
                            foreground: '#F4EFEA',
                        },
                        secondary: {
                            DEFAULT: '#EEE7DC',
                            foreground: '#1C2826',
                        },
                        accent: {
                            DEFAULT: '#005327',
                            foreground: '#FFFFFF',
                        },
                        card: '#FBF8F3',
                        muted: {
                            DEFAULT: '#E1D9CD',
                            foreground: '#6B7280',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F7F3ED;
            color: #1C2826;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        .container-shell {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #005327;
        }

        .process-card {
            background: #FBF8F3;
            border: 1px solid rgba(30, 58, 43, 0.08);
            border-radius: 1rem;
            padding: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .process-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .market-card {
            background: #FBF8F3;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(30, 58, 43, 0.08);
            transition: all 0.3s ease;
            display: block;
        }

        .market-card:hover {
            box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        #aiChatWindow {
            animation: aiChatOpen 0.22s ease-out;
            transform-origin: bottom right;
        }

        @keyframes aiChatOpen {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        #aiMessages {
            scrollbar-width: thin;
            scrollbar-color: #c9c9c9 transparent;
        }

        #aiMessages::-webkit-scrollbar {
            width: 6px;
        }

        #aiMessages::-webkit-scrollbar-track {
            background: transparent;
        }

        #aiMessages::-webkit-scrollbar-thumb {
            background: #c9c9c9;
            border-radius: 20px;
        }

        #aiMessages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        #aiOpenButton {
            box-shadow: 0 15px 35px rgba(0, 83, 39, 0.28);
        }

        #aiOpenButton:hover {
            box-shadow: 0 18px 42px rgba(0, 83, 39, 0.35);
        }

        #aiOpenButton::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 9999px;
            border: 2px solid rgba(0, 83, 39, 0.15);
            animation: aiPulse 2.2s infinite;
        }

        @keyframes aiPulse {
            0% {
                transform: scale(0.95);
                opacity: 0.8;
            }

            70% {
                transform: scale(1.12);
                opacity: 0;
            }

            100% {
                transform: scale(1.12);
                opacity: 0;
            }
        }

        .ai-message {
            animation: messageIn 0.2s ease-out;
        }

        @keyframes messageIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ai-dot {
            animation: aiDot 1.2s infinite ease-in-out;
        }

        .ai-dot:nth-child(2) {
            animation-delay: 0.15s;
        }

        .ai-dot:nth-child(3) {
            animation-delay: 0.30s;
        }

        @keyframes aiDot {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: 0.35;
            }

            30% {
                transform: translateY(-4px);
                opacity: 1;
            }
        }

        #aiMessageInput {
            min-height: 50px;
            max-height: 120px;
            resize: none;
            overflow-y: auto;
        }

        #aiMessageInput::-webkit-scrollbar {
            width: 4px;
        }

        #aiMessageInput::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .ai-quick-btn {
            transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
        }

        .ai-quick-btn:hover {
            transform: translateY(-1px);
        }

        div#aiMessages {
            height: 46vh;
        }

        @media (max-width: 640px) {
            #aiChatWindow {
                left: 12px;
                right: 12px;
                bottom: 12px;
                width: auto;
                max-width: none;
                height: 78vh;
                max-height: 720px;
                border-radius: 24px;
            }

            #aiMessages {
                height: calc(78vh - 185px);
                max-height: 535px;
            }

            #aiOpenButton {
                right: 18px;
                bottom: 18px;
                width: 58px;
                height: 58px;
            }

            .product-img {
                width: 100%;
                height: 100%;
                border-radius: 13px;
                object-fit: cover;
                background: #f3f1ec;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-background text-foreground antialiased flex flex-col justify-between">

    <div class="bg-primary px-4 py-2.5 text-center text-xs font-semibold text-primary-foreground tracking-wide">
        Autumn harvest pre-orders are now open.
    </div>

    <header class="sticky top-0 z-50 border-b border-muted/30 bg-background/90 backdrop-blur-xl">
        <div class="container-shell flex h-20 items-center justify-between">

            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <span class="grid size-9 place-items-center rounded-full bg-primary text-primary-foreground">
                    <i data-lucide="leaf" class="size-5"></i>
                </span>

                <span class="font-display text-2xl font-bold text-primary tracking-tight">
                    MarketLink
                </span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">

                <a href="{{ route('products') }}"
                    class="text-sm font-medium text-foreground/80 hover:text-primary transition">
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
            <div class="flex items-center gap-2 sm:gap-3">

                <a href="/favorites"
                    aria-label="Favorites"
                    class="p-2 hover:bg-black/5 rounded-full transition-colors">
                    <i data-lucide="heart" class="size-5"></i>
                </a>
                @php

                $cart = session('cart', []);

                $cartCount = 0;

                foreach ($cart as $item) {
                $cartCount += $item['quantity'] ?? 0;
                }

                @endphp
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

                <button id="menuBtn"
                    type="button"
                    class="p-2 md:hidden text-foreground hover:text-primary transition focus:outline-none"
                    aria-label="Toggle Navigation">

                    <i data-lucide="menu" id="menuIcon" class="size-6"></i>
                    <i data-lucide="x" id="closeIcon" class="size-6 hidden"></i>

                </button>

            </div>
        </div>

        <div id="mobileMenu"
            class="hidden md:hidden border-b border-muted bg-background px-6 py-5 shadow-lg">

            <nav class="flex flex-col gap-4">

                <a href="{{ route('products') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Fresh Picks
                </a>

                <a href="{{ route('smart-basket.index') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-mutedn">
                    Smart Basket
                </a>

                <a href="{{ route('price-compare.index') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Price Compare
                </a>

                <a href="{{ route('compare-shopping.index') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Basket Saver
                </a>

                <a href="{{ route('markets') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-muted">
                    Markets
                </a>

                <a href="{{ route('customer.dashboard') }}"
                    class="block px-4 py-3 rounded-xl hover:bg-muted">
                    My Dashboard
                </a>
                @auth
                <div class="pt-2 border-t border-muted">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white transition">
                            Logout
                        </button>
                    </form>
                </div>

                @else

                <div class="pt-2 border-t border-muted">
                    <a href="{{ route('login') }}" class="block w-full">
                        <button type="button"
                            class="w-full text-center rounded-lg bg-primary py-2.5 text-sm font-semibold text-white transition">
                            Sign in
                        </button>
                    </a>
                </div>

                @endauth

            </nav>
        </div>
    </header>

    <main class="flex-grow">

        <section class="relative overflow-hidden bg-[#F7F3ED]">

            <div class="absolute inset-0">

                <img src="{{ asset('assets/hero-market.jpg') }}"
                    alt="Farmer with fresh harvest"
                    class="w-full h-full object-cover object-center brightness-110 saturate-105">

                <div class="absolute inset-0 bg-[#F7F3ED]/30"></div>

                <div class="absolute inset-0 bg-gradient-to-r from-[#F7F3ED] via-[#F7F3ED]/70 via-45% to-transparent"></div>

                <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-[#F7F3ED]/80 to-transparent"></div>

            </div>

            <div class="container-shell relative z-10 flex min-h-[560px] items-center py-20 sm:min-h-[600px] lg:min-h-[650px]">

                <div class="max-w-xl">

                    <div class="mb-5 flex items-center gap-3">
                        <span class="h-px w-10 bg-[#CA6232]"></span>

                        <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#CA6232]">
                            Fresh from people you know
                        </span>
                    </div>

                    <h1 class="font-display text-4xl font-semibold leading-[1.08] tracking-tight text-[#005327] sm:text-5xl lg:text-6xl">
                        Farm fresh,
                        <span class="block italic text-[#176B45]">
                            just a click away.
                        </span>
                    </h1>

                    <p class="mt-6 max-w-lg text-base leading-7 text-[#4F5B55] sm:text-lg">
                        Discover this week's harvest, reserve your favorites,
                        and collect them from trusted growers at your neighborhood market.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">

                        <a href="{{ route('markets') }}"
                            class="group inline-flex items-center gap-2 rounded-xl bg-[#005327] px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#005327]/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#073F24] hover:shadow-xl">

                            Browse markets

                            <i data-lucide="arrow-right"
                                class="size-4 transition-transform duration-300 group-hover:translate-x-1">
                            </i>

                        </a>

                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-[#005327]/15 bg-[#FBF8F3]/85 px-6 py-3.5 text-sm font-semibold text-[#005327] shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#FBF8F3] hover:shadow-md">

                            <i data-lucide="sprout" class="size-4"></i>

                            I'm a farmer

                        </a>

                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs font-medium text-[#59645E]">

                        <span class="flex items-center gap-2">
                            <span class="grid size-7 place-items-center rounded-full bg-[#FBF8F3]/85 shadow-sm">
                                <i data-lucide="leaf" class="size-3.5 text-[#005327]"></i>
                            </span>
                            Local growers
                        </span>

                        <span class="flex items-center gap-2">
                            <span class="grid size-7 place-items-center rounded-full bg-[#FBF8F3]/85 shadow-sm">
                                <i data-lucide="map-pin" class="size-3.5 text-[#CA6232]"></i>
                            </span>
                            Nearby markets
                        </span>

                        <span class="flex items-center gap-2">
                            <span class="grid size-7 place-items-center rounded-full bg-[#FBF8F3]/85 shadow-sm">
                                <i data-lucide="shopping-basket" class="size-3.5 text-[#005327]"></i>
                            </span>
                            Easy pickup
                        </span>

                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#F7F3ED] py-20 lg:py-28">

            <div class="container-shell">

                <div class="max-w-2xl">

                    <span class="eyebrow">
                        A simpler market day
                    </span>

                    <h2 class="font-display mt-3 text-4xl font-semibold text-primary sm:text-5xl">
                        Good food, thoughtfully connected.
                    </h2>

                    <p class="mt-4 text-lg text-foreground/70">
                        Reserve directly from local growers and keep every dollar closer to home.
                    </p>

                </div>

                <div class="mt-14 grid gap-6 md:grid-cols-3">

                    <div class="process-card">

                        <div class="flex items-center justify-between">

                            <span class="font-display text-2xl font-bold text-accent">
                                01
                            </span>

                            <i data-lucide="search" class="size-6 text-accent"></i>

                        </div>

                        <h3 class="font-display mt-6 text-2xl font-semibold text-primary">
                            Browse nearby
                        </h3>

                        <p class="mt-3 text-sm leading-relaxed text-foreground/70">
                            Explore markets, growers, and their fresh weekly stock.
                        </p>

                    </div>

                    <div class="process-card">

                        <div class="flex items-center justify-between">

                            <span class="font-display text-2xl font-bold text-accent">
                                02
                            </span>

                            <i data-lucide="shopping-basket" class="size-6 text-accent"></i>

                        </div>

                        <h3 class="font-display mt-6 text-2xl font-semibold text-primary">
                            Reserve your harvest
                        </h3>

                        <p class="mt-3 text-sm leading-relaxed text-foreground/70">
                            Build a basket before popular seasonal picks sell out.
                        </p>

                    </div>

                    <div class="process-card">

                        <div class="flex items-center justify-between">

                            <span class="font-display text-2xl font-bold text-accent">
                                03
                            </span>

                            <i data-lucide="store" class="size-6 text-accent"></i>

                        </div>

                        <h3 class="font-display mt-6 text-2xl font-semibold text-primary">
                            Pickup & pay
                        </h3>

                        <p class="mt-3 text-sm leading-relaxed text-foreground/70">
                            Meet your farmer and pay in cash when you collect.
                        </p>

                    </div>

                </div>
            </div>
        </section>

        <section class="bg-[#F7F3ED] py-12 lg:py-16">

            <div class="container-shell">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <span class="eyebrow">
                            Fresh choices
                        </span>

                        <h2 class="font-display mt-2 text-3xl font-semibold text-primary sm:text-4xl">
                            Shop by category.
                        </h2>

                    </div>

                    <a href="{{ route('products') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#005327] hover:underline">

                        View all products

                        <i data-lucide="arrow-right" class="size-4"></i>

                    </a>

                </div>

                <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">

                    @foreach($categories as $category)

                    <button type="button"
                        onclick="showCategoryProducts({{ $category->id }})"
                        id="category-btn-{{ $category->id }}"
                        class="category-button group rounded-2xl border border-[#005327]/10 bg-[#FBF8F3] px-5 py-5 text-left transition-all duration-300 hover:-translate-y-1 hover:border-[#005327]/25 hover:shadow-md">

                        <div class="flex items-center justify-between gap-3">

                            <div class="grid size-11 shrink-0 place-items-center rounded-xl bg-[#EAF3ED] text-[#005327]">
                                <i data-lucide="leaf" class="size-5"></i>
                            </div>

                            <i data-lucide="arrow-up-right"
                                class="size-4 text-[#8A948E] transition group-hover:text-[#005327]">
                            </i>

                        </div>

                        <h3 class="mt-4 font-display text-lg font-semibold text-[#005327]">
                            {{ $category->name }}
                        </h3>

                    </button>

                    @endforeach

                </div>

                <div id="categoryProductsSection" class="mt-10 hidden">

                    <div class="mb-6 flex items-center justify-between">

                        <div>

                            <span class="eyebrow">
                                Category products
                            </span>

                            <h3 id="selectedCategoryTitle"
                                class="font-display mt-2 text-2xl font-semibold text-[#005327]">
                            </h3>

                        </div>

                        <a href="{{ route('products') }}"
                            class="hidden items-center gap-1.5 text-sm font-semibold text-[#005327] hover:underline sm:inline-flex">

                            See all

                            <i data-lucide="arrow-right" class="size-4"></i>

                        </a>

                    </div>

                    @foreach($categories as $category)

                    <div id="category-products-{{ $category->id }}"
                        class="category-products hidden">

                        @if(isset($categoryProducts[$category->id]) && $categoryProducts[$category->id]->count() > 0)

                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                            @foreach($categoryProducts[$category->id] as $product)

                            <div class="group overflow-hidden rounded-2xl border border-[#005327]/10 bg-[#FBF8F3] transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">

                                <div class="relative aspect-[4/3] overflow-hidden bg-[#EEE7DC]">

                                    @if($product->image)

                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                                    @else

                                    <div class="flex h-full w-full items-center justify-center">

                                        <i data-lucide="leaf"
                                            class="size-12 text-[#005327]/30">
                                        </i>

                                    </div>

                                    @endif

                                </div>

                                <div class="p-5">

                                    <h4 class="font-display text-xl font-semibold text-[#005327]">
                                        {{ $product->name }}
                                    </h4>

                                    <div class="mt-3 flex items-center justify-between">

                                        <div>

                                            <span class="text-lg font-bold text-[#005327]">
                                                Rs. {{ number_format($product->price, 0) }}
                                            </span>

                                            <span class="text-xs text-gray-500">
                                                / {{ $product->unit }}
                                            </span>

                                        </div>

                                        <span class="rounded-full bg-[#EAF3ED] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#005327]">
                                            Fresh
                                        </span>

                                    </div>

                                    <a href="{{ route('products') }}"
                                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#005327] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#073F24]">

                                        View product

                                        <i data-lucide="arrow-right" class="size-3.5"></i>

                                    </a>

                                </div>
                            </div>

                            @endforeach

                        </div>

                        @else

                        <div class="rounded-2xl border border-[#005327]/10 bg-[#FBF8F3] px-6 py-12 text-center">

                            <i data-lucide="package-open"
                                class="mx-auto size-10 text-[#005327]/40">
                            </i>

                            <p class="mt-3 text-sm text-gray-500">
                                No products available in this category yet.
                            </p>

                        </div>

                        @endif

                    </div>

                    @endforeach

                </div>
            </div>
        </section>

        <section class="bg-[#EEE7DC]/55 py-20 lg:py-28">

            <div class="container-shell">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <span class="eyebrow">
                            Around the corner
                        </span>

                        <h2 class="font-display mt-3 text-4xl font-semibold text-primary sm:text-5xl">
                            Markets worth waking up for.
                        </h2>

                    </div>

                    <a href="{{ route('markets') }}"
                        class="inline-flex items-center gap-2 font-semibold text-accent hover:underline">

                        See all markets

                        <i data-lucide="arrow-right" class="size-4"></i>

                    </a>

                </div>

                @if($markets->count() > 0)

                <div class="mt-12 grid gap-6 md:grid-cols-3">

                    @foreach($markets->take(3) as $market)

                    <a href="{{ route('market.details', $market->id) }}"
                        class="market-card group">

                        <div class="aspect-[4/3] w-full overflow-hidden bg-muted">

                            @if($market->image)

                            <img src="{{ asset('storage/' . $market->image) }}"
                                alt="{{ $market->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                            @else

                            <img src="https://images.unsplash.com/photo-1533900298318-6b8da08a523e?auto=format&fit=crop&q=80&w=800"
                                alt="{{ $market->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                            @endif

                        </div>

                        <div class="p-6">

                            <h3 class="font-display text-2xl font-semibold text-primary">
                                {{ $market->name }}
                            </h3>

                            @if($market->location)

                            <p class="mt-1 text-sm text-foreground/60">
                                {{ $market->location }}
                            </p>

                            @endif

                            <div class="mt-6 flex items-center justify-between border-t border-muted/80 pt-4 text-xs font-medium text-foreground/60">

                                <span class="flex items-center gap-1.5">

                                    <i data-lucide="calendar" class="size-4"></i>

                                    {{ $market->days ?? 'Market days' }}

                                    @if($market->timing)
                                    · {{ $market->timing }}
                                    @endif

                                </span>

                                <span>
                                    {{ $market->vendor_count }}
                                    {{ $market->vendor_count == 1 ? 'vendor' : 'vendors' }}
                                </span>

                            </div>

                        </div>

                    </a>

                    @endforeach

                </div>

                @else

                <div class="mt-12 rounded-2xl border border-muted bg-[#FBF8F3] p-12 text-center">

                    <i data-lucide="store"
                        class="mx-auto size-10 text-primary">
                    </i>

                    <h3 class="font-display mt-4 text-2xl font-semibold text-primary">
                        No markets available yet.
                    </h3>

                    <p class="mt-2 text-sm text-foreground/60">
                        Markets will appear here when they are added.
                    </p>

                </div>

                @endif

            </div>
        </section>

    </main>

    <footer class="border-t border-muted/80 bg-[#F1ECE4]">

        <div class="container-shell grid gap-10 py-16 md:grid-cols-3">

            <div>

                <div class="flex items-center gap-2.5 text-primary">

                    <i data-lucide="leaf" class="size-6"></i>

                    <span class="font-display text-2xl font-bold">
                        MarketLink
                    </span>

                </div>

                <p class="mt-4 max-w-sm text-sm leading-relaxed text-foreground/70">
                    Weekly harvests from the growers who make our neighborhoods taste like home.
                </p>

            </div>

            <div>

                <h4 class="font-display text-lg font-semibold text-primary">
                    Explore
                </h4>

                <ul class="mt-4 space-y-2.5 text-sm text-foreground/70">

                    <li>
                        <a href="{{ route('markets') }}" class="hover:text-primary">
                            Markets
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products') }}" class="hover:text-primary">
                            Fresh picks
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}" class="hover:text-primary">
                            Grower access
                        </a>
                    </li>

                </ul>

            </div>

            <div>

                <h4 class="font-display text-lg font-semibold text-primary">
                    Visit us
                </h4>

                <p class="mt-4 text-sm leading-relaxed text-foreground/70">
                    218 Market Lane<br>
                    River District<br>
                    hello@marketlink.local
                </p>

            </div>

        </div>

        <div class="border-t border-muted/60 py-6 text-center text-xs text-foreground/50">
            © 2026 MarketLink · Demo experience · Pay in cash at pickup
        </div>

    </footer>

    <div id="marketLinkAI">

        <button id="aiOpenButton"
            type="button"
            class="fixed bottom-6 right-6 z-[9999] w-16 h-16 rounded-full bg-[#005327] text-white shadow-2xl flex items-center justify-center hover:scale-105 transition duration-200"
            aria-label="Open MarketLink AI">

            <i class="fa-solid fa-robot text-2xl"></i>

        </button>

        <div id="aiChatWindow"
            class="hidden fixed bottom-6 right-6 z-[9998] w-[430px] max-w-[calc(100vw-24px)] h-[680px] max-h-[84vh] bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">

            <div class="relative bg-[#005327] text-white px-5 py-4">

                <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-white/5 -translate-y-16 translate-x-10"></div>

                <div class="relative flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="relative w-12 h-12 rounded-2xl bg-white text-[#005327] flex items-center justify-center shadow-lg">

                            <i class="fa-solid fa-robot text-xl"></i>

                            <span class="absolute bottom-0.5 right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-[#005327]"></span>

                        </div>

                        <div>

                            <div class="flex items-center gap-2">

                                <h3 class="font-bold text-base">
                                    MarketLink AI
                                </h3>

                                <span class="rounded-full bg-white/10 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider">
                                    AI
                                </span>

                            </div>

                            <p class="mt-0.5 text-xs text-white/70">
                                Your smart shopping assistant
                            </p>

                        </div>

                    </div>

                    <button id="aiCloseButton"
                        type="button"
                        class="relative w-9 h-9 rounded-xl hover:bg-white/10 flex items-center justify-center transition"
                        aria-label="Close AI">

                        <i class="fa-solid fa-xmark text-lg"></i>

                    </button>

                </div>
            </div>

            <div class="bg-white border-b border-gray-100 px-4 py-3">

                <div class="flex gap-2 overflow-x-auto pb-0.5">

                    <button type="button"
                        class="ai-quick-btn shrink-0 inline-flex items-center gap-1.5 rounded-full border border-[#005327]/15 bg-[#F4F9F6] px-3 py-1.5 text-xs font-semibold text-[#005327]"
                        data-ai-command="Market page kholo">

                        <i class="fa-solid fa-store text-[10px]"></i>
                        Markets

                    </button>

                    <button type="button"
                        class="ai-quick-btn shrink-0 inline-flex items-center gap-1.5 rounded-full border border-[#005327]/15 bg-[#F4F9F6] px-3 py-1.5 text-xs font-semibold text-[#005327]"
                        data-ai-command="Products kholo">

                        <i class="fa-solid fa-leaf text-[10px]"></i>
                        Fresh Picks

                    </button>

                    <button type="button"
                        class="ai-quick-btn shrink-0 inline-flex items-center gap-1.5 rounded-full border border-[#005327]/15 bg-[#F4F9F6] px-3 py-1.5 text-xs font-semibold text-[#005327]"
                        data-ai-command="Cart kholo">

                        <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                        Cart

                    </button>

                    <button type="button"
                        class="ai-quick-btn shrink-0 inline-flex items-center gap-1.5 rounded-full border border-[#005327]/15 bg-[#F4F9F6] px-3 py-1.5 text-xs font-semibold text-[#005327]"
                        data-ai-command="Orders dikhao">

                        <i class="fa-solid fa-box text-[10px]"></i>
                        Orders

                    </button>

                </div>
            </div>

            <div id="aiMessages"
                class="h-[470px] overflow-y-auto px-4 py-5 space-y-4 bg-[#FAF8F5]">

                <div class="ai-message flex justify-start gap-2.5">

                    <div class="shrink-0 w-8 h-8 rounded-xl bg-[#005327] text-white flex items-center justify-center mt-1">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>

                    <div class="max-w-[84%]">

                        <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">

                            <p class="text-sm font-medium leading-6 text-gray-800">
                                👋 Assalamualaikum!
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Main <strong>MarketLink AI</strong> hoon.
                            </p>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Aap mujhse <strong>English</strong> ya
                                <strong>Roman Urdu</strong> mein baat kar sakte hain.
                            </p>

                            <div class="mt-4 rounded-xl bg-[#F4F9F6] border border-[#005327]/10 p-3">

                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#005327]">
                                    Try asking
                                </p>

                                <div class="mt-2 space-y-1.5 text-xs text-gray-600">

                                    <p>• "Market page kholo"</p>
                                    <p>• "Products kholo"</p>
                                    <p>• "Cart kholo"</p>
                                    <p>• "Checkout kholo"</p>
                                    <p>• "Orders dikhao"</p>
                                    <p>• "Tomato search karo"</p>
                                    <p>• "2 kg tomato cart mein add karo"</p>

                                </div>
                            </div>

                        </div>

                        <div class="mt-1.5 ml-1 text-[10px] font-medium text-gray-400">
                            Just now
                        </div>

                    </div>
                </div>
            </div>

            <div id="aiTyping"
                class="hidden bg-[#FAF8F5] px-4 pb-2">

                <div class="flex items-start gap-2.5">

                    <div class="w-8 h-8 shrink-0 rounded-xl bg-[#005327] text-white flex items-center justify-center">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>

                    <div class="inline-flex items-center gap-1 bg-white border border-gray-200 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">

                        <span class="ai-dot w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                        <span class="ai-dot w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                        <span class="ai-dot w-1.5 h-1.5 bg-gray-400 rounded-full"></span>

                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 bg-white p-3">

                <form id="aiChatForm"
                    class="flex items-end gap-2">

                    @csrf

                    <div class="relative flex-1">

                        <textarea id="aiMessageInput"
                            rows="1"
                            autocomplete="off"
                            placeholder="Type your message... / Apna message likhein..."
                            class="w-full rounded-2xl border border-gray-200 bg-[#FAF8F5] px-4 py-3 pr-10 text-sm leading-6 text-gray-800 placeholder:text-gray-400 focus:border-[#005327]/30 focus:outline-none focus:ring-4 focus:ring-[#005327]/10 transition">
                        </textarea>

                        <span class="absolute right-3 bottom-3 text-[10px] text-gray-400">
                            ↵
                        </span>

                    </div>

                    <button id="aiSendButton"
                        type="submit"
                        class="shrink-0 w-12 h-12 rounded-2xl bg-[#005327] text-white flex items-center justify-center shadow-md hover:bg-[#003d1c] hover:scale-[1.02] active:scale-95 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        aria-label="Send message">

                        <i class="fa-solid fa-paper-plane text-sm"></i>

                    </button>

                </form>

                <div class="mt-2 flex items-center justify-between px-1">

                    <p class="text-[10px] text-gray-400">
                        MarketLink AI can help with shopping.
                    </p>

                    <p class="text-[10px] text-gray-400">
                        Shift + Enter = new line
                    </p>

                </div>

            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        if (menuBtn && mobileMenu && menuIcon && closeIcon) {
            menuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        }
    </script>

    <script>
        function showCategoryProducts(categoryId) {
            document.querySelectorAll('.category-products').forEach(function(section) {
                section.classList.add('hidden');
            });

            document.querySelectorAll('.category-button').forEach(function(button) {
                button.classList.remove(
                    'border-[#005327]',
                    'bg-[#EAF3ED]',
                    'shadow-md'
                );
            });

            const selectedProducts = document.getElementById(
                'category-products-' + categoryId
            );

            if (selectedProducts) {
                selectedProducts.classList.remove('hidden');
            }

            const selectedButton = document.getElementById(
                'category-btn-' + categoryId
            );

            if (selectedButton) {
                selectedButton.classList.add(
                    'border-[#005327]',
                    'bg-[#EAF3ED]',
                    'shadow-md'
                );

                const categoryName = selectedButton.querySelector('h3').innerText;

                document.getElementById('selectedCategoryTitle').innerText = categoryName;
            }

            const productsSection = document.getElementById(
                'categoryProductsSection'
            );

            if (productsSection) {
                productsSection.classList.remove('hidden');

                setTimeout(function() {
                    productsSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }

            lucide.createIcons();
        }
    </script>

    @include('components.ai-chatbot')

</body>

</html>