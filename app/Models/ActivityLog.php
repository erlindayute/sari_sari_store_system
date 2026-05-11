<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    public $updatedAt = false;
    protected $fillable = ['store_id', 'user_id', 'type', 'description', 'meta'];
    protected $casts    = ['meta' => 'array'];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(int $storeId, string $type, string $desc, ?int $userId = null, array $meta = []): void
    {
        static::create([
            'store_id'   => $storeId,
            'user_id'    => $userId ?? Auth::id(),
            'type'       => $type,
            'description' => $desc,
            'meta'       => $meta ?: null,
        ]);
    }
}
