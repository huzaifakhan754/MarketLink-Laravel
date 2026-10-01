<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class categoriesController extends Controller
{
    function index()
    {
        $categories = Category::all();
        return view('admin.categories',compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    \App\Models\Category::updateOrCreate(
        ['id' => $request->id],
        ['name' => $request->name]
    );

    return redirect()->back()->with('success', 'Category saved successfully!');
}

public function destroy($id)
{
    \App\Models\Category::destroy($id);
    return redirect()->back()->with('success', 'Category deleted successfully!');
}
}
