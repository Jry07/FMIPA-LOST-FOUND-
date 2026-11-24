<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_PENGGUNA = 'pengguna';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_PETUGAS = 'petugas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nim',
        'role',
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

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isPengguna(): bool
    {
        return $this->role === self::ROLE_PENGGUNA;
    }

    public function homeRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_PETUGAS => 'petugas.dashboard',
            default => 'pengguna.dashboard',
        };
    }

    public function accountRoute(): string
    {
        return 'profile.edit';
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function verifiedClaims(): HasMany
    {
        return $this->hasMany(Claim::class, 'verifier_id');
    }

    public function handoversAsOfficer(): HasMany
    {
        return $this->hasMany(HandoverRecord::class, 'officer_id');
    }

    public function handoversAsReceiver(): HasMany
    {
        return $this->hasMany(HandoverRecord::class, 'receiver_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ItemStatusHistory::class);
    }
}
