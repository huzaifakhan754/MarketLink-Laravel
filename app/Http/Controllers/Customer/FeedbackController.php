<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Order must belong to logged-in customer
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only completed orders can receive feedback
        if ($order->status !== 'completed') {
            return back()->with('error', 'Feedback can only be given for completed orders.');
        }

        // One feedback per order
        if ($order->feedback) {
            return back()->with('error', 'You have already submitted feedback for this order.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Farmer comes directly from the order
        if (!$order->farmer_id) {
            return back()->with('error', 'Farmer information is not available for this order.');
        }

        Feedback::create([
            'order_id' => $order->id,
            'customer_id' => Auth::id(),
            'farmer_id' => $order->farmer_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Thank you! Your feedback has been sent to the farmer.');
    }
}