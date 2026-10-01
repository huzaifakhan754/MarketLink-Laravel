<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
      public function index()
    {
        $totalVolume = Order::where('status', 'completed')
            ->selectRaw('COALESCE(SUM(price * quantity), 0) as total')
            ->value('total');
        $activePickups = Order::where('status', 'ready')->count();
        $localGrowers = Farmer::where('status', 'active')->count();
        $consumers = User::where('role', 'customer')->count();
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(price * quantity) as total')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'month');
        $chartLabels = [];
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = Carbon::create()
                ->month($month)
                ->format('M');
            $chartData[] = (float) ($monthlyRevenue[$month] ?? 0);
        }
        return view('admin.dashboard', compact(
            'totalVolume',
            'activePickups',
            'localGrowers',
            'consumers',
            'chartLabels',
            'chartData'
        ));
    }    
}