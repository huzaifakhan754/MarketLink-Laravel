<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer · Dashboard — MarketLink</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons & Tailwind CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#fcf8f2',
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
                        tableHeader: '#f5ebd9'
                    },
                    fontFamily: {
                        sans: ['"Work Sans"', 'sans-serif'],
                        display: ['"Fraunces"', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fcf8f2;
            color: #22251e;
            font-family: 'Work Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Fraunces', serif;
        }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #map {
            height: 320px;
            width: 100%;
            z-index: 1;
        }
    </style>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #FAF8F5;
            color: #1C2826;
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen flex">
        <!-- Sidebar Navigation (Pehle wala Sidebar + Nav Buttons) -->
        <aside class="w-64 bg-white border-r border-[#E5DFD5] flex-shrink-0 flex flex-col justify-between hidden md:flex sticky top-0 h-screen">
            <div>
                <!-- Brand Logo -->
                <div class="p-6 border-b border-[#E5DFD5]">
                    <a href="/" class="flex items-center gap-2.5 text-[#005327] font-bold text-2xl tracking-tight">
                        <span class="bg-[#005327] text-white p-2 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-leaf text-base"></i>
                        </span>
                        <span class="font-serif">MarketLink</span>
                    </a>
                </div>

                <!-- Navigation Links / Buttons in Sidebar -->
                <!-- Navigation Links / Buttons in Sidebar -->
                <nav class="p-4 space-y-2">

                    {{-- Overview --}}
                    <a href="{{ route('farmer.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.dashboard')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-solid fa-chart-line w-4"></i>
                        Overview
                    </a>

                    {{-- Profile --}}
                    <a href="{{ route('farmer.profile') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.profile')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-regular fa-user w-4"></i>
                        Profile
                    </a>

                    {{-- Products --}}
                    <a href="{{ route('farmer.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.products.*')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-solid fa-store w-4"></i>
                        Products
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('farmer.orders') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.orders')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-solid fa-bag-shopping w-4"></i>
                        Orders
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('farmer.pickup') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.pickup')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-solid fa-bag-shopping w-4"></i>
                        Pickup Orders
                    </a>
                     {{-- History --}}
                    <a href="{{ route('farmer.history') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.history')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                       <i class="fa-solid fa-clock-rotate-left"></i>
                        History
                    </a>

                    
                    {{-- Reviews --}}
                    <a href="{{ route('farmer.feedbacks') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition border border-transparent
        {{ request()->routeIs('farmer.feedbacks')
            ? 'bg-[#005327] text-white shadow-sm'
            : 'text-gray-600 hover:bg-[#FAF8F5] hover:text-[#005327] hover:border-[#E5DFD5]' }}">
                        <i class="fa-regular fa-star w-4"></i>
                        Reviews
                    </a>

                </nav>
            </div>

            <!-- Bottom Admin Info & Logout -->
            <div class="p-4 border-t border-[#E5DFD5]">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-[#005327]/10 text-[#005327] font-bold flex items-center justify-center text-sm overflow-hidden">
                            @if(Auth::user()->farmer && Auth::user()->farmer->image)
                            <img src="{{ asset('storage/' . Auth::user()->farmer->image) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                            {{ strtoupper(substr(Auth::user()->name ?? 'F', 0, 1)) }}
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-600 hover:bg-red-50 font-medium text-sm transition">
                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Bar Header -->
            <header class="bg-white border-b border-[#E5DFD5] py-4 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h1 class="text-2xl font-serif font-bold text-[#005327]">Farmer Dashboard</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Platform metrics, order flow, and catalog operations.</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 bg-[#FAF8F5] border border-[#E5DFD5] px-3.5 py-1.5 rounded-full text-xs font-semibold text-[#005327]">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Overview
                    </span>
                </div>
            </header>

            <!-- Dashboard Body Content -->
            @yield('content')
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl relative">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">Add Category</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Direct Laravel Form Submission -->
            <form action="{{ route('admin.categories.save') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="categoryIdInput">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" name="name" id="categoryNameInput" required placeholder="e.g. Fresh Vegetables" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 font-medium">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-lg text-sm font-medium hover:bg-emerald-800 transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryModal').classList.remove('flex');
            document.getElementById('categoryIdInput').value = '';
            document.getElementById('categoryNameInput').value = '';
            document.getElementById('modalTitle').innerText = 'Add Category';
        }

        function editRow(id, name) {
            document.getElementById('categoryIdInput').value = id;
            document.getElementById('categoryNameInput').value = name;
            document.getElementById('modalTitle').innerText = 'Edit Category';
            openModal();
        }

        function deleteRow(id) {
            if (confirm('Kya aap is category ko delete karna chahte hain?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                // Dynamic JS URL ke bajaye route helper ka URL prefix
                form.action = "{{ url('/admin/categories') }}/" + id;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }

        }
    </script>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('activityChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(217, 119, 6, 0.25)');
        gradient.addColorStop(1, 'rgba(217, 119, 6, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                datasets: [{
                    label: 'Revenue (PKR)',
                    data: [175, 220, 200, 275, 240, 255],
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
                            borderDash: [4, 4]
                        }
                    }
                }
            }
        });
    </script>

    <!-- Map profile page JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Preview Image on selection
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const placeholder = document.getElementById('imagePlaceholder');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Exact Coordinates for Landhi Town / Barmi Colony
        const LANDHI_LAT = 24.837709;
        const LANDHI_LNG = 67.171858;

        // Function to Search Location on Map
        function geocodeAddress(address) {
            if (!address || address.trim() === '') return;

            // Clean address for OpenStreetMap Search
            let cleanAddress = address;
            if (address.toLowerCase().includes('landhi')) {
                cleanAddress = 'Sector 36 A Landhi Town Karachi Pakistan';
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(cleanAddress)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;

                        map.setView([lat, lon], 16);
                        marker.setLatLng([lat, lon]);
                    } else {
                        // Fallback to Exact Landhi Coordinates if search returns nothing
                        setLandhiCoordinates();
                    }
                })
                .catch(() => {
                    setLandhiCoordinates();
                });
        }

        function setLandhiCoordinates() {
            document.getElementById('latitude').value = LANDHI_LAT;
            document.getElementById('longitude').value = LANDHI_LNG;
            map.setView([LANDHI_LAT, LANDHI_LNG], 16);
            marker.setLatLng([LANDHI_LAT, LANDHI_LNG]);
        }

        // Location Input Change Listener
        const locationInput = document.getElementById('locationInput');
        if (locationInput) {
            locationInput.addEventListener('change', function() {
                geocodeAddress(this.value);
            });
        }

        // Initial Map Load
        let savedLat = parseFloat(document.getElementById('latitude').value);
        let savedLng = parseFloat(document.getElementById('longitude').value);

        // Check if coordinates are invalid or Lea Market (24.8607)
        if (!savedLat || !savedLng || Math.abs(savedLat - 24.8607) < 0.01) {
            savedLat = LANDHI_LAT;
            savedLng = LANDHI_LNG;
            document.getElementById('latitude').value = LANDHI_LAT;
            document.getElementById('longitude').value = LANDHI_LNG;
        }

        const map = L.map('map').setView([savedLat, savedLng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: #1b4d3e; color: white; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 11px; white-space: nowrap; border: 2px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-family: sans-serif;"><i class="fa-solid fa-location-dot mr-1"></i> Your Stall</div>`,
            iconSize: [95, 32],
            iconAnchor: [47, 16]
        });

        let marker = L.marker([savedLat, savedLng], {
            draggable: true,
            icon: customIcon
        }).addTo(map);

        // Marker Drag and Map Click Events
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
    <!-- JavaScript add category modal Logic -->
    <!-- JavaScript Block for Categories -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>

</html>