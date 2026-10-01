@extends('farmer.sidebar')
@section('content')
<div class="p-6 md:p-8 max-w-[1600px]  space-y-6">

    <!-- Header & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <h1 class="text-xl font-bold text-[#1b4d3e] tracking-tight">My Products</h1>
            <p class="text-xs font-medium text-gray-500 mt-0.5">Manage items listed under your farmer account</p>
        </div>

        <a href="{{ route('farmer.products.create') }}" class="inline-flex items-center gap-2 bg-[#1b4d3e] hover:bg-[#143b2f] text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-2xs">
            <i class="fa-solid fa-plus text-xs"></i> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-900 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-xs font-bold">✕</button>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                <div class="relative h-44 bg-gray-50 border-b border-gray-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                            <i class="fa-solid fa-wheat-awn text-3xl mb-1"></i>
                            <span class="text-[11px] font-medium">No Image</span>
                        </div>
                    @endif

                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-0.5 bg-white/90 backdrop-blur-sm text-[#1b4d3e] border border-[#1b4d3e]/20 rounded-md text-[10px] font-bold shadow-2xs">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <div class="absolute top-3 right-3">
                        @if($product->stock_quantity > 0)
                            <span class="px-2.5 py-1 bg-emerald-500 text-white rounded-full text-[10px] font-bold shadow-xs">
                                In Stock ({{ $product->stock_quantity }})
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-rose-500 text-white rounded-full text-[10px] font-bold shadow-xs">
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h3 class="font-bold text-gray-900 text-xs leading-snug">{{ $product->name }}</h3>
                            <span class="text-xs font-bold text-[#1b4d3e] whitespace-nowrap bg-[#1b4d3e]/10 px-2 py-0.5 rounded-md">
                                PKR {{ number_format($product->price, 2) }} / {{ $product->unit }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-2 mt-1 font-medium">
                            {{ $product->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 pt-4 mt-4 border-t border-gray-100">
                        <a href="{{ route('farmer.products.edit', $product->id) }}" class="flex-1 text-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold transition">
                            <i class="fa-solid fa-pen-to-square text-[11px] mr-1"></i> Edit
                        </a>

                        <form action="{{ route('farmer.products.destroy', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold transition border border-rose-200/60">
                                <i class="fa-solid fa-trash text-[11px] mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 bg-white rounded-2xl border border-gray-200/80 text-center">
                <i class="fa-solid fa-store-slash text-4xl text-gray-300 mb-3"></i>
                <h3 class="text-xs font-bold text-gray-700">No products found</h3>
                <p class="text-xs text-gray-400 mt-0.5">Click "Add New Product" to list your products.</p>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="pt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection