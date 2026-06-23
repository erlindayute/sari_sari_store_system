<?php

namespace App\Models;

use App\Models\Role;
//use App\Models\PasswordResetToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens;
    use HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'status',

    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //  'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

    // Relationships ------------

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    // Password Reset tokens belonging to this user.
    // public function passwordResets()
    //{
    //   return $this->hasMany(PasswordResetToken::class, 'email', 'email');
    //}

    // Helpers ------------

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user can access a specific feature
     */
    public function can_access(string $feature): bool
    {
        // For now, all authenticated users can access all features
        // This can be expanded with role-based access control
        return true;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the user's full name
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
