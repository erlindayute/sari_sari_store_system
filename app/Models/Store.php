<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    protected $fillable = [
        'name',
        'code',
        'city',
        'province',
        'currency',
        'timezone',
        'low_stock_threshold',
        'plan',
        'trial_ends_at',
        'owner_id',
    ];

    protected $casts = ['trial_ends_at' => 'datetime'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public function utangEntries(): HasMany
    {
        return $this->hasMany(UtangEntry::class);
    }
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }
}
