<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\UtangEntry;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(): View
    {
        $store = Auth::user()->store;
        $today = Carbon::today();

        // KPIs
        $todayRevenue = Transaction::where('store_id', $store->id)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        $todayTxns = Transaction::where('store_id', $store->id)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $yesterdayRevenue = Transaction::where('store_id', $store->id)
            ->whereDate('created_at', $today->copy()->subDay())
            ->where('status', 'completed')
            ->sum('total');

        $lowItems  = Product::forStore($store->id)->whereIn('status', ['low', 'out'])->count();
        $outItems  = Product::forStore($store->id)->where('status', 'out')->count();

        $utangOwed = UtangEntry::where('store_id', $store->id)
            ->where('status', '!=', 'paid')
            ->selectRaw('SUM(amount_owed - amount_paid) as total, COUNT(*) as count')
            ->first();

        // 7-day chart
        $salesChart = collect(range(6, 0))->map(function ($daysAgo) use ($store) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'label' => $date->format('D'),
                'value' => (float) Transaction::where('store_id', $store->id)
                    ->whereDate('created_at', $date)
                    ->where('status', 'completed')
                    ->sum('total'),
            ];
        });

        // Low stock items
        $lowStockItems = Product::forStore($store->id)
            ->whereIn('status', ['low', 'out'])
            ->orderBy('stock')
            ->limit(6)
            ->get();

        // Recent transactions
        $recentTxns = Transaction::where('store_id', $store->id)
            ->with('cashier')
            ->latest()
            ->limit(8)
            ->get();

        // Activity log
        $activity = ActivityLog::where('store_id', $store->id)
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'store',
            'todayRevenue',
            'todayTxns',
            'yesterdayRevenue',
            'lowItems',
            'outItems',
            'utangOwed',
            'salesChart',
            'lowStockItems',
            'recentTxns',
            'activity'
        ));
    }
}
