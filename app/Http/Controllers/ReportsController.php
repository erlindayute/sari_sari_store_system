<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $store  = Auth::user()->store;
        $period = $request->input('period', 'today');

        [$start, $end] = $this->getDateRange($period, $request);

        $txns = Transaction::where('store_id', $store->id)
            ->whereBetween('created_at', [$start->startOfDay(), $end->copy()->endOfDay()])
            ->where('status', 'completed');

        $revenue   = (float)$txns->clone()->sum('total');
        $txnCount  = $txns->clone()->count();
        $aov       = $txnCount > 0 ? round($revenue / $txnCount, 2) : 0;
        $costTotal = (float)TransactionItem::whereIn(
            'transaction_id',
            $txns->clone()->pluck('id')
        )->join('products', 'products.id', '=', 'transaction_items.product_id')
            ->selectRaw('SUM(transaction_items.quantity * products.cost_price) as cost')
            ->value('cost');

        $profit = $revenue - $costTotal;

        // Chart: group by day
        $days = $start->diffInDays($end) + 1;
        $chartData = collect();
        for ($i = 0; $i < min($days, 30); $i++) {
            $date = $start->copy()->addDays($i);
            $val  = (float)Transaction::where('store_id', $store->id)
                ->whereDate('created_at', $date)->where('status', 'completed')->sum('total');
            $chartData->push(['label' => $date->format('D d'), 'value' => $val]);
        }

        // Top products
        $topProducts = TransactionItem::whereIn('transaction_id', $txns->clone()->pluck('id'))
            ->selectRaw('product_name, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Category breakdown
        $catBreakdown = TransactionItem::whereIn('transaction_id', $txns->clone()->pluck('id'))
            ->join('products', 'products.id', '=', 'transaction_items.product_id')
            ->selectRaw('products.category, SUM(transaction_items.quantity) as units, SUM(transaction_items.subtotal) as revenue')
            ->groupBy('products.category')
            ->orderByDesc('revenue')
            ->get();

        // Peak hours
        $hourData = Transaction::where('store_id', $store->id)
            ->whereBetween('created_at', [$start->startOfDay(), $end->copy()->endOfDay()])
            ->where('status', 'completed')
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour');

        $hours = collect(range(0, 23))->map(fn($h) => ['hour' => $h, 'count' => $hourData[$h] ?? 0]);

        return view('reports.index', compact(
            'revenue',
            'txnCount',
            'aov',
            'profit',
            'chartData',
            'topProducts',
            'catBreakdown',
            'hours',
            'period'
        ));
    }

    public function exportCsv(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $store  = Auth::user()->store;
        $period = $request->input('period', 'today');
        [$start, $end] = $this->getDateRange($period, $request);

        $txns = Transaction::where('store_id', $store->id)
            ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
            ->where('status', 'completed')
            ->with('items')
            ->get();

        return response()->streamDownload(function () use ($txns) {
            $h = fopen('php://output', 'w');
            fputcsv($h, ['Order #', 'Date', 'Items', 'Subtotal', 'Discount', 'Total', 'Payment', 'Cashier']);
            foreach ($txns as $t) {
                $items = $t->items->map(fn($i) => "{$i->product_name} ×{$i->quantity}")->join('; ');
                fputcsv($h, [$t->order_number, $t->created_at->format('Y-m-d H:i'), $items, $t->subtotal, $t->discount_amount, $t->total, $t->payment_method, $t->cashier?->name ?? '—']);
            }
            fclose($h);
        }, 'sales_' . now()->format('Y-m-d') . '.csv');
    }

    private function getDateRange(string $period, Request $request): array
    {
        return match ($period) {
            'week'   => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'month'  => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'custom' => [
                Carbon::parse($request->input('from', now()->subDays(6))),
                Carbon::parse($request->input('to',   now())),
            ],
            default  => [Carbon::today(), Carbon::today()],
        };
    }
}
