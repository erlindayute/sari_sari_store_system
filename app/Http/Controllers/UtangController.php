<?php

namespace App\Http\Controllers;

use App\Models\UtangEntry;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UtangController extends Controller
{
    public function index(Request $request): View
    {
        $store = Auth::user()->store;

        $query = UtangEntry::where('store_id', $store->id)
            ->when($request->input('search'), fn($q, $s) => $q->where('customer_name', 'like', "%$s%"))
            ->when($request->input('status'), fn($q, $s) => $q->where('status', $s))
            ->latest();

        $entries = $query->get();

        $totalOwed = $entries->where('status', '!=', 'paid')->sum(fn($u) => $u->amount_owed - $u->amount_paid);
        $partial   = $entries->where('status', 'partial')->count();
        $fullPaid  = $entries->where('status', 'paid')->count();
        $owedCount = $entries->where('status', '!=', 'paid')->count();

        return view('utang.index', compact('entries', 'totalOwed', 'partial', 'fullPaid', 'owedCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name'  => 'required|string|max:200',
            'customer_phone' => 'nullable|string|max:20',
            'amount_owed'    => 'required|numeric|min:0.01',
            'amount_paid'    => 'nullable|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
        ]);

        $store = Auth::user()->store;
        $entry = UtangEntry::create(array_merge($data, ['store_id' => $store->id, 'amount_paid' => $data['amount_paid'] ?? 0]));
        ActivityLog::record($store->id, 'utang', "Credit entry added · {$entry->customer_name} · ₱{$entry->amount_owed}");

        return back()->with('success', "Credit entry added for {$entry->customer_name}.");
    }

    public function recordPayment(Request $request, UtangEntry $entry): RedirectResponse
    {
        abort_if($entry->store_id !== Auth::user()->store_id, 403);
        $data = $request->validate(['amount' => 'required|numeric|min:0.01']);

        $balance = $entry->amount_owed - $entry->amount_paid;
        if ($data['amount'] > $balance) return back()->withErrors(['amount' => "Amount exceeds balance of ₱{$balance}."]);

        $entry->increment('amount_paid', $data['amount']);
        $entry->save(); // triggers status recalc
        ActivityLog::record($entry->store_id, 'utang', "Payment received · {$entry->customer_name} · ₱{$data['amount']}");

        return back()->with('success', "₱{$data['amount']} payment recorded for {$entry->customer_name}.");
    }

    public function destroy(UtangEntry $entry): RedirectResponse
    {
        abort_if($entry->store_id !== Auth::user()->store_id, 403);
        $name = $entry->customer_name;
        $entry->delete();
        return back()->with('success', "Entry for {$name} deleted.");
    }

    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $store   = Auth::user()->store;
        $entries = UtangEntry::where('store_id', $store->id)->latest()->get();
        return response()->streamDownload(function () use ($entries) {
            $h = fopen('php://output', 'w');
            fputcsv($h, ['Customer', 'Phone', 'Amount Owed', 'Amount Paid', 'Balance', 'Status', 'Notes', 'Date']);
            foreach ($entries as $e) {
                fputcsv($h, [$e->customer_name, $e->customer_phone, $e->amount_owed, $e->amount_paid, $e->balance, $e->status, $e->notes, $e->created_at->format('Y-m-d')]);
            }
            fclose($h);
        }, 'utang_' . now()->format('Y-m-d') . '.csv');
    }
}
