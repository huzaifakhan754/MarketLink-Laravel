@extends('farmer.sidebar')
@section('content')
<!-- Main Section -->
<!-- Main Content Area -->
<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">

    <div class="max-w-5xl mx-auto">
        @if(session('success'))
        <div class="mb-6 p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200/80 rounded-2xl flex items-center gap-3 font-medium shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-8">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#1b4d3e]">STALL SETTINGS</span>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight mt-0.5">Your Market Profile</h1>
        </div>

        <form action="{{ route('farmer.profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Form Details Card -->
            <div class="bg-white p-7 rounded-2xl border border-gray-200/70 shadow-sm space-y-6">
                <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-[#1b4d3e] text-sm"></i> Farm Information
                </h2>

                <!-- Image Upload Section -->
                <div class="flex items-center gap-6 pb-2">
                    <div class="relative w-20 h-20 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden shrink-0">
                        @if(isset($farmer->image) &&$farmer->image)
                        <img id="imagePreview" src="{{ asset('storage/' . $farmer->image) }}" class="w-full h-full object-cover">
                        @else
                        <i id="imagePlaceholder" class="fa-solid fa-image text-gray-400 text-2xl"></i>
                        <img id="imagePreview" class="w-full h-full object-cover hidden">
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Profile / Stall Image</label>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#1b4d3e] hover:file:bg-emerald-100 cursor-pointer">
                        <span class="text-[11px] text-gray-400 mt-1 block">PNG, JPG, or WEBP up to 2MB.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Farm Name -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Farm / Stall Name</label>
                        <input type="text" name="farm_name" value="{{ old('farm_name', $farmer->farm_name ?? '') }}" required placeholder="e.g. Green Valley Organics"
                            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">
                    </div>

                    <!-- Location Address -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Stall Address / Location</label>
                        <input type="text" id="locationInput" name="location" value="{{ old('location', $farmer->location ?? '') }}" placeholder="e.g. Stall 12, River District Market"
                            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">
                    </div>

                    <!-- Operating Days -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Operating Days</label>
                        <input type="text" name="operating_days" value="{{ old('operating_days', $farmer->operating_days ?? '') }}" placeholder="e.g. Wednesday, Saturday"
                            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">
                    </div>

                    <!-- Pickup Window -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Pickup Window</label>
                        <input type="text" name="pickup_window" value="{{ old('pickup_window', $farmer->pickup_window ?? '') }}" placeholder="e.g. 8:00am – 1:00pm"
                            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">
                    </div>
                </div>
                <!-- Select Market Dropdown -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Select Market</label>
                    <select name="market_id" required
                        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">
                        <option value="" disabled {{ old('market_id', $farmer->market_id ?? '') == '' ? 'selected' : '' }}>-- Select a Market --</option>
                        @foreach($markets as $market)
                        <option value="{{ $market->id }}" {{ old('market_id', $farmer->market_id ?? '') == $market->id ? 'selected' : '' }}>
                            {{ $market->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stall Description -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Stall Description</label>
                    <textarea name="description" rows="3" placeholder="Tell buyers about your produce and farm..."
                        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1b4d3e] focus:outline-none text-sm font-semibold text-gray-800 transition">{{ old('description', $farmer->description ?? '') }}</textarea>
                </div>

                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $farmer->latitude ?? '24.8607') }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $farmer->longitude ?? '67.0011') }}">
            </div>

            <!-- Map Section -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200/70 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-[#1b4d3e] text-sm"></i> Precise Map Location
                    </h2>
                    <span class="text-xs text-gray-400 font-medium"><i class="fa-regular fa-hand-pointer mr-1"></i> Click map or drag pin to move location</span>
                </div>

                <div id="map"></div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-[#1b4d3e] hover:bg-[#153e32] text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-sm hover:shadow flex items-center gap-2">
                    <i class="fa-regular fa-floppy-disk"></i> Save Profile Settings
                </button>
            </div>

        </form>
    </div>

</main>
@endsection