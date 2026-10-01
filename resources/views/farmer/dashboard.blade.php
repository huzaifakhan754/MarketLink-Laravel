@extends('farmer.sidebar')

@section('content')

<main class="p-6 sm:p-8 space-y-8">

    <!-- ============================= -->
    <!-- TOP STAT CARDS -->
    <!-- ============================= -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


        <!-- Total Orders -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">

                <p class="text-xs font-semibold uppercase text-[#005327] tracking-wider">
                    Total Orders
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#005327]/10 flex items-center justify-center">
                    <i class="fa-solid fa-cart-shopping text-[#005327]"></i>
                </div>

            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $totalOrders }}
            </p>

            <p class="text-xs text-gray-500 font-medium mt-1">
                All orders received
            </p>

        </div>


        <!-- Pending Orders -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">

                <p class="text-xs font-semibold uppercase text-amber-600 tracking-wider">
                    Pending Orders
                </p>

                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-amber-600"></i>
                </div>

            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $pendingOrders }}
            </p>

            <p class="text-xs text-amber-600 font-medium mt-1">
                Pending / ready orders
            </p>

        </div>


        <!-- Total Products -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">

                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    My Products
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#ca6232]/10 flex items-center justify-center">
                    <i class="fa-solid fa-box-open text-[#ca6232]"></i>
                </div>

            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $totalProducts }}
            </p>

            <p class="text-xs text-[#005327] font-medium mt-1">
                Products listed
            </p>

        </div>


        <!-- Total Revenue -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">

                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Total Revenue
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#1C2826]/10 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-[#1C2826]"></i>
                </div>

            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                PKR {{ number_format($totalRevenue, 0) }}
            </p>

            <p class="text-xs text-gray-500 font-medium mt-1">
                From completed orders
            </p>

        </div>

    </div>


    <!-- ============================= -->
    <!-- FARMER INFO / RATING -->
    <!-- ============================= -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Farmer Profile -->
        <div class="lg:col-span-2 bg-white border border-[#E5DFD5] rounded-2xl shadow-sm p-6">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl bg-[#005327]/10 flex items-center justify-center">
                    <i class="fa-solid fa-seedling text-[#005327] text-xl"></i>
                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#1C2826]">
                        {{ $farmer->farm_name ?? auth()->user()->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $farmer->location ?? 'Local Grower' }}
                    </p>

                </div>

            </div>

        </div>


        <!-- Rating -->
        <div class="bg-white border border-[#E5DFD5] rounded-2xl shadow-sm p-6">

            <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                Customer Rating
            </p>

            <div class="flex items-center gap-3 mt-3">

                <span class="text-3xl font-bold text-[#1C2826]">
                    {{ number_format($averageRating, 1) }}
                </span>

                <div>

                    <div class="text-amber-400 text-sm">

                        @for($i = 1; $i <= 5; $i++)

                            @if($i <= round($averageRating))
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif

                        @endfor

                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Based on customer reviews
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================= -->
    <!-- MONTHLY REVENUE GRAPH -->
    <!-- ============================= -->

    <div class="bg-white border border-[#E5DFD5] p-6 sm:p-8 rounded-2xl shadow-sm">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>

                <h2 class="text-lg font-serif font-bold text-[#1C2826]">
                    Monthly Revenue
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Your completed order revenue for {{ now()->year }}.
                </p>

            </div>

            <div class="text-xs font-semibold text-gray-500 bg-[#FAF8F5] border border-[#E5DFD5] px-3 py-1.5 rounded-lg">
                {{ now()->year }}
            </div>

        </div>


        <!-- Chart -->
        <div class="h-72 w-full">

            <canvas id="activityChart"></canvas>

        </div>

    </div>

</main>


<!-- ============================= -->
<!-- CHART JS -->
<!-- ============================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);

    const ctx = document.getElementById('activityChart');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: chartLabels,

            datasets: [

                {
                    label: 'Revenue',

                    data: chartData,

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true,

                    pointRadius: 4,

                    pointHoverRadius: 6
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' PKR ' +
                                Number(context.raw).toLocaleString();

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'PKR ' +
                                Number(value).toLocaleString();

                        }

                    }

                },

                x: {

                    grid: {
                        display: false
                    }

                }

            }

        }

    });

</script>

@endsection