<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;

class farmerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Farmers List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $farmers = Farmer::with([
            'user',
            'market'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.farmers', compact('farmers'));
    }


    /*
    |--------------------------------------------------------------------------
    | Farmer Profile
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $farmer = Farmer::with([
            'user',
            'market',
            'products.category'
        ])->findOrFail($id);

        $totalProducts = $farmer->products->count();

        $availableProducts = $farmer->products
            ->where('status', 'available')
            ->count();

        return view('admin.farmer-profile', compact(
            'farmer',
            'totalProducts',
            'availableProducts'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Farmer Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $farmer = Farmer::findOrFail($id);

        $farmer->status = ($farmer->status === 'active')
            ? 'suspended'
            : 'active';

        $farmer->save();

        $msg = $farmer->status === 'suspended'
            ? 'Farmer suspended successfully.'
            : 'Farmer activated successfully.';

        return redirect()
            ->back()
            ->with('success', $msg);
    }
}