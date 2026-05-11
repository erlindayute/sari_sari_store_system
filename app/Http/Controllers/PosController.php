<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\StockAdjustment;
use App\Models\UtangEntry;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(): View
    {
        $store    = Auth::user()->store;
        $products = Product::forStore($store->id)->active()->where('status', '!=', 'out')->orderBy('name')->get();
        return view('pos.index', compact('products'));
    }

    public function checkout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|integer|exists:products,id',
            'items.*.qty'      => 'required|integer|min:1',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'payment_method'   => 'required|in:cash,gcash,maya,utang',
            'cash_received'    => 'nullable|numeric|min:0',
            'customer_name'    => 'nullable|string|max:200',
            'note'             => 'nullable|string|max:500',
        ]);

        $store = Auth::user()->store;
        $disc  = (float)($data['discount_percent'] ?? 0);

        // Validate stock availability
        foreach ($data['items'] as $item) {
            $product = Product::findOrFail($item['id']);
            abort_if($product->store_id !== $store->id, 403);
            if ($product->stock < $item['qty']) {
                return back()->withErrors(["items" => "Not enough stock for {$product->name} (only {$product->stock} left)."])->withInput();
            }
        }

        // Build transaction
        $subtotal = 0;
        $lineItems = [];
        foreach ($data['items'] as $item) {
            $product  = Product::find($item['id']);
            $lineTotal = $product->price * $item['qty'];
            $subtotal += $lineTotal;
            $lineItems[] = ['product' => $product, 'qty' => $item['qty'], 'lineTotal' => $lineTotal];
        }

        $discAmt = round($subtotal * ($disc / 100), 2);
        $total   = $subtotal - $discAmt;

        $txn = Transaction::create([
            'store_id'         => $store->id,
            'user_id'          => Auth::id(),
            'order_number'     => Transaction::generateOrderNumber($store->id),
            'subtotal'         => $subtotal,
            'discount_percent' => $disc,
            'discount_amount'  => $discAmt,
            'total'            => $total,
            'payment_method'   => $data['payment_method'],
            'cash_received'    => $data['cash_received'] ?? null,
            'change_given'     => isset($data['cash_received']) ? max(0, $data['cash_received'] - $total) : null,
            'customer_name'    => $data['customer_name'] ?? null,
            'note'             => $data['note'] ?? null,
            'status'           => 'completed',
        ]);

        foreach ($lineItems as $line) {
            $p = $line['product'];
            TransactionItem::create([
                'transaction_id' => $txn->id,
                'product_id'     => $p->id,
                'product_name'   => $p->name,
                'unit_price'     => $p->price,
                'quantity'       => $line['qty'],
                'subtotal'       => $line['lineTotal'],
            ]);

            // Deduct stock
            $before = $p->stock;
            $p->decrement('stock', $line['qty']);
            $p->save(); // triggers status recalculation

            StockAdjustment::create([
                'product_id'      => $p->id,
                'user_id'         => Auth::id(),
                'type'            => 'sale',
                'quantity_before' => $before,
                'quantity_after'  => $p->stock,
                'adjustment'      => -$line['qty'],
                'reason'          => 'POS sale ' . $txn->order_number,
            ]);
        }

        // Create utang entry if payment is on credit
        if ($data['payment_method'] === 'utang') {
            UtangEntry::create([
                'store_id'       => $store->id,
                'transaction_id' => $txn->id,
                'customer_name'  => $data['customer_name'] ?? 'Unknown',
                'amount_owed'    => $total,
                'amount_paid'    => 0,
                'notes'          => collect($lineItems)->pluck('product.name')->join(', '),
            ]);
        }

        ActivityLog::record($store->id, 'sale', "Sale {$txn->order_number} · ₱{$total} · {$data['payment_method']}");

        return redirect()->route('pos.receipt', $txn->id);
    }

    public function receipt(Transaction $txn): View
    {
        abort_if($txn->store_id !== Auth::user()->store_id, 403);
        $txn->load('items', 'cashier');
        return view('pos.receipt', ['txn' => $txn, 'store' => Auth::user()->store]);
    }
}
