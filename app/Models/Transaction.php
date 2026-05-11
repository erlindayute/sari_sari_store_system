<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Transaction extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'order_number',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'total',
        'payment_method',
        'cash_received',
        'change_given',
        'customer_name',
        'note',
        'status',
    ];
    protected $casts = [
        'subtotal'        => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total'           => 'decimal:2',
        'cash_received'   => 'decimal:2',
        'change_given'    => 'decimal:2',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateOrderNumber(int $storeId): string
    {
        $count = static::where('store_id', $storeId)->count() + 1;
        return '#' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
