<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Compare Basket · MarketLink</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">


    <style>

        :root {
            --background: #fdfbf7;
            --foreground: #22251e;
            --primary: #005327;
            --accent: #ca6232;
            --muted: #eae3d2;
            --border: #e6dfcf;
        }

        body {
            background: var(--background);
            color: var(--foreground);
            font-family: 'Work Sans', sans-serif;
        }

        .font-fraunces {
            font-family: 'Fraunces', serif;
        }

        .market-card {
            transition: .25s ease;
        }

        .market-card:hover {
            transform: translateY(-4px);
        }

        .cheapest-card {
            border-color: #005327 !important;
            box-shadow: 0 15px 40px rgba(0, 83, 39, .12);
        }

        .spinner {
            width: 22px;
            height: 22px;
            border: 3px solid #eae3d2;
            border-top-color: #005327;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

    </style>

</head>


<body>


<!-- ========================================================= -->
<!-- NAVBAR -->
<!-- ========================================================= -->

<header class="sticky top-0 z-50 border-b border-[#e6dfcf]/70 bg-[#fdfbf7]/90 backdrop-blur-xl">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between">


            <!-- LOGO -->

            <a href="{{ url('/') }}" class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#005327] flex items-center justify-center text-white">

                    <i data-lucide="leaf" class="w-5 h-5"></i>

                </div>

                <div>

                    <div class="font-fraunces text-xl font-bold text-[#005327]">
                        MarketLink
                    </div>

                    <div class="text-[10px] uppercase tracking-[0.2em] text-gray-500">
                        Fresh. Local. Simple.
                    </div>

                </div>

            </a>


            <!-- NAVIGATION -->

            <nav class="hidden lg:flex items-center gap-7 text-sm font-medium">

                <a href="{{ url('/markets') }}"
                    class="hover:text-[#005327] transition">
                    Markets
                </a>

                <a href="{{ url('/products') }}"
                    class="hover:text-[#005327] transition">
                    Fresh Picks
                </a>

                <a href="{{ route('compare-shopping.index') }}"
                    class="text-[#005327] font-semibold">
                    Compare Basket
                </a>

                @auth

                    <a href="{{ route('customer.orders') }}"
                        class="hover:text-[#005327] transition">
                        My Orders
                    </a>

                @endauth

            </nav>


            <!-- RIGHT -->

            <div class="flex items-center gap-3">

                <a href="{{ route('cart.index') }}"
                    class="relative w-11 h-11 rounded-xl border border-[#e6dfcf] flex items-center justify-center hover:bg-white transition">

                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>

                    @php
                        $cartCount = collect(session('cart', []))->sum('quantity');
                    @endphp

                    @if($cartCount > 0)

                        <span
                            class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-[#ca6232] text-white text-[10px] font-bold flex items-center justify-center">

                            {{ $cartCount }}

                        </span>

                    @endif

                </a>


                @auth

                    <a href="{{ url('/') }}"
                        class="hidden sm:flex w-11 h-11 rounded-xl bg-[#005327] text-white items-center justify-center">

                        <i data-lucide="user" class="w-5 h-5"></i>

                    </a>

                @endauth

            </div>

        </div>

    </div>

</header>


<!-- ========================================================= -->
<!-- MAIN -->
<!-- ========================================================= -->

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">


    <!-- HERO -->

    <div class="max-w-3xl mb-10">

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#eae3d2] text-[#005327] text-sm font-semibold mb-5">

            <i data-lucide="scale" class="w-4 h-4"></i>

            Smart Basket Comparison

        </div>


        <h1 class="font-fraunces text-4xl md:text-5xl font-bold leading-tight mb-4">

            Compare your entire basket

        </h1>


        <p class="text-gray-600 text-lg leading-relaxed">

            Select the products you need. We'll calculate the total cost
            of your complete basket in every available market.

        </p>

    </div>


    <!-- ===================================================== -->
    <!-- SELECT PRODUCTS -->
    <!-- ===================================================== -->

    <section class="bg-white rounded-3xl border border-[#e6dfcf] shadow-sm overflow-hidden">


        <div class="px-6 md:px-8 py-6 border-b border-[#e6dfcf]">

            <div class="flex items-center gap-3">

                <div class="w-9 h-9 rounded-full bg-[#005327] text-white flex items-center justify-center font-bold">
                    1
                </div>

                <div>

                    <h2 class="font-fraunces text-2xl font-bold">
                        Build your basket
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Choose a category first, then select a product.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6 md:p-8">


            <!-- CATEGORY + PRODUCT -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                <!-- CATEGORY -->

                <div>

                    <label class="block text-sm font-semibold mb-2">

                        1. Select Category

                    </label>


                    <select
                        id="categorySelect"
                        class="w-full h-14 rounded-2xl border border-[#e6dfcf] bg-[#fdfbf7] px-4 outline-none focus:border-[#005327]">

                        <option value="">
                            Choose a category...
                        </option>


                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- PRODUCT -->

                <div>

                    <label class="block text-sm font-semibold mb-2">

                        2. Select Product

                    </label>


                    <select
                        id="productSelect"
                        disabled
                        class="w-full h-14 rounded-2xl border border-[#e6dfcf] bg-[#fdfbf7] px-4 outline-none disabled:opacity-50 focus:border-[#005327]">

                        <option value="">
                            First select a category...
                        </option>

                    </select>

                </div>

            </div>


            <!-- PRODUCT DETAILS -->

            <div
                id="productDetails"
                class="hidden mt-5 p-5 rounded-2xl bg-[#fdfbf7] border border-[#e6dfcf]">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">


                    <div>

                        <div
                            id="productName"
                            class="font-fraunces text-xl font-bold">
                        </div>

                        <div
                            id="productPrice"
                            class="text-sm text-gray-500 mt-1">
                        </div>

                    </div>


                    <div class="flex items-center gap-3">


                        <div class="flex items-center border border-[#e6dfcf] bg-white rounded-xl overflow-hidden">

                            <button
                                type="button"
                                id="qtyMinus"
                                class="w-11 h-11 hover:bg-[#fdfbf7] text-lg">

                                −

                            </button>


                            <input
                                type="number"
                                id="quantityInput"
                                min="1"
                                value="1"
                                class="w-16 h-11 text-center outline-none border-x border-[#e6dfcf]">


                            <button
                                type="button"
                                id="qtyPlus"
                                class="w-11 h-11 hover:bg-[#fdfbf7] text-lg">

                                +

                            </button>

                        </div>


                        <button
                            type="button"
                            id="addProductBtn"
                            class="h-11 px-5 rounded-xl bg-[#005327] text-white font-semibold hover:bg-[#003d1c] transition flex items-center gap-2">

                            <i data-lucide="plus" class="w-4 h-4"></i>

                            Add Product

                        </button>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- SELECTED PRODUCTS -->
            <!-- ================================================= -->

            <div class="mt-10">


                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h3 class="font-fraunces text-xl font-bold">
                            Your selected basket
                        </h3>

                        <p class="text-sm text-gray-500">
                            Add different products from any category.
                        </p>

                    </div>


                    <span
                        id="selectedCount"
                        class="px-4 py-2 rounded-full bg-[#eae3d2] text-[#005327] text-sm font-semibold">

                        0 items

                    </span>

                </div>


                <div
                    id="selectedProducts"
                    class="space-y-3">


                    <!-- EMPTY -->

                    <div
                        id="emptyBasket"
                        class="border-2 border-dashed border-[#e6dfcf] rounded-2xl p-10 text-center">

                        <i
                            data-lucide="shopping-basket"
                            class="w-10 h-10 mx-auto text-gray-300 mb-3">
                        </i>

                        <p class="font-semibold text-gray-500">
                            Your basket is empty
                        </p>

                        <p class="text-sm text-gray-400 mt-1">
                            Select products above to build your basket.
                        </p>

                    </div>

                </div>


                <!-- COMPARE BUTTON -->

                <div class="mt-7 flex justify-end">

                    <button
                        type="button"
                        id="compareBtn"
                        disabled
                        class="px-7 py-4 rounded-2xl bg-[#005327] text-white font-semibold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-[#003d1c] transition flex items-center gap-3">

                        <i data-lucide="scale" class="w-5 h-5"></i>

                        Compare All Markets

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- LOADING -->
    <!-- ===================================================== -->

    <div
        id="loadingBox"
        class="hidden mt-10 bg-white border border-[#e6dfcf] rounded-3xl p-10 text-center">

        <div class="spinner mx-auto mb-4"></div>

        <h3 class="font-fraunces text-xl font-bold">
            Comparing your basket...
        </h3>

        <p class="text-gray-500 mt-2">
            Checking prices across all markets.
        </p>

    </div>


    <!-- ===================================================== -->
    <!-- RESULTS -->
    <!-- ===================================================== -->

    <section
        id="resultsSection"
        class="hidden mt-10">


        <div class="mb-7">

            <div class="flex items-center gap-3 mb-2">

                <div class="w-9 h-9 rounded-full bg-[#005327] text-white flex items-center justify-center font-bold">
                    2
                </div>

                <h2 class="font-fraunces text-3xl font-bold">
                    Compare Market Totals
                </h2>

            </div>

            <p class="text-gray-500 ml-12">
                Same products. Same quantities. Different market prices.
            </p>

        </div>


        <!-- MARKET RESULTS -->

        <div
            id="marketResults"
            class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        </div>

    </section>


    <!-- ERROR -->

    <div
        id="errorBox"
        class="hidden mt-8 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5">

        <div class="flex gap-3">

            <i data-lucide="alert-circle" class="w-5 h-5"></i>

            <div id="errorMessage"></div>

        </div>

    </div>


</main>


<script>

    lucide.createIcons();


    const productsUrl =
        "{{ route('compare-shopping.products') }}";

    const compareUrl =
        "{{ route('compare-shopping.compare') }}";

    const selectMarketUrl =
        "{{ route('compare-shopping.select-market') }}";


    const csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).getAttribute('content');


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    let selectedProducts = {};

    let currentProducts = [];

    let currentProduct = null;


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const categorySelect =
        document.getElementById('categorySelect');

    const productSelect =
        document.getElementById('productSelect');

    const productDetails =
        document.getElementById('productDetails');

    const quantityInput =
        document.getElementById('quantityInput');

    const addProductBtn =
        document.getElementById('addProductBtn');

    const selectedProductsBox =
        document.getElementById('selectedProducts');

    const selectedCount =
        document.getElementById('selectedCount');

    const compareBtn =
        document.getElementById('compareBtn');



    /*
    |--------------------------------------------------------------------------
    | Category Changed
    |--------------------------------------------------------------------------
    */

    categorySelect.addEventListener(
        'change',
        async function () {

            const categoryId =
                this.value;


            currentProduct = null;

            productDetails.classList.add(
                'hidden'
            );


            productSelect.innerHTML = `
                <option value="">
                    Loading products...
                </option>
            `;


            productSelect.disabled = true;


            if (!categoryId) {

                productSelect.innerHTML = `
                    <option value="">
                        First select a category...
                    </option>
                `;

                return;
            }


            try {

                const response =
                    await fetch(
                        productsUrl,
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body:
                                JSON.stringify({
                                    category_id:
                                        categoryId
                                })

                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    productSelect.innerHTML = `
                        <option value="">
                            Unable to load products
                        </option>
                    `;

                    return;
                }


                currentProducts =
                    data.products;


                productSelect.innerHTML = `
                    <option value="">
                        Choose a product...
                    </option>
                `;


                if (
                    currentProducts.length === 0
                ) {

                    productSelect.innerHTML = `
                        <option value="">
                            No products available
                        </option>
                    `;

                    return;
                }


                currentProducts.forEach(
                    function (product) {

                        /*
                        |--------------------------------------------------------------------------
                        | Don't show already selected products
                        |--------------------------------------------------------------------------
                        */

                        if (
                            selectedProducts[
                                product.id
                            ]
                        ) {
                            return;
                        }


                        const option =
                            document.createElement(
                                'option'
                            );


                        option.value =
                            product.id;


                        option.textContent =
                            `${product.name} — Rs. ${Number(product.price).toLocaleString()} / ${product.unit}`;


                        productSelect.appendChild(
                            option
                        );

                    }
                );


                productSelect.disabled =
                    false;


            } catch (error) {

                console.error(error);

                productSelect.innerHTML = `
                    <option value="">
                        Error loading products
                    </option>
                `;

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Product Selected
    |--------------------------------------------------------------------------
    */

    productSelect.addEventListener(
        'change',
        function () {

            const productId =
                parseInt(this.value);


            if (!productId) {

                productDetails.classList.add(
                    'hidden'
                );

                currentProduct = null;

                return;
            }


            currentProduct =
                currentProducts.find(
                    product =>
                        product.id === productId
                );


            if (!currentProduct) {
                return;
            }


            document.getElementById(
                'productName'
            ).textContent =
                currentProduct.name;


            document.getElementById(
                'productPrice'
            ).textContent =
                `Rs. ${Number(currentProduct.price).toLocaleString()} / ${currentProduct.unit} • Stock: ${currentProduct.stock_quantity} ${currentProduct.unit}`;


            quantityInput.value = 1;

            quantityInput.max =
                currentProduct.stock_quantity;


            productDetails.classList.remove(
                'hidden'
            );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Quantity Minus
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'qtyMinus'
    ).addEventListener(
        'click',
        function () {

            let value =
                parseInt(
                    quantityInput.value
                ) || 1;


            if (value > 1) {

                quantityInput.value =
                    value - 1;

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Quantity Plus
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'qtyPlus'
    ).addEventListener(
        'click',
        function () {

            if (!currentProduct) {
                return;
            }


            let value =
                parseInt(
                    quantityInput.value
                ) || 1;


            const max =
                currentProduct.stock_quantity;


            if (value < max) {

                quantityInput.value =
                    value + 1;

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Add Product
    |--------------------------------------------------------------------------
    */

    addProductBtn.addEventListener(
        'click',
        function () {

            if (!currentProduct) {

                showError(
                    'Please select a product first.'
                );

                return;
            }


            const productId =
                currentProduct.id;


            /*
            |--------------------------------------------------------------------------
            | Duplicate Protection
            |--------------------------------------------------------------------------
            */

            if (
                selectedProducts[
                    productId
                ]
            ) {

                showError(
                    currentProduct.name +
                    ' is already in your basket.'
                );

                return;
            }


            let quantity =
                parseInt(
                    quantityInput.value
                ) || 1;


            if (
                quantity < 1
            ) {

                quantity = 1;

            }


            if (
                quantity >
                currentProduct.stock_quantity
            ) {

                showError(
                    'Only ' +
                    currentProduct.stock_quantity +
                    ' ' +
                    currentProduct.unit +
                    ' available.'
                );

                return;
            }


            selectedProducts[
                productId
            ] = {

                product_id:
                    currentProduct.id,

                name:
                    currentProduct.name,

                quantity:
                    quantity,

                unit:
                    currentProduct.unit,

                price:
                    currentProduct.price,

                image:
                    currentProduct.image

            };


            /*
            |--------------------------------------------------------------------------
            | Reset Product
            |--------------------------------------------------------------------------
            */

            productDetails.classList.add(
                'hidden'
            );

            currentProduct = null;

            quantityInput.value = 1;

            productSelect.value = '';


            /*
            |--------------------------------------------------------------------------
            | Remove selected product from dropdown
            |--------------------------------------------------------------------------
            */

            const option =
                productSelect.querySelector(
                    `option[value="${productId}"]`
                );


            if (option) {

                option.remove();

            }


            renderSelectedProducts();

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Render Selected Products
    |--------------------------------------------------------------------------
    */

    function renderSelectedProducts() {

        const products =
            Object.values(
                selectedProducts
            );


        selectedCount.textContent =
            products.length +
            (
                products.length === 1
                    ? ' item'
                    : ' items'
            );


        compareBtn.disabled =
            products.length === 0;


        if (products.length === 0) {

            selectedProductsBox.innerHTML = `

                <div
                    id="emptyBasket"
                    class="border-2 border-dashed border-[#e6dfcf] rounded-2xl p-10 text-center">

                    <i
                        data-lucide="shopping-basket"
                        class="w-10 h-10 mx-auto text-gray-300 mb-3">
                    </i>

                    <p class="font-semibold text-gray-500">
                        Your basket is empty
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        Select products above to build your basket.
                    </p>

                </div>

            `;

            lucide.createIcons();

            return;
        }


        selectedProductsBox.innerHTML = '';


        products.forEach(
            function (product) {

                const div =
                    document.createElement(
                        'div'
                    );


                div.className =
                    'bg-[#fdfbf7] border border-[#e6dfcf] rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4';


                div.innerHTML = `

                    <div class="flex items-center gap-4">

                        <div
                            class="w-12 h-12 rounded-xl bg-white border border-[#e6dfcf] flex items-center justify-center">

                            <i
                                data-lucide="package"
                                class="w-5 h-5 text-[#005327]">
                            </i>

                        </div>

                        <div>

                            <div class="font-semibold">
                                ${escapeHtml(product.name)}
                            </div>

                            <div class="text-sm text-gray-500">
                                ${product.quantity} ${escapeHtml(product.unit)}
                            </div>

                        </div>

                    </div>


                    <div class="flex items-center gap-3">


                        <div class="flex items-center border border-[#e6dfcf] bg-white rounded-xl overflow-hidden">

                            <button
                                type="button"
                                onclick="changeSelectedQuantity(${product.product_id}, -1)"
                                class="w-9 h-9 hover:bg-gray-50">

                                −

                            </button>


                            <span class="w-12 text-center text-sm font-semibold">

                                ${product.quantity}

                            </span>


                            <button
                                type="button"
                                onclick="changeSelectedQuantity(${product.product_id}, 1)"
                                class="w-9 h-9 hover:bg-gray-50">

                                +

                            </button>

                        </div>


                        <button
                            type="button"
                            onclick="removeSelectedProduct(${product.product_id})"
                            class="w-10 h-10 rounded-xl text-red-500 hover:bg-red-50 flex items-center justify-center">

                            <i data-lucide="trash-2" class="w-4 h-4"></i>

                        </button>

                    </div>

                `;


                selectedProductsBox.appendChild(
                    div
                );

            }
        );


        lucide.createIcons();

    }



    /*
    |--------------------------------------------------------------------------
    | Change Selected Quantity
    |--------------------------------------------------------------------------
    */

    function changeSelectedQuantity(
        productId,
        change
    ) {

        const product =
            selectedProducts[
                productId
            ];


        if (!product) {
            return;
        }


        let quantity =
            product.quantity +
            change;


        if (quantity < 1) {

            quantity = 1;

        }


        /*
        |--------------------------------------------------------------------------
        | Find stock from current category products
        |--------------------------------------------------------------------------
        */

        const current =
            currentProducts.find(
                p =>
                    p.id ===
                    parseInt(productId)
            );


        if (
            current &&
            quantity >
            current.stock_quantity
        ) {

            showError(
                'Maximum available stock is ' +
                current.stock_quantity +
                ' ' +
                current.unit
            );

            return;
        }


        product.quantity =
            quantity;


        renderSelectedProducts();

    }



    /*
    |--------------------------------------------------------------------------
    | Remove Selected Product
    |--------------------------------------------------------------------------
    */

    function removeSelectedProduct(
        productId
    ) {

        delete selectedProducts[
            productId
        ];


        renderSelectedProducts();


        /*
        |--------------------------------------------------------------------------
        | Refresh current category dropdown
        |--------------------------------------------------------------------------
        */

        categorySelect.dispatchEvent(
            new Event('change')
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Compare Markets
    |--------------------------------------------------------------------------
    */

    compareBtn.addEventListener(
        'click',
        async function () {

            const products =
                Object.values(
                    selectedProducts
                );


            if (!products.length) {

                showError(
                    'Please add at least one product.'
                );

                return;
            }


            hideError();


            document.getElementById(
                'resultsSection'
            ).classList.add('hidden');


            document.getElementById(
                'loadingBox'
            ).classList.remove('hidden');


            try {

                const response =
                    await fetch(
                        compareUrl,
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body:
                                JSON.stringify({

                                    items:
                                        products.map(
                                            product => ({

                                                product_id:
                                                    product.product_id,

                                                quantity:
                                                    product.quantity

                                            })
                                        )

                                })

                        }
                    );


                const data =
                    await response.json();


                document.getElementById(
                    'loadingBox'
                ).classList.add('hidden');


                if (
                    !response.ok ||
                    !data.success
                ) {

                    showError(
                        data.message ||
                        'Unable to compare markets.'
                    );

                    return;
                }


                renderMarketResults(
                    data
                );


            } catch (error) {

                console.error(error);


                document.getElementById(
                    'loadingBox'
                ).classList.add('hidden');


                showError(
                    'Something went wrong while comparing markets.'
                );

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Render Market Results
    |--------------------------------------------------------------------------
    */

    function renderMarketResults(
        data
    ) {

        const resultsSection =
            document.getElementById(
                'resultsSection'
            );


        const marketResults =
            document.getElementById(
                'marketResults'
            );


        marketResults.innerHTML = '';


        data.markets.forEach(
            function (
                market,
                index
            ) {


                const cheapest =
                    index === 0;


                const itemHtml =
                    market.items.map(
                        function (item) {

                            return `

                                <div class="flex items-center justify-between py-3 border-b border-[#e6dfcf] last:border-0">

                                    <div>

                                        <div class="font-medium">
                                            ${escapeHtml(item.name)}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            ${item.quantity}
                                            ${escapeHtml(item.unit)}
                                            ×
                                            Rs. ${Number(item.price).toLocaleString()}
                                        </div>

                                    </div>


                                    <div class="font-semibold">

                                        Rs. ${Number(item.subtotal).toLocaleString()}

                                    </div>

                                </div>

                            `;

                        }
                    ).join('');


                marketResults.innerHTML += `

                    <div
                        class="market-card bg-white rounded-3xl border-2 ${
                            cheapest
                            ? 'cheapest-card'
                            : 'border-[#e6dfcf]'
                        } p-6">


                        <!-- MARKET HEADER -->

                        <div class="flex items-start justify-between gap-4 mb-6">

                            <div>

                                <div class="flex flex-wrap items-center gap-2">

                                    <h3 class="font-fraunces text-2xl font-bold">

                                        ${escapeHtml(
                                            market.market_name
                                        )}

                                    </h3>


                                    ${
                                        cheapest
                                        ? `
                                            <span class="px-3 py-1 rounded-full bg-[#005327] text-white text-xs font-bold">
                                                CHEAPEST
                                            </span>
                                          `
                                        : ''
                                    }

                                </div>


                                <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">

                                    <i
                                        data-lucide="map-pin"
                                        class="w-4 h-4">
                                    </i>

                                    ${escapeHtml(
                                        market.market_location ||
                                        'Location not available'
                                    )}

                                </div>

                            </div>


                            <div
                                class="w-12 h-12 rounded-2xl bg-[#fdfbf7] flex items-center justify-center">

                                <i
                                    data-lucide="store"
                                    class="w-6 h-6 text-[#005327]">
                                </i>

                            </div>

                        </div>


                        <!-- TOTAL -->

                        <div
                            class="bg-[#fdfbf7] rounded-2xl p-5 mb-5">

                            <div class="text-sm text-gray-500">
                                Complete basket total
                            </div>


                            <div
                                class="font-fraunces text-4xl font-bold text-[#005327] mt-1">

                                Rs. ${Number(
                                    market.total
                                ).toLocaleString()}

                            </div>


                            ${
                                cheapest
                                ? `
                                    <div class="text-sm text-[#005327] font-semibold mt-2">
                                        ✓ Lowest total for your basket
                                    </div>
                                  `
                                : `
                                    <div class="text-sm text-[#ca6232] font-semibold mt-2">
                                        Rs. ${Number(
                                            market.saving
                                        ).toLocaleString()}
                                        more than cheapest
                                    </div>
                                  `
                            }

                        </div>


                        <!-- PRODUCTS -->

                        <div>

                            ${itemHtml}

                        </div>


                        <!-- SELECT -->

                        <button
                            type="button"
                            onclick="selectMarket(${market.market_id})"
                            class="w-full mt-6 py-4 rounded-2xl bg-[#005327] text-white font-semibold hover:bg-[#003d1c] transition flex items-center justify-center gap-2">

                            <i
                                data-lucide="shopping-cart"
                                class="w-5 h-5">
                            </i>

                            Select Market & Add to Cart

                        </button>


                    </div>

                `;

            }
        );


        resultsSection.classList.remove(
            'hidden'
        );


        lucide.createIcons();


        setTimeout(
            function () {

                resultsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            },
            100
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Select Market
    |--------------------------------------------------------------------------
    */

    async function selectMarket(
        marketId
    ) {

        const products =
            Object.values(
                selectedProducts
            );


        if (!products.length) {

            showError(
                'Your basket is empty.'
            );

            return;
        }


        const buttons =
            document.querySelectorAll(
                '#marketResults button'
            );


        buttons.forEach(
            button => {
                button.disabled = true;
                button.style.opacity = '.6';
            }
        );


        try {

            const response =
                await fetch(
                    selectMarketUrl,
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken

                        },

                        body:
                            JSON.stringify({

                                market_id:
                                    marketId,

                                items:
                                    products.map(
                                        product => ({

                                            product_id:
                                                product.product_id,

                                            quantity:
                                                product.quantity

                                        })
                                    )

                            })

                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                showError(
                    data.message ||
                    'Unable to add basket to cart.'
                );

                buttons.forEach(
                    button => {

                        button.disabled =
                            false;

                        button.style.opacity =
                            '1';

                    }
                );

                return;
            }


            window.location.href =
                data.redirect;


        } catch (error) {

            console.error(error);


            showError(
                'Something went wrong while adding your basket to cart.'
            );


            buttons.forEach(
                button => {

                    button.disabled =
                        false;

                    button.style.opacity =
                        '1';

                }
            );

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Error
    |--------------------------------------------------------------------------
    */

    function showError(
        message
    ) {

        const box =
            document.getElementById(
                'errorBox'
            );


        document.getElementById(
            'errorMessage'
        ).textContent =
            message;


        box.classList.remove(
            'hidden'
        );


        box.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

    }


    function hideError() {

        document.getElementById(
            'errorBox'
        ).classList.add(
            'hidden'
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(
        value
    ) {

        return String(value)

            .replaceAll(
                '&',
                '&amp;'
            )

            .replaceAll(
                '<',
                '&lt;'
            )

            .replaceAll(
                '>',
                '&gt;'
            )

            .replaceAll(
                '"',
                '&quot;'
            )

            .replaceAll(
                "'",
                '&#039;'
            );

    }

</script>


</body>

</html>