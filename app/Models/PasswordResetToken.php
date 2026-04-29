<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    // Laravel's default table has no auto-incrementing ID, primary key is 'email'
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

    // No updated_at column in the default schema
    const UPDATED_AT = null;
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // HELPERS -----------------

    public function isExpired(int $minutes = 60): bool
    {
        return $this->created_at->addMinutes($minutes)->isPast();
    }
}
