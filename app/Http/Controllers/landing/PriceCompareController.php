<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Farmer;
use App\Models\Market;
use Illuminate\Http\Request;

class PriceCompareController extends Controller
{
    /**
     * Show Price Compare page.
     */
    public function index()
    {
        $products = Product::where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get()
            ->unique(function ($product) {
                return strtolower(trim($product->name));
            });

        return view('price-compare', compact('products'));
    }

    /**
     * Compare selected product prices across markets.
     */
    public function compare(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $selectedProduct = Product::findOrFail($request->product_id);

        /*
        |--------------------------------------------------------------------------
        | Find all products with the same name
        |--------------------------------------------------------------------------
        */

        $products = Product::whereRaw(
                'LOWER(TRIM(name)) = ?',
                [strtolower(trim($selectedProduct->name))]
            )
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->get();

        $comparisons = collect();

        foreach ($products as $product) {

            /*
            |--------------------------------------------------------------------------
            | Product belongs to a user.
            | Farmer is connected through farmers.user_id.
            |--------------------------------------------------------------------------
            */

            $farmer = Farmer::where('user_id', $product->user_id)->first();

            if (!$farmer || !$farmer->market_id) {
                continue;
            }

            $market = Market::find($farmer->market_id);

            if (!$market) {
                continue;
            }

            $comparisons->push([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => (float) $product->price,
                'unit' => $product->unit,
                'stock_quantity' => $product->stock_quantity,
                'image' => $product->image,
                'farmer_id' => $farmer->id,
                'market_id' => $market->id,
                'market_name' => $market->name,
                'market_location' => $market->location,
                'market_timing' => $market->timing,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sort cheapest first
        |--------------------------------------------------------------------------
        */

        $comparisons = $comparisons
            ->sortBy('price')
            ->values();

        $lowestPrice = $comparisons->min('price');

        return response()->json([
            'success' => true,
            'product' => $selectedProduct->name,
            'unit' => $selectedProduct->unit,
            'lowest_price' => $lowestPrice,
            'comparisons' => $comparisons,
        ]);
    }
}