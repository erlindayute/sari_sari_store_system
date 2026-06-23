<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(): View
    {
        $store = Auth::user()->store;

        $stats = [
            'total'    => Product::forStore($store->id)->active()->count(),
            'in_stock' => Product::forStore($store->id)->active()->where('status', 'active')->count(),
            'low'      => Product::forStore($store->id)->active()->where('status', 'low')->count(),
            'out'      => Product::forStore($store->id)->active()->where('status', 'out')->count(),
        ];

        return view('dashboard.home', ['stats' => $stats]);
    }
}
