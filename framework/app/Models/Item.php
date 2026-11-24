<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    public const TYPE_LOST = 'lost';
    public const TYPE_FOUND = 'found';

    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DIPUBLIKASIKAN = 'dipublikasikan';
    public const STATUS_DITOLAK = 'ditolak';
    public const STATUS_DIBATALKAN = 'dibatalkan';
    public const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'type',
        'description',
        'photo',
        'location',
        'incident_date',
        'incident_time',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
        ];
    }

    /**
     * Kode unik laporan, contoh: LST-042 atau FND-026.
     */
    protected function kode(): Attribute
    {
        return Attribute::make(
            get: function () {
                $prefix = $this->type === self::TYPE_LOST ? 'LST-' : 'FND-';
                return $prefix . str_pad((string) $this->id, 3, '0', STR_PAD_LEFT);
            }
        );
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu Verifikasi',
            self::STATUS_DIPUBLIKASIKAN => 'Dipublikasikan',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            self::STATUS_SELESAI => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_LOST => 'Barang Hilang (Lost)',
            self::TYPE_FOUND => 'Barang Ditemukan (Found)',
            default => ucfirst($this->type),
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ItemStatusHistory::class);
    }

    public function handoverRecord(): HasOne
    {
        return $this->hasOne(HandoverRecord::class);
    }
}
