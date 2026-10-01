<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Fresh Picks
    |--------------------------------------------------------------------------
    */

    public function freshPicks()
    {
        $products = Product::with([
            'category',
            'user.farmer'
        ])
            ->where('status', 'available')

            // Sirf ACTIVE farmers ke products
            ->whereHas('user.farmer', function ($query) {
                $query->where('status', 'active');
            })

            ->latest()
            ->paginate(12);

        return view('fresh-picks', compact('products'));
    }


    /*
    |--------------------------------------------------------------------------
    | Market Details
    |--------------------------------------------------------------------------
    */

    public function marketDetails($id)
    {
        $market = Market::with([
            'farmers' => function ($query) {
                $query->where('status', 'active');
            },

            'farmers.user',
            'farmers.products' => function ($query) {
                $query->where('status', 'available');
            },
            'farmers.products.category'
        ])->findOrFail($id);

        return view('market-details', compact('market'));
    }
}