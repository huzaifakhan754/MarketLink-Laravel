<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class pickupController extends Controller
{

    public function pickup()
    {
        $orders = Order::with([
            'user',
            'product',
            'farmer.user',
        ])
            ->where('status', 'ready')
            ->latest()
            ->get();

        return view('admin.pickup', compact('orders'));
    }

    public function pickupShow($id)
    {
        $order = Order::with([
            'user',
            'product.category',
            'farmer.user',
            'farmer.market',
        ])
            ->where('status', 'ready')
            ->findOrFail($id);

        return view('admin.pickup-details', compact('order'));
    }

    public function history()
    {
        $orders = Order::with([
            'user',
            'product.category',
            'farmer.user',
        ])
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('admin.history', compact('orders'));
    }

    public function historyShow($id)
    {
        $order = Order::with([
            'user',
            'product.category',
            'farmer.user',
            'farmer.market',
        ])
            ->where('status', 'completed')
            ->findOrFail($id);

        return view('admin.history-details', compact('order'));
    }
}
