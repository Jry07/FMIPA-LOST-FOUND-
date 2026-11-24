<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_PENGGUNA = 'pengguna';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_PETUGAS = 'petugas';

    protected $fillable = [
        'name',
        'email',
        'nim',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function homeRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'verifikasi.reports.index',
            self::ROLE_PETUGAS => 'handovers.index',
            default => 'dashboard',
        };
    }

    public function accountRoute(): string
    {
        return 'profile';
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

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'submitter_id');
    }

    public function verifiedClaims()
    {
        return $this->hasMany(Claim::class, 'verifier_id');
    }
}
