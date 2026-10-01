<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Pending orders count
        $pendingOrders = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Existing data
        $upcomingPickups = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'ready')
            ->count();

        $spentLocally = Order::where('user_id', $user->id)
            ->whereIn('status', ['completed'])
            ->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

        $nextPickup = \App\Models\Order::with('product')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'ready'])
            ->latest()
            ->first();

        return view('dashboard', compact(
            'user',
            'upcomingPickups',
            'pendingOrders',
            'spentLocally',
            'nextPickup'
        ));
    }

    public function history()
    {
        $orders = \App\Models\Order::with([
            'product',
            'feedback'
        ])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest('created_at')
            ->get();

        return view('history', compact('orders'));
    }
}
