<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Show only pending orders of logged-in farmer
     */
    public function index()
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $orders = Order::with([
            'user',
            'product'
        ])
            ->where('farmer_id', $farmer->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('farmer.orders', compact('orders'));
    }

    /**
     * Confirm Order
     *
     * Pending -> Ready
     */
    public function confirm($id)
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $order = Order::with('user')
            ->where('id', $id)
            ->where('farmer_id', $farmer->id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Pending -> Ready
        $order->update([
            'status' => 'ready',
        ]);

        // Send email to customer
        if ($order->user) {
            $order->user->notify(
                new OrderStatusNotification(
                    $order,
                    $order->status
                )
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Order successfully confirmed and customer notified.'
            );
    }

    /**
     * Cancel / Reject Order
     *
     * Pending -> Rejected
     */
    public function cancel($id)
    {
        $order = DB::transaction(function () use ($id) {

            $farmer = Farmer::where('user_id', auth()->id())
                ->firstOrFail();

            $order = Order::with([
                'product',
                'user'
            ])
                ->where('id', $id)
                ->where('farmer_id', $farmer->id)
                ->where('status', 'pending')
                ->firstOrFail();

            // Restore stock
            if ($order->product) {
                $order->product->increment(
                    'stock_quantity',
                    $order->quantity
                );
            }

            // Pending -> Rejected
            $order->update([
                'status' => 'rejected',
            ]);

            return $order;
        });

        // Send email after successful transaction
        if ($order->user) {
            $order->user->notify(
                new OrderStatusNotification(
                    $order,
                    $order->status
                )
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Order cancelled successfully, stock restored and customer notified.'
            );
    }

    /**
     * Show only READY orders for pickup
     */
    public function pickupOrders()
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $orders = Order::with([
            'user',
            'product'
        ])
            ->where('farmer_id', $farmer->id)
            ->where('status', 'ready')
            ->latest()
            ->get();

        return view('farmer.pickup-orders', compact('orders'));
    }

    /**
     * View single pickup order
     */
    public function show($id)
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $order = Order::with([
            'user',
            'product'
        ])
            ->where('id', $id)
            ->where('farmer_id', $farmer->id)
            ->where('status', 'ready')
            ->firstOrFail();

        return view('farmer.order-show', compact('order'));
    }

    /**
     * Mark order as picked up
     *
     * Ready -> Completed
     */
    public function pickedUp($id)
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $order = Order::with('user')
            ->where('id', $id)
            ->where('farmer_id', $farmer->id)
            ->where('status', 'ready')
            ->firstOrFail();

        // Ready -> Completed
        $order->update([
            'status' => 'completed',
        ]);

        // Send email to customer
        if ($order->user) {
            $order->user->notify(
                new OrderStatusNotification(
                    $order,
                    $order->status
                )
            );
        }

        return redirect()
            ->route('farmer.pickup')
            ->with(
                'success',
                'Order marked as picked up successfully and customer notified.'
            );
    }

    /**
     * Completed Orders History
     */
    public function history()
    {
        $farmer = Farmer::where('user_id', auth()->id())
            ->firstOrFail();

        $orders = Order::with([
            'user',
            'product'
        ])
            ->where('farmer_id', $farmer->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('farmer.history', compact('orders'));
    }
}