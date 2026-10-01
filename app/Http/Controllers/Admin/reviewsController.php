<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class reviewsController extends Controller
{
    public function reviews()
    {
        $reviews = \App\Models\Feedback::with([
            'customer',
            'farmer.user',
            'order.product',
        ])
            ->latest()
            ->get();

        $totalReviews = $reviews->count();

        $averageRating = $totalReviews > 0
            ? round($reviews->avg('rating'), 1)
            : 0;

        return view('admin.reviews', compact(
            'reviews',
            'totalReviews',
            'averageRating'
        ));
    }
}
