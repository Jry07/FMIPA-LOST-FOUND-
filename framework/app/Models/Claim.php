<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Claim extends Model
{
    use HasFactory;

    public const TYPE_KLAIM = 'klaim';
    public const TYPE_PENEMUAN = 'penemuan';

    public const STATUS_DIAJUKAN = 'diajukan';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'item_id',
        'user_id',
        'type',
        'description',
        'proof',
        'found_location',
        'found_time',
        'storage_location',
        'status',
        'verifier_id',
        'verified_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'found_time' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Kode unik klaim/penemuan, contoh: KLM-019.
     */
    protected function kode(): Attribute
    {
        return Attribute::make(
            get: fn () => 'KLM-' . str_pad((string) $this->id, 3, '0', STR_PAD_LEFT)
        );
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DIAJUKAN => 'Diajukan',
            self::STATUS_DITERIMA => 'Diterima',
            self::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_KLAIM => 'Klaim Kepemilikan',
            self::TYPE_PENEMUAN => 'Pelaporan Penemuan',
            default => ucfirst($this->type),
        };
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->user();
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function handoverRecord(): HasOne
    {
        return $this->hasOne(HandoverRecord::class);
    }
}
