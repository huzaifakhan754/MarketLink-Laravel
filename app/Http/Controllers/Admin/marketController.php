<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class marketController extends Controller
{
    // Show Markets
    public function markets(): View
    {
        $markets = Market::latest()->get();

        return view('admin.market', compact('markets'));
    }

    // Add Market
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'timing' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('markets', 'public');
        }

        Market::create([
            'name' => $request->name,
            'location' => $request->location,
            'days' => $request->days,
            'timing' => $request->timing,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.markets')
            ->with('success', 'Market added successfully!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'days' => 'required|string|max:255',
        'timing' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $market = Market::findOrFail($id);

    $data = [
        'name' => $request->name,
        'location' => $request->location,
        'days' => $request->days,
        'timing' => $request->timing,
    ];

    if ($request->hasFile('image')) {

        if ($market->image) {
            Storage::disk('public')->delete($market->image);
        }

        $data['image'] =
            $request->file('image')->store('markets', 'public');
    }

    $market->update($data);

    return redirect()
        ->route('admin.markets')
        ->with('success', 'Market updated successfully!');
}

    // Delete Market
    public function destroy($id)
    {
        $market = Market::findOrFail($id);

        if ($market->image) {
            Storage::disk('public')->delete($market->image);
        }

        $market->delete();

        return redirect()
            ->route('admin.markets')
            ->with('success', 'Market deleted successfully!');
    }
}