<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'sku',
        'price',
        'stock',
        'stock_max',
        'category_id',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'stock_max' => 'integer',
    ];

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

        return $query->where('quantity', '<', 10);
    }

    /**
     * Relationship to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
