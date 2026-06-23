<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'brand',
        'sku',
        'price',
        'cost_price',
        'stock',
        'stock_max',
        'image',
        'category_id',
        'status',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock' => 'integer',
        'stock_max' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Filter products by store
     */
    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Filter active products only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all categories
     */
    public static function categories()
    {
        return Category::pluck('name', 'id');
    }

    /**
     * Search products by name or SKU
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%");
    }

    /**
     * Filter by category
     */
    public function scopeCategory(Builder $query, ?int $categoryId): Builder
    {
        if (!$categoryId) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    /**
     * Filter low stock items
     */
    public function scopeLowStock(Builder $query, bool $lowStock = false): Builder
    {
        if (!$lowStock) {
            return $query;
        }

        return $query->where('stock', '<', 10);
    }

    /**
     * Relationship to Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relationship to Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
