<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/* The `class User extends Authenticatable implements FilamentUser` statement in the PHP code snippet
is defining a class named `User` that extends `Authenticatable` class and implements the
`FilamentUser` interface. */
/* The `class User extends Authenticatable implements FilamentUser` statement in the PHP code snippet
is defining a class named `User` that extends the `Authenticatable` class and implements the
`FilamentUser` interface. This means that the `User` class inherits the properties and methods of
the `Authenticatable` class and also must implement the methods defined in the `FilamentUser`
interface. This allows the `User` class to have authentication-related functionality provided by
`Authenticatable` and any additional behavior specified by the `FilamentUser` interface. */
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasFactory, Notifiable, SoftDeletes, HasUuids;
public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'role',
        'email',
        'password',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Required by FilamentUser interface
     * Determine if the user can access the Filament admin panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }


    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Get the user's full name
     */
   public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}") ?: '';
    }
    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->full_name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::upper(Str::substr($word, 0, 1)))
            ->implode('');
    }
    public function getNameAttribute(): string
    {
        return $this->getFullNameAttribute()
            ?: $this->email
            ?: 'User-' . Str::substr((string) $this->id, 0, 8);
    }
}
