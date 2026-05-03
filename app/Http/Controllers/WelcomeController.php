<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $features = [
            [
                'icon' => '📦',
                'label' => 'Inventory',
                'desc' => 'Track every item in real-time'
            ],
            [
                'icon' => '🧾',
                'label' => 'Sales & POS',
                'desc' => 'Fast checkout, clear receipts'
            ],
            [
                'icon' => '📊',
                'label' => 'Reports',
                'desc' => 'Daily, weekly & monthly insights'
            ],
            [
                'icon' => '👥',
                'label' => 'Accounts',
                'desc' => 'Multi-user with role control'
            ],
        ];

        return view('welcome', compact('features'));
    }
}
