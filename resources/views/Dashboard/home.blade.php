@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Welcome Section -->
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 0.5rem;">Welcome back, {{ Auth::user()->first_name }}! 👋</h2>
            <p style="color: var(--text2); font-size: 14px;">Here's your store dashboard overview for today</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('inventory.index') }}" class="btn btn-primary">
                📦 Manage Inventory
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #e1f5ee; border: 1px solid #80cbc4; color: #0f6e56; padding: 1rem; border-radius: 8px; font-size: 14px; margin-bottom: 1rem;">
        ✓ {{ session('success') }}
    </div>
    @endif
</div>

<!-- KPI Section -->
<div class="kpi-grid" style="margin-bottom: 2rem;">
    <div class="kpi kpi-g">
        <div class="kpi-lbl">Total Products</div>
        <div style="font-size: 28px; font-weight: 700; margin: 0.5rem 0;">{{ $stats['total'] ?? 0 }}</div>
        <div style="font-size: 12px; color: var(--text3);">
            <span style="color: var(--green);">{{ $stats['in_stock'] ?? 0 }}</span> in stock
        </div>
        <div class="kpi-bar"></div>
        <div class="kpi-ico">📦</div>
    </div>

    <div class="kpi kpi-g">
        <div class="kpi-lbl">In Stock</div>
        <div style="font-size: 28px; font-weight: 700; margin: 0.5rem 0;">{{ $stats['in_stock'] ?? 0 }}</div>
        <div style="font-size: 12px; color: var(--text3);">
            Ready to sell
        </div>
        <div class="kpi-bar"></div>
        <div class="kpi-ico">✓</div>
    </div>

    <div class="kpi kpi-a">
        <div class="kpi-lbl">Low Stock</div>
        <div style="font-size: 28px; font-weight: 700; margin: 0.5rem 0;">{{ $stats['low'] ?? 0 }}</div>
        <div style="font-size: 12px; color: var(--text3);">
            <a href="{{ route('inventory.index', ['low_stock' => 1]) }}" style="color: var(--amber-txt); text-decoration: none; font-weight: 500;">View details →</a>
        </div>
        <div class="kpi-bar"></div>
        <div class="kpi-ico">⚠</div>
    </div>

    <div class="kpi kpi-r">
        <div class="kpi-lbl">Out of Stock</div>
        <div style="font-size: 28px; font-weight: 700; margin: 0.5rem 0;">{{ $stats['out'] ?? 0 }}</div>
        <div style="font-size: 12px; color: var(--text3);">
            Need to reorder
        </div>
        <div class="kpi-bar"></div>
        <div class="kpi-ico">✕</div>
    </div>
</div>

<!-- Quick Actions Section -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <!-- Inventory Actions -->
    <div class="card">
        <div class="card-hd">
            <div class="card-title">📊 Inventory Management</div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('inventory.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">View All Products</span>
                    <span style="color: var(--text3); font-size: 16px;">→</span>
                </a>
                <a href="{{ route('inventory.create') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">Add New Product</span>
                    <span style="color: var(--text3); font-size: 16px;">+</span>
                </a>
                <a href="{{ route('inventory.index', ['low_stock' => 1]) }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">Low Stock Items</span>
                    <span class="pill" style="background: var(--amber-bg); color: var(--amber-txt); margin: 0;">{{ $stats['low'] ?? 0 }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Sales & POS -->
    <div class="card">
        <div class="card-hd">
            <div class="card-title">🧾 Sales & Transactions</div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="/sales" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">Process Sale (POS)</span>
                    <span style="color: var(--text3); font-size: 16px;">→</span>
                </a>
                <a href="/transactions" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">Transaction History</span>
                    <span style="color: var(--text3); font-size: 16px;">→</span>
                </a>
                <a href="/reports" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--paper); border-radius: 8px; text-decoration: none; color: var(--ink); transition: all 0.2s; border: 1px solid transparent;">
                    <span style="font-size: 14px; font-weight: 500;">Sales Reports</span>
                    <span style="color: var(--text3); font-size: 16px;">📊</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Information Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
    <!-- Store Info -->
    <div class="card">
        <div class="card-hd">
            <div class="card-title">🏪 Store Information</div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Store Name</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">{{ Auth::user()->store->store_name ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Location</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">
                        {{ Auth::user()->store->city ?? 'N/A' }}, {{ Auth::user()->store->province ?? 'N/A' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Plan</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">
                        <span style="text-transform: capitalize;">{{ Auth::user()->store->plan ?? 'Standard' }}</span>
                        @if(Auth::user()->store->isOnTrial())
                        <span class="pill" style="background: var(--blue-bg); color: var(--blue-txt); margin-left: 0.5rem;">Trial Active</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Account -->
    <div class="card">
        <div class="card-hd">
            <div class="card-title">👤 Your Account</div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Name</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Email</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text3); margin-bottom: 0.3rem;">Role</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">
                        <span style="text-transform: capitalize;">{{ Auth::user()->role ?? 'User' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
    
    @media (max-width: 768px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

@endsection
