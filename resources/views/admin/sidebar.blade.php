<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin · Dashboard — MarketLink</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
                Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;

            background-color: #FAF8F5;
            color: #1C2826;
        }
    </style>
</head>


<body class="antialiased">

    <div class="min-h-screen flex">


        <!-- ========================================================= -->
        <!-- SIDEBAR -->
        <!-- ========================================================= -->

        <aside
            class="w-64 bg-white border-r border-[#E5DFD5]
                   flex-shrink-0 flex flex-col justify-between
                   hidden md:flex sticky top-0 h-screen">


            <!-- ===================================================== -->
            <!-- SIDEBAR TOP -->
            <!-- ===================================================== -->

            <div>


                <!-- ================================================= -->
                <!-- BRAND LOGO -->
                <!-- ================================================= -->

                <div class="p-6 border-b border-[#E5DFD5]">

                    <a href="/"
                        class="flex items-center gap-2.5
                               text-[#005327] font-bold text-2xl
                               tracking-tight">

                        <span
                            class="bg-[#005327] text-white p-2
                                   rounded-xl flex items-center
                                   justify-center">

                            <i class="fa-solid fa-leaf text-base"></i>

                        </span>


                        <span class="font-serif">
                            MarketLink
                        </span>

                    </a>

                </div>



                <!-- ================================================= -->
                <!-- NAVIGATION -->
                <!-- ================================================= -->

                <nav class="p-4 space-y-2">


                    <!-- ================================================= -->
                    <!-- OVERVIEW -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.dashboard')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-chart-pie w-5"></i>

                        <span>
                            Overview
                        </span>

                    </a>



                    <!-- ================================================= -->
                    <!-- USERS -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-4 py-2.5
                               rounded-lg text-sm font-medium
                               transition

                               {{ request()->routeIs('admin.users')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#005327]/10
                                       hover:text-[#005327]' }}">

                        <i class="fa-solid fa-users w-5 text-center"></i>

                        <span>
                            Users
                        </span>

                    </a>



                    <!-- ================================================= -->
                    <!-- FARMERS -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.farmers') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.farmers')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-tractor w-5"></i>

                        <span>
                            Farmers
                        </span>

                    </a>
                    <!-- Products -->
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.products.index')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-box-open w-5"></i>

                        <span>
                            Products
                        </span>

                    </a>
                    <!-- producs request -->
                    <a href="{{ route('admin.products.requests') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.products.requests')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-clock w-5"></i>

                        <span>
                            Product Requests
                        </span>

                    </a>
                    <!-- MARKETS -->
                    <a href="{{ route('admin.markets') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.markets')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-store w-5"></i>

                        <span>
                            Markets
                        </span>

                    </a>
                    <!-- CATEGORIES -->
                    <a href="{{ route('admin.categories') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.categories')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-layer-group w-5"></i>

                        <span>
                            Categories
                        </span>

                    </a>



                    <!-- ================================================= -->
                    <!-- PICKUPS -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.pickup') }}"
                        class="flex items-center gap-3 px-4 py-3
                               rounded-xl font-medium text-sm
                               transition border border-transparent

                               {{ request()->routeIs('admin.pickup')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#FAF8F5]
                                       hover:text-[#005327]
                                       hover:border-[#E5DFD5]' }}">

                        <i class="fa-solid fa-box w-5"></i>

                        <span>
                            Pickups
                        </span>

                    </a>



                    <!-- ================================================= -->
                    <!-- HISTORY -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.history') }}"
                        class="flex items-center gap-3 px-4 py-2.5
                               rounded-lg text-sm font-medium
                               transition

                               {{ request()->routeIs('admin.history*')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#005327]/10
                                       hover:text-[#005327]' }}">

                        <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>

                        <span>
                            History
                        </span>

                    </a>



                   





                    <!-- ================================================= -->
                    <!-- REVIEWS -->
                    <!-- ================================================= -->

                    <a href="{{ route('admin.reviews') }}"
                        class="flex items-center gap-3 px-4 py-2.5
                               rounded-lg text-sm font-medium
                               transition

                               {{ request()->routeIs('admin.reviews')
                                    ? 'bg-[#005327] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-[#005327]/10
                                       hover:text-[#005327]' }}">

                        <i class="fa-solid fa-star w-5 text-center"></i>

                        <span>
                            Reviews
                        </span>

                    </a>


                </nav>

            </div>



            <!-- ========================================================= -->
            <!-- BOTTOM ADMIN AREA -->
            <!-- ========================================================= -->

            <div class="p-4 border-t border-[#E5DFD5]">


                <!-- ADMIN INFO -->

                <div class="flex items-center justify-between mb-3 px-2">

                    <div class="flex items-center gap-2">

                        <div
                            class="w-8 h-8 rounded-full
                                   bg-[#005327]/10
                                   text-[#005327]
                                   font-bold
                                   flex items-center
                                   justify-center text-xs">

                            A

                        </div>


                        <span class="text-sm font-semibold text-gray-700">
                            admin
                        </span>

                    </div>


                    <span
                        class="w-2 h-2 rounded-full bg-emerald-500">
                    </span>

                </div>



                <!-- LOGOUT -->

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="w-full flex items-center gap-3
                               px-4 py-2.5 rounded-xl
                               text-red-600
                               hover:bg-red-50
                               font-medium text-sm
                               transition">

                        <i class="fa-solid fa-right-from-bracket w-5"></i>

                        Logout

                    </button>

                </form>

            </div>

        </aside>



        <!-- ========================================================= -->
        <!-- MAIN CONTENT -->
        <!-- ========================================================= -->

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">


            <!-- ===================================================== -->
            <!-- TOP BAR -->
            <!-- ===================================================== -->

            <header
                class="bg-white border-b border-[#E5DFD5]
                       py-4 px-6 sm:px-8
                       flex items-center justify-between
                       sticky top-0 z-10">


                <div>

                    <h1
                        class="text-2xl font-serif font-bold text-[#005327]">

                        Admin Dashboard

                    </h1>


                    <p class="text-xs text-gray-500 mt-0.5">

                        Platform metrics, order flow, and catalog operations.

                    </p>

                </div>



                <!-- LIVE STATUS -->

                <div class="flex items-center gap-3">

                    <span
                        class="inline-flex items-center gap-2
                               bg-[#FAF8F5]
                               border border-[#E5DFD5]
                               px-3.5 py-1.5
                               rounded-full
                               text-xs font-semibold
                               text-[#005327]">

                        <span
                            class="w-2 h-2 rounded-full
                                   bg-emerald-500
                                   animate-pulse">
                        </span>

                        Live Overview

                    </span>

                </div>

            </header>



            <!-- ===================================================== -->
            <!-- PAGE CONTENT -->
            <!-- ===================================================== -->

            @yield('content')


        </div>

    </div>



    <!-- ============================================================= -->
    <!-- CATEGORY MODAL -->
    <!-- ============================================================= -->

    <div
        id="categoryModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm
               hidden items-center justify-center
               z-50 p-4">


        <div
            class="bg-white rounded-xl
                   max-w-md w-full p-6
                   shadow-xl relative">


            <!-- MODAL HEADER -->

            <div class="flex items-center justify-between mb-4">

                <h3
                    id="categoryModalTitle"
                    class="text-lg font-bold text-gray-900">

                    Add Category

                </h3>


                <button
                    type="button"
                    onclick="closeCategoryModal()"
                    class="text-gray-400 hover:text-gray-600">

                    <i class="fa-solid fa-xmark text-lg"></i>

                </button>

            </div>



            <!-- CATEGORY FORM -->

            <form
                action="{{ route('admin.categories.save') }}"
                method="POST">

                @csrf


                <input
                    type="hidden"
                    name="id"
                    id="categoryIdInput">


                <div class="space-y-4">


                    <div>

                        <label
                            class="block text-sm font-medium
                                   text-gray-700 mb-1">

                            Category Name

                        </label>


                        <input
                            type="text"
                            name="name"
                            id="categoryNameInput"
                            required
                            placeholder="e.g. Fresh Vegetables"
                            class="w-full px-3 py-2
                                   border border-gray-300
                                   rounded-lg
                                   focus:ring-2
                                   focus:ring-emerald-500
                                   focus:outline-none
                                   text-sm">

                    </div>

                </div>



                <!-- BUTTONS -->

                <div class="flex justify-end gap-3 mt-6">


                    <button
                        type="button"
                        onclick="closeCategoryModal()"
                        class="px-4 py-2
                               border border-gray-300
                               rounded-lg
                               text-sm text-gray-600
                               hover:bg-gray-50
                               font-medium">

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="px-4 py-2
                               bg-emerald-700
                               text-white
                               rounded-lg
                               text-sm font-medium
                               hover:bg-emerald-800
                               transition">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>



    <!-- ============================================================= -->
    <!-- MARKET MODAL -->
    <!-- ============================================================= -->

    <div
        id="marketModal"
        class="fixed inset-0
               bg-black/50 backdrop-blur-sm
               hidden items-center justify-center
               z-50 p-4">


        <div
            class="bg-white rounded-2xl
                   max-w-lg w-full
                   max-h-[90vh]
                   shadow-2xl relative
                   overflow-hidden
                   flex flex-col">


            <!-- MARKET MODAL HEADER -->

            <div
                class="px-6 py-5
                       border-b border-[#E5DFD5]
                       flex items-center
                       justify-between">


                <div>

                    <h3
                        id="marketModalTitle"
                        class="text-xl font-bold text-[#1C2826]">

                        Add Market

                    </h3>


                    <p class="text-xs text-gray-500 mt-1">

                        Add market location and operating details

                    </p>

                </div>


                <button
                    type="button"
                    onclick="closeMarketModal()"
                    class="w-9 h-9 rounded-lg
                           bg-gray-50 text-gray-500
                           hover:bg-red-50
                           hover:text-red-500
                           transition">

                    <i class="fa-solid fa-xmark"></i>

                </button>

            </div>



            <!-- MARKET FORM -->

            <form
                id="marketForm"
                action="{{ route('admin.markets.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex flex-col min-h-0">

                @csrf


                <input
                    type="hidden"
                    name="id"
                    id="marketIdInput">


                <input
                    type="hidden"
                    name="_method"
                    id="marketMethodInput"
                    value="POST">



                <div
                    class="p-5 space-y-4
                           overflow-y-auto">


                    <!-- MARKET NAME -->

                    <div>

                        <label
                            class="block text-sm
                                   font-semibold
                                   text-[#1C2826]
                                   mb-2">

                            Market Name

                        </label>


                        <div class="relative">

                            <i
                                class="fa-solid fa-store
                                       absolute left-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-[#005327]
                                       text-sm">
                            </i>


                            <input
                                type="text"
                                name="name"
                                id="marketNameInput"
                                required
                                placeholder="e.g. Sabzi Mandi Karachi"
                                class="w-full pl-10 pr-4 py-3
                                       border border-[#E5DFD5]
                                       rounded-xl
                                       bg-[#FAF8F5]
                                       text-sm
                                       focus:ring-2
                                       focus:ring-[#005327]/20
                                       focus:border-[#005327]
                                       focus:outline-none">

                        </div>

                    </div>



                    <!-- LOCATION -->

                    <div>

                        <label
                            class="block text-sm
                                   font-semibold
                                   text-[#1C2826]
                                   mb-2">

                            Location

                        </label>


                        <div class="relative">

                            <i
                                class="fa-solid fa-location-dot
                                       absolute left-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-[#005327]
                                       text-sm">
                            </i>


                            <input
                                type="text"
                                name="location"
                                id="marketLocationInput"
                                required
                                placeholder="e.g. Super Highway, Karachi"
                                class="w-full pl-10 pr-4 py-3
                                       border border-[#E5DFD5]
                                       rounded-xl
                                       bg-[#FAF8F5]
                                       text-sm
                                       focus:ring-2
                                       focus:ring-[#005327]/20
                                       focus:border-[#005327]
                                       focus:outline-none">

                        </div>

                    </div>



                    <!-- DAYS -->

                    <div>

                        <label
                            class="block text-sm
                                   font-semibold
                                   text-[#1C2826]
                                   mb-2">

                            Days

                        </label>


                        <div class="relative">

                            <i
                                class="fa-regular fa-calendar
                                       absolute left-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-[#005327]
                                       text-sm">
                            </i>


                            <input
                                type="text"
                                name="days"
                                id="marketDaysInput"
                                required
                                placeholder="e.g. Monday - Sunday"
                                class="w-full pl-10 pr-4 py-3
                                       border border-[#E5DFD5]
                                       rounded-xl
                                       bg-[#FAF8F5]
                                       text-sm
                                       focus:ring-2
                                       focus:ring-[#005327]/20
                                       focus:border-[#005327]
                                       focus:outline-none">

                        </div>

                    </div>



                    <!-- TIMING -->

                    <div>

                        <label
                            class="block text-sm
                                   font-semibold
                                   text-[#1C2826]
                                   mb-2">

                            Timing

                        </label>


                        <div class="relative">

                            <i
                                class="fa-regular fa-clock
                                       absolute left-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-[#005327]
                                       text-sm">
                            </i>


                            <input
                                type="text"
                                name="timing"
                                id="marketTimingInput"
                                required
                                placeholder="e.g. 06:00 AM - 08:00 PM"
                                class="w-full pl-10 pr-4 py-3
                                       border border-[#E5DFD5]
                                       rounded-xl
                                       bg-[#FAF8F5]
                                       text-sm
                                       focus:ring-2
                                       focus:ring-[#005327]/20
                                       focus:border-[#005327]
                                       focus:outline-none">

                        </div>

                    </div>



                    <!-- MARKET IMAGE -->

                    <div>

                        <label
                            class="block text-sm
                                   font-semibold
                                   text-[#1C2826]
                                   mb-2">

                            Market Image

                        </label>


                        <label
                            for="marketImageInput"
                            class="flex flex-col
                                   items-center
                                   justify-center
                                   w-full h-32
                                   border-2
                                   border-dashed
                                   border-[#D9D3C8]
                                   rounded-xl
                                   bg-[#FAF8F5]
                                   hover:bg-[#F3F0EA]
                                   hover:border-[#005327]
                                   cursor-pointer
                                   transition">


                            <i
                                class="fa-solid
                                       fa-cloud-arrow-up
                                       text-2xl
                                       text-[#005327]
                                       mb-2">
                            </i>


                            <span
                                class="text-sm
                                       font-medium
                                       text-gray-600">

                                Click to upload market image

                            </span>


                            <span
                                class="text-[11px]
                                       text-gray-400 mt-1">

                                JPG, PNG or WEBP · Max 2MB

                            </span>

                        </label>


                        <input
                            type="file"
                            name="image"
                            id="marketImageInput"
                            accept="image/jpeg,image/png,image/webp"
                            class="hidden"
                            onchange="previewMarketImage(this)">



                        <!-- IMAGE PREVIEW -->

                        <div
                            id="imagePreviewContainer"
                            class="hidden mt-3">

                            <img
                                id="imagePreview"
                                src=""
                                class="w-full h-28
                                       object-cover
                                       rounded-xl
                                       border border-[#E5DFD5]">

                        </div>

                    </div>

                </div>



                <!-- MARKET FOOTER -->

                <div
                    class="px-6 py-4
                           bg-[#FAF8F5]
                           border-t border-[#E5DFD5]
                           flex justify-end gap-3">


                    <button
                        type="button"
                        onclick="closeMarketModal()"
                        class="px-5 py-2.5
                               border border-[#E5DFD5]
                               rounded-xl
                               text-sm text-gray-600
                               hover:bg-white
                               font-medium
                               transition">

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="px-5 py-2.5
                               bg-[#005327]
                               hover:bg-[#003D1D]
                               text-white
                               rounded-xl
                               text-sm
                               font-semibold
                               transition
                               shadow-sm
                               flex items-center gap-2">


                        <i
                            id="submitIcon"
                            class="fa-solid fa-plus text-xs">
                        </i>


                        <span id="submitText">
                            Save Market
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>



    <!-- ============================================================= -->
    <!-- JAVASCRIPT -->
    <!-- ============================================================= -->

    <script>
        /* ============================================================
           CATEGORY MODAL
        ============================================================ */


        function openCategoryModal() {

            const modal =
                document.getElementById('categoryModal');

            if (!modal) return;

            modal.classList.remove('hidden');

            modal.classList.add('flex');

        }



        function closeCategoryModal() {

            const modal =
                document.getElementById('categoryModal');

            if (!modal) return;

            modal.classList.add('hidden');

            modal.classList.remove('flex');


            const idInput =
                document.getElementById('categoryIdInput');

            const nameInput =
                document.getElementById('categoryNameInput');

            const title =
                document.getElementById('categoryModalTitle');


            if (idInput) {
                idInput.value = '';
            }


            if (nameInput) {
                nameInput.value = '';
            }


            if (title) {
                title.innerText = 'Add Category';
            }

        }



        function editRow(id, name) {

            const idInput =
                document.getElementById('categoryIdInput');

            const nameInput =
                document.getElementById('categoryNameInput');

            const title =
                document.getElementById('categoryModalTitle');


            if (idInput) {
                idInput.value = id;
            }


            if (nameInput) {
                nameInput.value = name;
            }


            if (title) {
                title.innerText = 'Edit Category';
            }


            openCategoryModal();

        }



        function deleteRow(id) {

            if (
                !confirm(
                    'Kya aap is category ko delete karna chahte hain?'
                )
            ) {
                return;
            }


            const form =
                document.createElement('form');

            form.method = 'POST';


            form.action =
                "{{ url('/admin/categories') }}/" + id;


            const csrfInput =
                document.createElement('input');

            csrfInput.type = 'hidden';

            csrfInput.name = '_token';

            csrfInput.value =
                '{{ csrf_token() }}';


            const methodInput =
                document.createElement('input');

            methodInput.type = 'hidden';

            methodInput.name = '_method';

            methodInput.value = 'DELETE';


            form.appendChild(csrfInput);

            form.appendChild(methodInput);

            document.body.appendChild(form);

            form.submit();

        }



        /* ============================================================
           MARKET MODAL
        ============================================================ */


        function openMarketModal() {

            const modal =
                document.getElementById('marketModal');

            if (!modal) return;

            modal.classList.remove('hidden');

            modal.classList.add('flex');

        }



        function closeMarketModal() {

            const modal =
                document.getElementById('marketModal');

            if (!modal) return;

            modal.classList.add('hidden');

            modal.classList.remove('flex');


            const idInput =
                document.getElementById('marketIdInput');

            const methodInput =
                document.getElementById('marketMethodInput');

            const form =
                document.getElementById('marketForm');


            const title =
                document.getElementById('marketModalTitle');

            const submitText =
                document.getElementById('submitText');

            const submitIcon =
                document.getElementById('submitIcon');

            const previewContainer =
                document.getElementById('imagePreviewContainer');

            const preview =
                document.getElementById('imagePreview');


            if (idInput) {
                idInput.value = '';
            }


            if (methodInput) {
                methodInput.value = 'POST';
            }


            if (form) {
                form.reset();
            }


            if (title) {
                title.innerText = 'Add Market';
            }


            if (submitText) {
                submitText.innerText = 'Save Market';
            }


            if (submitIcon) {
                submitIcon.className =
                    'fa-solid fa-plus text-xs';
            }


            if (previewContainer) {
                previewContainer.classList.add('hidden');
            }


            if (preview) {
                preview.src = '';
            }

        }



        function previewMarketImage(input) {

            const container =
                document.getElementById(
                    'imagePreviewContainer'
                );

            const preview =
                document.getElementById(
                    'imagePreview'
                );


            if (
                input &&
                input.files &&
                input.files[0]
            ) {

                const reader =
                    new FileReader();


                reader.onload = function(event) {

                    preview.src =
                        event.target.result;

                    container.classList.remove(
                        'hidden'
                    );

                };


                reader.readAsDataURL(
                    input.files[0]
                );

            }

        }



        /* ============================================================
           ESC KEY - CLOSE MODALS
        ============================================================ */


        document.addEventListener(
            'keydown',
            function(event) {

                if (event.key !== 'Escape') {
                    return;
                }


                closeCategoryModal();

                closeMarketModal();

            }
        );
    </script>



    <!-- ============================================================= -->
    <!-- CHART.JS -->
    <!-- ============================================================= -->

    <script>
        const chartElement =
            document.getElementById('activityChart');


        if (chartElement) {

            const ctx =
                chartElement.getContext('2d');


            const gradient =
                ctx.createLinearGradient(
                    0,
                    0,
                    0,
                    300
                );


            gradient.addColorStop(
                0,
                'rgba(217, 119, 6, 0.25)'
            );


            gradient.addColorStop(
                1,
                'rgba(217, 119, 6, 0.0)'
            );


            new Chart(ctx, {

                type: 'line',


                data: {

                    labels: [
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep'
                    ],


                    datasets: [{

                        label: 'Revenue (PKR)',


                        data: [
                            175,
                            220,
                            200,
                            275,
                            240,
                            255
                        ],


                        borderColor: '#D97706',

                        borderWidth: 2.5,

                        fill: true,

                        backgroundColor: gradient,

                        tension: 0.4,

                        pointRadius: 0,

                        pointHoverRadius: 6

                    }]

                },


                options: {

                    responsive: true,

                    maintainAspectRatio: false,


                    plugins: {

                        legend: {
                            display: false
                        }

                    },


                    scales: {

                        x: {

                            grid: {
                                display: false
                            },


                            ticks: {

                                color: '#9CA3AF',

                                font: {
                                    size: 12
                                }

                            }

                        },


                        y: {

                            min: 0,

                            max: 255,


                            ticks: {

                                stepSize: 85,

                                color: '#9CA3AF',

                                font: {
                                    size: 12
                                }

                            },


                            grid: {

                                color: '#E5DFD5',

                                borderDash: [
                                    4,
                                    4
                                ]

                            }

                        }

                    }

                }

            });

        }
    </script>


</body>

</html>