@extends('admin.sidebar')

@section('content')

<div class="p-6 md:p-8 max-w-[1600px] space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">

        <div>
            <h1 class="text-xl font-bold text-[#1b4d3e] tracking-tight">
                Products
            </h1>

            <p class="text-xs font-medium text-gray-500 mt-0.5">
                Manage products approved for the market
            </p>
        </div>

        <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-[#1b4d3e] px-4 py-2 rounded-xl text-xs font-bold">
            <i class="fa-solid fa-box text-[11px]"></i>

            {{ $products->total() }} Products
        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-900 text-xs font-semibold flex items-center justify-between">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-circle-check text-emerald-600"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

            <button
                onclick="this.parentElement.remove()"
                class="text-emerald-700 hover:text-emerald-900 text-xs font-bold">

                ✕

            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-rose-900 text-xs font-semibold flex items-center justify-between">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

            <button
                onclick="this.parentElement.remove()"
                class="text-rose-700 hover:text-rose-900 text-xs font-bold">

                ✕

            </button>

        </div>

    @endif


    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        @forelse($products as $product)

            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden flex flex-col justify-between hover:shadow-md transition">

                {{-- Image --}}
                <div class="relative h-44 bg-gray-50 border-b border-gray-100">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover">

                    @else

                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">

                            <i class="fa-solid fa-wheat-awn text-3xl mb-1"></i>

                            <span class="text-[11px] font-medium">
                                No Image
                            </span>

                        </div>

                    @endif


                    {{-- Category --}}
                    <div class="absolute top-3 left-3">

                        <span class="px-2.5 py-0.5 bg-white/90 backdrop-blur-sm text-[#1b4d3e] border border-[#1b4d3e]/20 rounded-md text-[10px] font-bold shadow-2xs">

                            {{ $product->category->name ?? 'Uncategorized' }}

                        </span>

                    </div>


                    {{-- Status --}}
                    <div class="absolute top-3 right-3">

                        @if($product->status === 'available')

                            <span class="px-2.5 py-1 bg-emerald-500 text-white rounded-full text-[10px] font-bold shadow-xs">

                                <i class="fa-solid fa-circle-check text-[9px] mr-1"></i>

                                Available

                            </span>

                        @else

                            <span class="px-2.5 py-1 bg-gray-500 text-white rounded-full text-[10px] font-bold shadow-xs">

                                <i class="fa-solid fa-eye-slash text-[9px] mr-1"></i>

                                Not Available

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Product Details --}}
                <div class="p-4 flex-1 flex flex-col justify-between">

                    <div>

                        {{-- Name + Price --}}
                        <div class="flex items-start justify-between gap-2 mb-1">

                            <h3 class="font-bold text-gray-900 text-xs leading-snug">

                                {{ $product->name }}

                            </h3>


                            <span class="text-xs font-bold text-[#1b4d3e] whitespace-nowrap bg-[#1b4d3e]/10 px-2 py-0.5 rounded-md">

                                PKR {{ number_format($product->price, 2) }}

                                /

                                {{ $product->unit }}

                            </span>

                        </div>


                        {{-- Description --}}
                        <p class="text-xs text-gray-500 line-clamp-2 mt-1 font-medium">

                            {{ $product->description ?? 'No description available.' }}

                        </p>


                        {{-- Farmer --}}
                        <div class="mt-4 flex items-center gap-2">

                            <div class="w-7 h-7 rounded-full bg-[#1b4d3e]/10 flex items-center justify-center text-[#1b4d3e]">

                                <i class="fa-solid fa-user text-[11px]"></i>

                            </div>

                            <div class="min-w-0">

                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">

                                    Farmer

                                </p>

                                <p class="text-xs font-bold text-gray-700 truncate">

                                    {{ $product->user->name ?? 'Unknown Farmer' }}

                                </p>

                            </div>

                        </div>


                        {{-- Stock --}}
                        <div class="mt-3 flex items-center gap-2">

                            <div class="w-7 h-7 rounded-full bg-orange-50 flex items-center justify-center text-[#ca6232]">

                                <i class="fa-solid fa-boxes-stacked text-[11px]"></i>

                            </div>

                            <div>

                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide">

                                    Stock

                                </p>

                                <p class="text-xs font-bold text-gray-700">

                                    {{ $product->stock_quantity }}

                                    {{ $product->unit }}

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex items-center gap-2 pt-4 mt-4 border-t border-gray-100">

                        @if($product->status === 'available')

                            {{-- Not Available --}}
                            <form
                                action="{{ route('admin.products.not_available', $product->id) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to mark this product as not available?');">

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold transition border border-rose-200/60">

                                    <i class="fa-solid fa-eye-slash text-[11px] mr-1"></i>

                                    Not Available

                                </button>

                            </form>

                        @elseif($product->status === 'not_available')

                            {{-- Make Available --}}
                            <form
                                action="{{ route('admin.products.make_available', $product->id) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Make this product available again?');">

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-center px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold transition border border-emerald-200/60">

                                    <i class="fa-solid fa-eye text-[11px] mr-1"></i>

                                    Make Available

                                </button>

                            </form>

                        @endif


                        {{-- Delete --}}
                        <form
                            action="{{ route('admin.products.destroy', $product->id) }}"
                            method="POST"
                            class="flex-1"
                            onsubmit="return confirm('Are you sure you want to delete this product permanently?');">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-full text-center px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg text-xs font-semibold transition border border-gray-200">

                                <i class="fa-solid fa-trash text-[11px] mr-1"></i>

                                Delete

                            </button>

                        </form>

                    </div>


                    {{-- Date --}}
                    <div class="mt-3 text-center">

                        <span class="text-[10px] text-gray-400 font-medium">

                            <i class="fa-regular fa-clock mr-1"></i>

                            Added
                            {{ $product->created_at->format('d M Y, h:i A') }}

                        </span>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full py-16 bg-white rounded-2xl border border-gray-200/80 text-center">

                <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>

                <h3 class="text-xs font-bold text-gray-700">

                    No Products Found

                </h3>

                <p class="text-xs text-gray-400 mt-0.5">

                    There are currently no available products.

                </p>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if($products->hasPages())

        <div class="pt-4">

            {{ $products->links() }}

        </div>

    @endif

</div>

@endsection