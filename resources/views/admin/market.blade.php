@extends('admin.sidebar')
@section('content')
<main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        <i class="fa-solid fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif
    <!-- Top Title Bar & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">LOCATIONS</p>
            <h1 class="text-2xl font-bold text-gray-900">Manage markets.</h1>
        </div>
        <button onclick="openMarketModal()" class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition shadow-sm flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i> Add market
        </button>
    </div>

    <!-- Data Table Card -->
    <!-- Markets Table -->
    <!-- Markets Table -->
    <div class="bg-white rounded-2xl border border-[#E5DFD5] shadow-[0_8px_30px_rgba(0,83,39,0.06)] overflow-hidden">

        <!-- Table Header -->
        <div class="px-6 py-5 border-b border-[#E5DFD5] flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#1C2826]">
                    Market Locations
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Manage registered markets, locations and timings
                </p>
            </div>

            <div class="flex items-center gap-2 bg-[#005327]/5 text-[#005327] px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>

                <span class="text-xs font-semibold">
                    {{ $markets->count() }} Markets
                </span>
            </div>
        </div>


        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <!-- Head -->
                <thead>
                    <tr class="bg-[#FAF8F5] border-b border-[#E5DFD5]">

                        <th class="px-6 py-4 text-[11px] uppercase tracking-wider font-bold text-[#005327]">
                            Market
                        </th>

                        <th class="px-6 py-4 text-[11px] uppercase tracking-wider font-bold text-[#005327]">
                            Location
                        </th>

                        <th class="px-6 py-4 text-[11px] uppercase tracking-wider font-bold text-[#005327]">
                            Days
                        </th>

                        <th class="px-6 py-4 text-[11px] uppercase tracking-wider font-bold text-[#005327]">
                            Timing
                        </th>

                        <th class="px-6 py-4 text-[11px] uppercase tracking-wider font-bold text-[#005327] text-right">
                            Actions
                        </th>

                    </tr>
                </thead>


                <!-- Body -->
                <tbody class="divide-y divide-[#F0ECE5]">

                    @forelse($markets as $market)

                    <tr class="group hover:bg-[#FAFDFB] transition duration-200">

                        <!-- Market -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                @if($market->image)

                                <img
                                    src="{{ asset('storage/' . $market->image) }}"
                                    alt="{{ $market->name }}"
                                    class="w-12 h-12 rounded-xl object-cover border border-[#E5DFD5]">

                                @else

                                <div class="w-12 h-12 rounded-xl bg-[#005327]/10 text-[#005327]
                                            flex items-center justify-center
                                            group-hover:bg-[#005327]
                                            group-hover:text-white
                                            transition duration-200">

                                    <i class="fa-solid fa-store"></i>

                                </div>

                                @endif


                                <div>

                                    <p class="font-semibold text-[#1C2826]">
                                        {{ $market->name }}
                                    </p>

                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        Market
                                    </p>

                                </div>

                            </div>

                        </td>


                        <!-- Location -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-2 text-sm text-gray-600">

                                <i class="fa-solid fa-location-dot text-[#005327]"></i>

                                {{ $market->location }}

                            </span>

                        </td>


                        <!-- Days -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-2
                                     bg-[#FAF8F5]
                                     border border-[#E5DFD5]
                                     text-[#1C2826]
                                     px-3 py-2
                                     rounded-lg
                                     text-xs font-medium">

                                <i class="fa-regular fa-calendar text-[#005327]"></i>

                                {{ $market->days }}

                            </span>

                        </td>


                        <!-- Timing -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-2
                                     bg-[#FAF8F5]
                                     border border-[#E5DFD5]
                                     text-[#1C2826]
                                     px-3 py-2
                                     rounded-lg
                                     text-xs font-medium">

                                <i class="fa-regular fa-clock text-[#005327]"></i>

                                {{ $market->timing }}

                            </span>

                        </td>


                        <!-- Actions -->
                        <td class="px-6 py-5 text-right">

                            <div class="flex justify-end items-center gap-2">

                                
                                <!-- EDIT -->
                                <button
                                    type="button"
                                    onclick="editMarket(
        {{ $market->id }},
        @js($market->name),
        @js($market->location),
        @js($market->days),
        @js($market->timing),
        @js($market->image)
    )"
                                    class="w-9 h-9 rounded-lg
           bg-amber-50
           text-amber-600
           border border-amber-100
           hover:bg-amber-500
           hover:text-white
           transition"
                                    title="Edit Market">

                                    <i class="fa-solid fa-pen text-xs"></i>

                                </button>
                            


                                <!-- Delete -->
                                <form
                                    action="{{ route('admin.markets.destroy', $market->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Kya aap is market ko delete karna chahte hain?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="w-9 h-9 rounded-lg
                                           bg-red-50
                                           text-red-500
                                           border border-red-100
                                           hover:bg-red-500
                                           hover:text-white
                                           transition duration-200"
                                        title="Delete Market">

                                        <i class="fa-solid fa-trash text-xs"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                    @empty

                    <!-- Empty State -->
                    <tr>

                        <td colspan="5" class="px-6 py-14 text-center">

                            <div class="flex flex-col items-center">

                                <div class="w-16 h-16 rounded-2xl
                                        bg-[#005327]/10
                                        text-[#005327]
                                        flex items-center justify-center mb-4">

                                    <i class="fa-solid fa-store-slash text-xl"></i>

                                </div>

                                <h3 class="font-semibold text-[#1C2826]">
                                    No Markets Found
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Add your first market to get started.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>
</div>
</div>
<!-- MARKET MODAL -->
<div
    id="marketModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-4"
>
    <div
        class="bg-white w-full max-w-2xl max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden flex flex-col"
    >

        <!-- HEADER -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">

            <div>
                <h3
                    id="marketModalTitle"
                    class="text-lg font-bold text-gray-900"
                >
                    Add Market
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Add or update market information.
                </p>
            </div>

            <button
                type="button"
                onclick="closeMarketModal()"
                class="w-9 h-9 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-600 transition"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>


        <!-- FORM -->
        <form
            id="marketForm"
            action="{{ route('admin.markets.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex flex-col min-h-0"
        >

            @csrf

            <input
                type="hidden"
                name="id"
                id="marketIdInput"
            >

            <input
                type="hidden"
                name="_method"
                id="marketMethodInput"
                value="POST"
            >


            <!-- SCROLLABLE CONTENT -->
            <div class="p-6 space-y-5 overflow-y-auto">

                <!-- NAME -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Market Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="marketNameInput"
                        required
                        placeholder="Enter market name"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 outline-none"
                    >
                </div>


                <!-- LOCATION -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Location
                    </label>

                    <input
                        type="text"
                        name="location"
                        id="marketLocationInput"
                        required
                        placeholder="Enter market location"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 outline-none"
                    >
                </div>


                <!-- DAYS + TIMING -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Days
                        </label>

                        <input
                            type="text"
                            name="days"
                            id="marketDaysInput"
                            placeholder="e.g. Saturday & Sunday"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 outline-none"
                        >
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Timing
                        </label>

                        <input
                            type="text"
                            name="timing"
                            id="marketTimingInput"
                            placeholder="e.g. 9:00 AM - 6:00 PM"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 outline-none"
                        >
                    </div>

                </div>


                <!-- IMAGE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Market Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="marketImageInput"
                        accept="image/*"
                        onchange="previewMarketImage(this)"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-sm"
                    >
                </div>


                <!-- IMAGE PREVIEW -->
                <div id="imagePreviewContainer" class="hidden">

                    <p class="text-sm font-medium text-gray-700 mb-2">
                        Image Preview
                    </p>

                    <img
                        id="imagePreview"
                        src=""
                        class="w-28 h-20 object-cover rounded-xl border border-gray-200"
                    >

                </div>

            </div>


            <!-- FOOTER -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50 shrink-0">

                <button
                    type="button"
                    onclick="closeMarketModal()"
                    class="px-5 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-sm font-medium"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white transition text-sm font-medium flex items-center gap-2"
                >
                    <i
                        id="submitIcon"
                        class="fa-solid fa-plus text-xs"
                    ></i>

                    <span id="submitText">
                        Save Market
                    </span>
                </button>

            </div>

        </form>

    </div>
</div>

<script>
    function openMarketModal() {

        const modal = document.getElementById('marketModal');
        const form = document.getElementById('marketForm');

        // Reset form
        form.reset();

        // Reset hidden fields
        document.getElementById('marketIdInput').value = '';
        document.getElementById('marketMethodInput').value = 'POST';

        // Store route
        form.action = "{{ route('admin.markets.store') }}";

        // Title
        document.getElementById('marketModalTitle').innerText = 'Add Market';

        // Button
        document.getElementById('submitIcon').className =
            'fa-solid fa-plus text-xs';

        document.getElementById('submitText').innerText =
            'Save Market';

        // Remove image preview
        document
            .getElementById('imagePreviewContainer')
            .classList
            .add('hidden');

        document.getElementById('imagePreview').src = '';

        // Open
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function editMarket(id, name, location, days, timing, image) {

        const modal = document.getElementById('marketModal');
        const form = document.getElementById('marketForm');

        // ID
        document.getElementById('marketIdInput').value = id;

        // PUT
        document.getElementById('marketMethodInput').value = 'PUT';

        // Update URL
        form.action = "{{ url('/admin/markets') }}/" + id;

        // Fill data
        document.getElementById('marketNameInput').value = name ?? '';

        document.getElementById('marketLocationInput').value =
            location ?? '';

        document.getElementById('marketDaysInput').value =
            days ?? '';

        document.getElementById('marketTimingInput').value =
            timing ?? '';


        // Change title
        document.getElementById('marketModalTitle').innerText =
            'Edit Market';


        // Change button
        document.getElementById('submitIcon').className =
            'fa-solid fa-pen text-xs';

        document.getElementById('submitText').innerText =
            'Update Market';


        // Existing image
        const previewContainer =
            document.getElementById('imagePreviewContainer');

        const preview =
            document.getElementById('imagePreview');


        if (image) {

            preview.src =
                "{{ asset('storage') }}/" + image;

            previewContainer.classList.remove('hidden');

        } else {

            preview.src = '';

            previewContainer.classList.add('hidden');

        }


        // Open modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeMarketModal() {

        const modal =
            document.getElementById('marketModal');

        const form =
            document.getElementById('marketForm');


        modal.classList.add('hidden');
        modal.classList.remove('flex');


        // Reset
        form.reset();

        document.getElementById('marketIdInput').value = '';

        document.getElementById('marketMethodInput').value =
            'POST';

        form.action =
            "{{ route('admin.markets.store') }}";


        // Reset title
        document.getElementById('marketModalTitle').innerText =
            'Add Market';


        // Reset button
        document.getElementById('submitIcon').className =
            'fa-solid fa-plus text-xs';

        document.getElementById('submitText').innerText =
            'Save Market';


        // Reset image
        document
            .getElementById('imagePreviewContainer')
            .classList
            .add('hidden');

        document.getElementById('imagePreview').src = '';
    }


    function previewMarketImage(input) {

        const preview =
            document.getElementById('imagePreview');

        const container =
            document.getElementById('imagePreviewContainer');


        if (input.files && input.files[0]) {

            const reader = new FileReader();

            reader.onload = function(e) {

                preview.src = e.target.result;

                container.classList.remove('hidden');

            };

            reader.readAsDataURL(input.files[0]);

        } else {

            preview.src = '';

            container.classList.add('hidden');

        }
    }


    // Close when clicking outside
    document
        .getElementById('marketModal')
        .addEventListener('click', function(e) {

            if (e.target === this) {
                closeMarketModal();
            }

        });


    // ESC key
    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            const modal =
                document.getElementById('marketModal');

            if (!modal.classList.contains('hidden')) {
                closeMarketModal();
            }

        }

    });
</script>
@endsection