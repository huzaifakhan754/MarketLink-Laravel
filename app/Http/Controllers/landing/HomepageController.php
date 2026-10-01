<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Market;
use App\Models\Category;
use App\Models\Product;

class HomepageController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | MARKETS
        |--------------------------------------------------------------------------
        */

        $markets = Market::latest()->get();

        foreach ($markets as $market) {
            $market->vendor_count = Farmer::where('market_id', $market->id)
                ->where('status', 'active')
                ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        | Only first 4 categories for homepage
        */

        $categories = Category::latest()
            ->take(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FEATURED PRODUCTS
        |--------------------------------------------------------------------------
        | Only 4 available products
        */

        $featuredProducts = Product::where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS BY CATEGORY
        |--------------------------------------------------------------------------
        | Get products for the homepage category section
        */

        $categoryProducts = [];

        foreach ($categories as $category) {

            $categoryProducts[$category->id] = Product::where(
                'category_id',
                $category->id
            )
                ->where('status', 'available')
                ->where('stock_quantity', '>', 0)
                ->latest()
                ->take(8)
                ->get();
        }


        return view('welcome', compact(
            'markets',
            'categories',
            'featuredProducts',
            'categoryProducts'
        ));
    }


    public function markets()
    {
        $markets = Market::latest()->get();

        foreach ($markets as $market) {
            $market->vendor_count = Farmer::where('market_id', $market->id)
                ->where('status', 'active')
                ->count();
        }

        return view('market', compact('markets'));
    }
}