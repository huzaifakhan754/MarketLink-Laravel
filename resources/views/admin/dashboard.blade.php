@extends('admin.sidebar')

@section('content')

<main class="p-6 sm:p-8 space-y-8">

    <!-- ============================= -->
    <!-- TOP STAT CARDS -->
    <!-- ============================= -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Volume -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Total Volume
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#005327]/10 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-[#005327]"></i>
                </div>
            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                PKR {{ number_format($totalVolume, 0) }}
            </p>

            <p class="text-xs text-gray-500 font-medium mt-1">
                Total completed order revenue
            </p>

        </div>


        <!-- Active Pickups -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Active Pickups
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#ca6232]/10 flex items-center justify-center">
                    <i class="fa-solid fa-box text-[#ca6232]"></i>
                </div>
            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $activePickups }}
            </p>

            <p class="text-xs text-amber-600 font-medium mt-1">
                Orders ready for pickup
            </p>

        </div>


        <!-- Local Growers -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Local Growers
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#005327]/10 flex items-center justify-center">
                    <i class="fa-solid fa-seedling text-[#005327]"></i>
                </div>
            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $localGrowers }}
            </p>

            <p class="text-xs text-[#005327] font-medium mt-1">
                Active farmers
            </p>

        </div>


        <!-- Consumers -->
        <div class="bg-white border border-[#E5DFD5] p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Consumers
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#1C2826]/10 flex items-center justify-center">
                    <i class="fa-solid fa-users text-[#1C2826]"></i>
                </div>
            </div>

            <p class="text-3xl font-bold text-[#1C2826] mt-3">
                {{ $consumers }}
            </p>

            <p class="text-xs text-gray-500 font-medium mt-1">
                Registered customers
            </p>

        </div>

    </div>


    <!-- ============================= -->
    <!-- MONTHLY ACTIVITY GRAPH -->
    <!-- ============================= -->

    <div class="bg-white border border-[#E5DFD5] p-6 sm:p-8 rounded-2xl shadow-sm">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h2 class="text-lg font-serif font-bold text-[#1C2826]">
                    Monthly Marketplace Activity
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Completed order revenue for {{ now()->year }}.
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
<!-- CHART.JS -->
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

            datasets: [{
                label: 'Revenue',

                data: chartData,

                borderWidth: 3,

                tension: 0.4,

                fill: true,

                pointRadius: 4,

                pointHoverRadius: 6
            }]
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