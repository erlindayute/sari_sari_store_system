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

    /**
     * Record activity log
     */
    public static function record(
        ?int $userId,
        string $type,
        string $description,
        ?array $meta = null
    ): self {

        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'description' => $description,
            'meta' => $meta,
        ]);
    }
}
