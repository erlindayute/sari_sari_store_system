<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class UtangEntry extends Model
{
    protected $fillable = [
        'store_id',
        'transaction_id',
        'customer_name',
        'customer_phone',
        'amount_owed',
        'amount_paid',
        'notes',
        'status',
    ];
    protected $casts = ['amount_owed' => 'decimal:2', 'amount_paid' => 'decimal:2'];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getBalanceAttribute(): float
    {
        return max(0, (float)$this->amount_owed - (float)$this->amount_paid);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::saving(function (UtangEntry $u) {
            $bal = $u->amount_owed - $u->amount_paid;
            if ($bal <= 0)          $u->status = 'paid';
            elseif ($u->amount_paid > 0) $u->status = 'partial';
            else                    $u->status = 'unpaid';
        });
    }

    public function scopeOwed($q)
    {
        return $q->where('status', '!=', 'paid');
    }
}
