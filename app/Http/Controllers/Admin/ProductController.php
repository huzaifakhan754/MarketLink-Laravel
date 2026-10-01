<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Show pending product requests
     */
    public function requests()
    {
        $products = Product::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.products.requests', compact('products'));
    }

    /**
     * Approve product
     * pending -> available
     */
    public function approve(Product $product)
    {
        if ($product->status !== 'pending') {
            return back()->with(
                'error',
                'This product is not pending.'
            );
        }

        $product->update([
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            'Product approved and made available!'
        );
    }

    /**
     * Reject product
     * pending -> rejected
     */
    public function reject(Product $product)
    {
        if ($product->status !== 'pending') {
            return back()->with(
                'error',
                'This product is not pending.'
            );
        }

        $product->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Product rejected successfully!'
        );
    }

    /**
     * Show available and not available products
     */
    public function index()
    {
        $products = Product::with(['user', 'category'])
            ->whereIn('status', ['available', 'not_available'])
            ->latest()
            ->paginate(15);

        return view('admin.products.products', compact('products'));
    }

    /**
     * Mark product as not available
     * available -> not_available
     */
    public function makeNotAvailable(Product $product)
    {
        if ($product->status !== 'available') {
            return back()->with(
                'error',
                'Only available products can be marked as not available.'
            );
        }

        $product->update([
            'status' => 'not_available',
        ]);

        return back()->with(
            'success',
            'Product marked as not available.'
        );
    }

    /**
     * Make product available again
     * not_available -> available
     */
    public function makeAvailable(Product $product)
    {
        if ($product->status !== 'not_available') {
            return back()->with(
                'error',
                'This product is already available.'
            );
        }

        $product->update([
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            'Product is now available!'
        );
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with(
            'success',
            'Product deleted successfully!'
        );
    }
}