@extends('admin.sidebar')
@section('content')
<main class="flex-1 p-6 md:p-8 max-w-7xl mx-auto w-full">

    <!-- Top Title Bar & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">CATALOG</p>
            <h1 class="text-2xl font-bold text-gray-900">Manage categories.</h1>
        </div>
        <button onclick="openModal()" class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition shadow-sm flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i> Add category
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                        <th class="p-4 w-24">ID</th>
                        <th class="p-4">Category Name</th>
                        <th class="p-4">Created At</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody" class="divide-y divide-gray-100 text-sm">
                    @foreach($categories as $category)
                    <tr id="row-{{ $category->id }}">
                        <td class="p-4 text-gray-500 font-mono text-xs">#{{ $category->id }}</td>
                        <td class="p-4 font-medium text-gray-900 category-name">{{ $category->name }}</td>
                        <td class="p-4 font-medium text-gray-900 category-name">{{ $category->created_at->format('Y-m-d') }}</td>
                        <td class="p-4 text-right space-x-2 whitespace-nowrap">
                            <button onclick="editRow({{ $category->id }}, '{{ $category->name }}')" class="px-3 py-1 text-xs bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-md font-medium transition">Edit</button>
                            <button onclick="deleteRow({{ $category->id }})" class="px-3 py-1 text-xs bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-md font-medium transition">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>
@endsection