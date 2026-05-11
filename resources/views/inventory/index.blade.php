<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - SariSari Store System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;1,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --orange: #f97316;
            --orange-deep: #ea580c;
            --orange-light: #fff7ed;
            --orange-pale: #ffedd5;
            --brown: #431407;
            --cream: #fffbf5;
            --stone: #78716c;
            --stone-light: #f5f5f4;
        }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'Nunito', sans-serif;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 251, 245, 0.88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(249, 115, 22, 0.12);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--orange), var(--orange-deep));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .logo-primary {
            font-family: 'Instrument Serif', Georgia, serif;
            font-size: 1.2rem;
            color: var(--brown);
        }

        .logo-secondary {
            font-size: 10px;
            font-weight: 700;
            color: var(--stone);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-ghost {
            padding: 8px 18px;
            border-radius: 99px;
            font-size: 14px;
            font-weight: 700;
            color: var(--stone);
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .btn-ghost:hover {
            color: var(--orange-deep);
            background: var(--orange-pale);
        }

        .btn-solid {
            padding: 8px 20px;
            border-radius: 99px;
            background: var(--orange);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(249, 115, 22, 0.3);
            transition: background 0.2s, transform 0.1s;
            border: none;
            cursor: pointer;
        }

        .btn-solid:hover {
            background: var(--orange-deep);
            transform: translateY(-1px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Instrument Serif', Georgia, serif;
            font-size: 2rem;
            color: var(--brown);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.12);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--orange);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--stone);
        }

        .table-section {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.12);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            padding: 24px;
            border-bottom: 1px solid rgba(249, 115, 22, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header h2 {
            font-size: 1.1rem;
            color: var(--brown);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--stone-light);
        }

        th {
            padding: 16px 24px;
            text-align: left;
            font-weight: 700;
            color: var(--brown);
            font-size: 13px;
        }

        td {
            padding: 16px 24px;
            border-top: 1px solid rgba(249, 115, 22, 0.12);
            font-size: 14px;
            color: var(--stone);
        }

        tr:hover {
            background: var(--orange-pale);
        }

        .no-data {
            padding: 40px 24px;
            text-align: center;
            color: var(--stone);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .page-header {
                flex-direction: column;
                gap: 20px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <div class="nav-logo">
                <div class="logo-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M4 11 L14 3 L24 11" stroke="white" stroke-width="2" stroke-linejoin="round" fill="none"/>
                        <rect x="6" y="11" width="16" height="13" rx="1.5" fill="white" fill-opacity="0.25" stroke="white" stroke-width="1.5"/>
                        <rect x="11" y="17" width="6" height="7" rx="1" fill="white"/>
                        <rect x="7.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
                        <rect x="16.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <span class="logo-primary">SariSari</span>
                    <span class="logo-secondary">Store System</span>
                </div>
            </div>
            <div class="nav-actions">
                <a href="{{ route('home') }}" class="btn-ghost">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-solid">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="page-header">
            <h1>Inventory Management</h1>
            <a href="{{ route('inventory.create') }}" class="btn-solid">+ Add Product</a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['in_stock'] }}</div>
                <div class="stat-label">In Stock</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['low'] }}</div>
                <div class="stat-label">Low Stock</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['out'] }}</div>
                <div class="stat-label">Out of Stock</div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-section">
            <div class="table-header">
                <h2>Products</h2>
            </div>

            @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700;
                                @if($product->status === 'active') background: #dcfce7; color: #15803d;
                                @elseif($product->status === 'low') background: #fef3c7; color: #92400e;
                                @else background: #fee2e2; color: #991b1b;
                                @endif
                            ">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('inventory.edit', $product) }}" style="color: var(--orange); text-decoration: none; font-weight: 700; margin-right: 10px;">Edit</a>
                            <form method="POST" action="{{ route('inventory.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #991b1b; background: none; border: none; font-weight: 700; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data">
                <p>No products found. <a href="{{ route('inventory.create') }}" style="color: var(--orange); text-decoration: none; font-weight: 700;">Add one now</a></p>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
