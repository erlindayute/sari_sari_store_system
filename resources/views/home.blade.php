<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SariSari Store System</title>
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

        .welcome-card {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.12);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.07);
            margin-bottom: 40px;
            animation: slideUp 0.5s ease;
        }

        .welcome-header {
            margin-bottom: 24px;
        }

        .welcome-header h1 {
            font-family: 'Instrument Serif', Georgia, serif;
            font-size: 2rem;
            color: var(--brown);
            margin-bottom: 12px;
        }

        .welcome-header p {
            font-size: 1.05rem;
            color: var(--stone);
        }

        .success-message {
            background: #dcfce7;
            border: 1px solid #22c55e;
            border-radius: 12px;
            padding: 16px;
            color: #15803d;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .success-message::before {
            content: '✓';
            font-size: 1.2rem;
            font-weight: bold;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.12);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            cursor: pointer;
            animation: slideUp 0.5s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(249, 115, 22, 0.12);
            border-color: rgba(249, 115, 22, 0.3);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 13px;
            color: var(--stone);
            line-height: 1.5;
        }

        .card-action {
            margin-top: 16px;
        }

        .card-action a {
            display: inline-block;
            padding: 8px 16px;
            background: var(--orange-pale);
            color: var(--orange-deep);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s;
        }

        .card-action a:hover {
            background: var(--orange-light);
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
            .welcome-header h1 {
                font-size: 1.5rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
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
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-solid">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="welcome-card">
            <div class="welcome-header">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Here's your store dashboard overview</p>
            </div>

            @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
            @endif
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">📦</div>
                <div class="card-title">Inventory</div>
                <div class="card-desc">Track every item in real-time</div>
                <div class="card-action">
                    <a href="{{ route('inventory.index') }}">Manage</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">🧾</div>
                <div class="card-title">Sales & POS</div>
                <div class="card-desc">Fast checkout, clear receipts</div>
                <div class="card-action">
                  <!--  <a href="">Process</a> -->
                    <a href="/sales">Process</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">📊</div>
                <div class="card-title">Reports</div>
                <div class="card-desc">Daily, weekly & monthly insights</div>
                <div class="card-action">
                  <!--  <a href="">View</a> -->
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">👥</div>
                <div class="card-title">Accounts</div>
                <div class="card-desc">Multi-user with role control</div>
                <div class="card-action">
                  <!--  <a href="">Configure</a> -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
