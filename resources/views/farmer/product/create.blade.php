@extends('farmer.sidebar')

@section('content')
<div class="p-6 md:p-8 max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#1b4d3e]">Add New Product</h1>
            <p class="text-xs text-gray-500 mt-0.5">Fill details to list item in market</p>
        </div>
        <a href="{{ route('farmer.products.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">← Back</a>
    </div>

    <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Product Category</label>
                <select name="category_id" required class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e] bg-white">
                    <option value="" disabled selected>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e]">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Price (PKR)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Unit (e.g. kg, dozen)</label>
                <input type="text" name="unit" value="{{ old('unit', 'kg') }}" required class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Stock Quantity</label>
            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 1) }}" required class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e]">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full text-xs p-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#1b4d3e]">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">Product Image</label>
            <input type="file" name="image" accept="image/*" class="w-full text-xs p-2 rounded-xl border border-gray-200">
        </div>

        <button type="submit" class="w-full bg-[#1b4d3e] hover:bg-[#143b2f] text-white py-2.5 rounded-xl text-xs font-bold transition">Save Product</button>
    </form>
</div>
@endsection