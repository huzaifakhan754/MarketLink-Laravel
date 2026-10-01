<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display farmer's own products
    public function index()
    {
        $products = Product::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(9);

        return view('farmer.products', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('farmer.product.create', compact('categories'));
    }

    // Store product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,

            // New products always need admin approval
            'status' => 'pending',
        ]);

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product added successfully! Waiting for admin approval.');
    }

    // Edit Product
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::orderBy('name', 'asc')->get();

        return view('farmer.product.edit', compact('product', 'categories'));
    }

    // Update Product
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,

            // Edited products need admin approval again
            'status' => 'pending',
        ]);

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product updated successfully! Waiting for admin approval.');
    }

    // Delete Product
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}