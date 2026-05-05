@extends('layouts.app')
@section('title', 'Add Product')
@include('inventory.partials.form-styles')

@section('content')
<div style="margin-bottom:1.25rem">
    <a href="{{ route('inventory.index') }}" style="font-size:13px;color:var(--text-2);text-decoration:none;display:inline-flex;align-items:center;gap:5px">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Back to inventory
    </a>
</div>

<div class="form-card">
    <div class="form-title">Add product</div>

    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group full">
                <label for="name">Product name</label>
                <input id="name" name="name" type="text" class="form-input @error('name') error @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Skyflakes Crackers" required>
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="brand">Brand</label>
                <input id="brand" name="brand" type="text" class="form-input @error('brand') error @enderror"
                       value="{{ old('brand') }}" placeholder="e.g. M.Y. San">
                @error('brand')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="sku">SKU</label>
                <input id="sku" name="sku" type="text" class="form-input @error('sku') error @enderror"
                       value="{{ old('sku') }}" placeholder="e.g. SKU-001" required>
                @error('sku')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-input @error('category') error @enderror" required>
                    <option value="">Select category…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="price">Price (₱)</label>
                <input id="price" name="price" type="number" step="0.01" min="0"
                       class="form-input @error('price') error @enderror"
                       value="{{ old('price') }}" placeholder="0.00" required>
                @error('price')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="stock">Current stock</label>
                <input id="stock" name="stock" type="number" min="0"
                       class="form-input @error('stock') error @enderror"
                       value="{{ old('stock', 0) }}" required>
                @error('stock')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="stock_max">Max stock</label>
                <input id="stock_max" name="stock_max" type="number" min="1"
                       class="form-input @error('stock_max') error @enderror"
                       value="{{ old('stock_max', 100) }}" required>
                @error('stock_max')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save product</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
