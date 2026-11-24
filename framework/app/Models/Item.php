<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'incident_date' => 'date',
    ];

    public function getKodeAttribute(): string
    {
        $prefix = $this->type === self::TYPE_LOST ? 'LST' : 'FND';
        return sprintf('%s-%03d', $prefix, $this->id);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function histories()
    {
        return $this->hasMany(ItemStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function handoverRecord()
    {
        return $this->hasOne(HandoverRecord::class);
    }
}
