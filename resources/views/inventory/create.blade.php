<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - SariSari Store System</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Instrument Serif', Georgia, serif;
            font-size: 2rem;
            color: var(--brown);
            margin-bottom: 8px;
        }

        .form-card {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.12);
            border-radius: 12px;
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 8px;
            font-size: 14px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(249, 115, 22, 0.2);
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn-submit {
            padding: 12px 24px;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--orange-deep);
        }

        .btn-cancel {
            padding: 12px 24px;
            background: var(--orange-pale);
            color: var(--orange-deep);
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-cancel:hover {
            background: var(--orange-light);
        }

        .error-message {
            color: #991b1b;
            font-size: 12px;
            margin-top: 4px;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
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
                <a href="{{ route('inventory.index') }}" class="btn-ghost">Back to Inventory</a>
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
            <h1>Add New Product</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('inventory.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="sku">SKU *</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required>
                        @error('sku')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" required>
                        @error('quantity')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                        @error('price')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="low" {{ old('status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out" {{ old('status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('status')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Add Product</button>
                    <a href="{{ route('inventory.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
