@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-7xl space-y-6">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row
                md:items-center md:justify-between gap-4">

        <div>

            <div class="flex items-center gap-2 mb-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm text-gray-500
                          hover:text-[#1b4d3e] transition">

                    Dashboard

                </a>

                <i class="fa-solid fa-chevron-right
                          text-[9px] text-gray-400"></i>

                <span class="text-sm font-medium text-[#1b4d3e]">

                    Users

                </span>

            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Customers
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                View all registered customer accounts.
            </p>

        </div>


        {{-- TOTAL --}}
        <div class="bg-white border border-gray-200
                    rounded-xl px-5 py-3 shadow-sm">

            <p class="text-[10px] text-gray-400
                      uppercase font-semibold">

                Total Customers

            </p>

            <p class="text-xl font-bold text-[#1b4d3e]">

                {{ $totalCustomers }}

            </p>

        </div>

    </div>


    {{-- CUSTOMERS --}}
    @if($customers->count() > 0)

        <div class="bg-white border border-gray-200
                    rounded-2xl shadow-sm overflow-hidden">

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-[#f8f6f1]
                                 border-b border-gray-200">

                        <tr>

                            <th class="text-left px-5 py-4
                                       text-[10px] uppercase
                                       font-bold text-gray-400">

                                Customer

                            </th>

                            <th class="text-left px-5 py-4
                                       text-[10px] uppercase
                                       font-bold text-gray-400">

                                Email

                            </th>

                            <th class="text-left px-5 py-4
                                       text-[10px] uppercase
                                       font-bold text-gray-400">

                                Phone

                            </th>

                            <th class="text-left px-5 py-4
                                       text-[10px] uppercase
                                       font-bold text-gray-400">

                                Role

                            </th>

                            <th class="text-left px-5 py-4
                                       text-[10px] uppercase
                                       font-bold text-gray-400">

                                Registered

                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($customers as $customer)

                            <tr class="hover:bg-[#fdfbf7] transition">

                                {{-- CUSTOMER --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-full
                                                    bg-[#1b4d3e]/10
                                                    flex items-center
                                                    justify-center
                                                    shrink-0">

                                            <i class="fa-solid fa-user
                                                      text-[#1b4d3e]"></i>

                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold
                                                      text-gray-900">

                                                {{ $customer->name }}

                                            </p>

                                            <p class="text-[11px]
                                                      text-gray-400">

                                                Customer #{{ $customer->id }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-gray-700">

                                        {{ $customer->email }}

                                    </p>

                                </td>


                                {{-- PHONE --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-gray-700">

                                        {{ $customer->phone ?? 'N/A' }}

                                    </p>

                                </td>


                                {{-- ROLE --}}
                                <td class="px-5 py-4">

                                    <span class="inline-flex
                                                 items-center gap-1.5
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-blue-50
                                                 border border-blue-100
                                                 text-blue-700
                                                 text-[11px]
                                                 font-semibold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-blue-500"></span>

                                        Customer

                                    </span>

                                </td>


                                {{-- DATE --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm text-gray-700">

                                        {{ $customer->created_at?->format('d M Y') ?? 'N/A' }}

                                    </p>

                                    <p class="text-[11px] text-gray-400">

                                        {{ $customer->created_at?->format('h:i A') ?? '' }}

                                    </p>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @else

        {{-- EMPTY STATE --}}
        <div class="bg-white border border-gray-200
                    rounded-2xl shadow-sm
                    py-16 text-center">

            <div class="w-16 h-16 mx-auto
                        rounded-2xl
                        bg-[#1b4d3e]/10
                        flex items-center justify-center">

                <i class="fa-solid fa-users
                          text-[#1b4d3e] text-2xl"></i>

            </div>

            <h3 class="mt-4 text-lg font-bold text-gray-900">

                No Customers Found

            </h3>

            <p class="mt-1 text-sm text-gray-500">

                Registered customers will appear here.

            </p>

        </div>

    @endif

</div>

@endsection