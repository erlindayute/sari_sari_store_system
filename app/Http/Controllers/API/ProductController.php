<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Product::query()
            ->search($request->input('search'))
            ->category($request->input('category'))
            ->lowStock((bool) $request->input('low_stock'))
            ->orderBy('name');

        $products = $query->get();

        $stats = [
            'total'    => Product::count(),
            'in_stock' => Product::where('status', 'active')->count(),
            'low'      => Product::where('status', 'low')->count(),
            'out'      => Product::where('status', 'out')->count(),
        ];

        return view('inventory.index', [
            'products'   => $products,
            'stats'      => $stats,
            'categories' => Product::categories(),
            'filters'    => $request->only(['search', 'category', 'low_stock']),
        ]);
    }

    public function create(): View
    {
        return view('inventory.create', [
            'categories' => Product::categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'brand'     => 'nullable|string|max:255',
            'sku'       => 'required|string|max:100|unique:products,sku',
            'category'  => 'required|string|in:' . implode(',', Product::categories()),
            'stock'     => 'required|integer|min:0',
            'stock_max' => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product): View
    {
        return view('inventory.edit', [
            'product'    => $product,
            'categories' => Product::categories(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'brand'     => 'nullable|string|max:255',
            'sku'       => 'required|string|max:100|unique:products,sku,' . $product->id,
            'category'  => 'required|string|in:' . implode(',', Product::categories()),
            'stock'     => 'required|integer|min:0',
            'stock_max' => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Product deleted.');
    }
}
