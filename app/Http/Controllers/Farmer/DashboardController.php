<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Farmer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
   public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Logged-in Farmer
        |--------------------------------------------------------------------------
        */

        $farmer = Farmer::where('user_id', Auth::id())->firstOrFail();

        $farmerId = $farmer->id;


        /*
        |--------------------------------------------------------------------------
        | Total Orders
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::where('farmer_id', $farmerId)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Orders
        |--------------------------------------------------------------------------
        |
        | Pending + Ready orders ko pending activity mein count kar rahe hain.
        |
        */

        $pendingOrders = Order::where('farmer_id', $farmerId)
            ->whereIn('status', ['pending', 'ready'])
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Products
        |--------------------------------------------------------------------------
        */

        $totalProducts = $farmer->products()->count();


        /*
        |--------------------------------------------------------------------------
        | Total Revenue
        |--------------------------------------------------------------------------
        |
        | Completed orders ki total earning
        |
        */

        $totalRevenue = Order::where('farmer_id', $farmerId)
            ->where('status', 'completed')
            ->selectRaw('COALESCE(SUM(price * quantity), 0) as total')
            ->value('total');


        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue
        |--------------------------------------------------------------------------
        |
        | Current year ke completed orders
        |
        */

        $monthlyRevenue = Order::where('farmer_id', $farmerId)
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(price * quantity) as total')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'month');


        /*
        |--------------------------------------------------------------------------
        | Chart Labels + Data
        |--------------------------------------------------------------------------
        */

        $chartLabels = [];
        $chartData = [];

        for ($month = 1; $month <= 12; $month++) {

            $chartLabels[] = Carbon::create()
                ->month($month)
                ->format('M');

            $chartData[] = (float) ($monthlyRevenue[$month] ?? 0);
        }


        /*
        |--------------------------------------------------------------------------
        | Average Rating
        |--------------------------------------------------------------------------
        */

        $averageRating = Feedback::where('farmer_id', $farmerId)
            ->avg('rating');

        $averageRating = $averageRating
            ? round($averageRating, 1)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('farmer.dashboard', compact(
            'farmer',
            'totalOrders',
            'pendingOrders',
            'totalProducts',
            'totalRevenue',
            'averageRating',
            'chartLabels',
            'chartData'
        ));
    }

    public function feedbacks(): View
    {
        // Logged-in user ki farmer profile find karo
        $farmer = Farmer::where('user_id', Auth::id())->first();

        // Agar farmer profile nahi mili
        if (!$farmer) {
            return view('farmer.feedbacks', [
                'feedbacks' => collect(),
                'totalFeedbacks' => 0,
                'averageRating' => 0,
            ]);
        }

        // Farmer table ka actual ID use hoga
        // Example: logged-in user = 6
        // farmer.id = 1
        // feedbacks.farmer_id = 1
        $feedbacks = Feedback::with([
            'customer',
            'order.product',
        ])
        ->where('farmer_id', $farmer->id)
        ->latest()
        ->get();

        $totalFeedbacks = $feedbacks->count();

        $averageRating = $totalFeedbacks > 0
            ? round($feedbacks->avg('rating'), 1)
            : 0;

        return view('farmer.feedbacks', compact(
            'feedbacks',
            'totalFeedbacks',
            'averageRating'
        ));
    }
}