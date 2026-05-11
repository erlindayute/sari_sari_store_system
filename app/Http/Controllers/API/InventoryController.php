<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\StreamedResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $store = Auth::user()->store;

        $query = Product::forStore($store->id)
            ->active()
            ->search($request->input('search'))
            ->category($request->input('category'))
            ->lowStock($request->boolean('low_stock'));

        // Sorting
        match ($request->input('sort', 'name')) {
            'stock_asc'  => $query->orderBy('stock'),
            'stock_desc' => $query->orderByDesc('stock'),
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->orderBy('name'),
        };

        $products = $query->get();

        $stats = [
            'total'    => Product::forStore($store->id)->active()->count(),
            'in_stock' => Product::forStore($store->id)->active()->where('status', 'active')->count(),
            'low'      => Product::forStore($store->id)->active()->where('status', 'low')->count(),
            'out'      => Product::forStore($store->id)->active()->where('status', 'out')->count(),
        ];

        return view('inventory.index', [
            'products'   => $products,
            'stats'      => $stats,
            'categories' => Product::categories(),
            'filters'    => $request->only(['search', 'category', 'low_stock', 'sort']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'brand'      => 'nullable|string|max:255',
            'sku'        => 'nullable|string|max:100',
            'category'   => 'required|in:' . implode(',', Product::categories()->toArray()),
            'price'      => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'stock_max'  => 'required|integer|min:1',
        ]);

        $store = Auth::user()->store;

        // Unique SKU per store
        if (!empty($data['sku'])) {
            $exists = Product::where('store_id', $store->id)->where('sku', $data['sku'])->exists();
            if ($exists) return back()->withErrors(['sku' => "SKU '{$data['sku']}' is already used."])->withInput();
        }

        $product = Product::create(array_merge($data, ['store_id' => $store->id]));
        ActivityLog::record($store->id, 'stock', "Product added: {$product->name}");

        return redirect()->route('inventory.index')->with('success', "{$product->name} added to inventory.");
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'brand'      => 'nullable|string|max:255',
            'sku'        => 'nullable|string|max:100',
            'category'   => 'required|in:' . implode(',', Product::categories()->toArray()),
            'price'      => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'stock_max'  => 'required|integer|min:1',
        ]);

        $store = Auth::user()->store;
        if (!empty($data['sku'])) {
            $exists = Product::where('store_id', $store->id)
                ->where('sku', $data['sku'])
                ->where('id', '!=', $product->id)
                ->exists();
            if ($exists) return back()->withErrors(['sku' => "SKU is already in use."])->withInput();
        }

        $product->update($data);
        ActivityLog::record($store->id, 'edit', "Product updated: {$product->name}");

        return redirect()->route('inventory.index')->with('success', "{$product->name} updated.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);
        $store = Auth::user()->store;
        $name = $product->name;
        $product->update(['is_active' => false]); // soft delete
        ActivityLog::record($store->id, 'edit', "Product removed: {$name}");
        return redirect()->route('inventory.index')->with('success', "{$name} removed.");
    }

    public function adjustStock(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'type'   => 'required|in:add,remove,set',
            'qty'    => 'required|integer|min:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $before = $product->stock;
        $after  = match ($data['type']) {
            'add'    => $before + $data['qty'],
            'remove' => max(0, $before - $data['qty']),
            'set'    => $data['qty'],
        };

        StockAdjustment::create([
            'product_id'      => $product->id,
            'user_id'         => Auth::id(),
            'type'            => $data['type'],
            'quantity_before' => $before,
            'quantity_after'  => $after,
            'adjustment'      => $after - $before,
            'reason'          => $data['reason'],
        ]);

        $product->update(['stock' => $after]);
        $store = Auth::user()->store;
        ActivityLog::record($store->id, 'stock', "Stock adjusted: {$product->name} · {$before} → {$after} ({$data['reason']})");

        return redirect()->route('inventory.index')->with('success', "Stock updated for {$product->name}.");
    }

    // public function exportCsv(): StreamedResponse
    //{
    //  $store    = Auth::user()->store;
    // $products = Product::forStore($store->id)->active()->orderBy('name')->get();

    //return response()->streamDownload(function () use ($products) {
    //  $handle = fopen('php://output', 'w');
    //fputcsv($handle, ['Name', 'Brand', 'SKU', 'Category', 'Stock', 'Max Stock', 'Price', 'Cost Price', 'Status']);
    //foreach ($products as $p) {
    //  fputcsv($handle, [$p->name, $p->brand, $p->sku, $p->category, $p->stock, $p->stock_max, $p->price, $p->cost_price, $p->status]);
    // }
    //fclose($handle);
    //}, 'inventory_' . now()->format('Y-m-d') . '.csv');
    //}

    private function authorizeProduct(Product $product): void
    {
        abort_if($product->store_id !== Auth::user()->store_id, 403);
    }
}
