<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Market;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class profileController extends Controller
{
   public function index()
    {
        $farmer = Farmer::where('user_id', Auth::id())->first();
        $markets = Market::all(); // Markets table se sara data
        
        return view('farmer.profile', compact('farmer', 'markets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'farm_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'operating_days' => 'nullable|string',
            'pickup_window' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $farmer = Farmer::where('user_id', Auth::id())->first();
        $imagePath = $farmer->image ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('farmers', 'public');
        }

        Farmer::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'market_id' => $request->market_id,
                'farm_name' => $request->farm_name,
                'image' => $imagePath,
                'description' => $request->description,
                'operating_days' => $request->operating_days,
                'pickup_window' => $request->pickup_window,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        return redirect()->back()->with('success', 'Profile saved successfully!');
    }
    }
