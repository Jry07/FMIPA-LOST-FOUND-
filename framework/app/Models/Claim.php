<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'submitter_id',
        'verifier_id',
        'type',
        'ownership_description',
        'finding_description',
        'finding_location',
        'finding_time',
        'storage_location',
        'evidence',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'finding_time' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function getKodeAttribute(): string
    {
        return sprintf('KLM-%03d', $this->id);
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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitter_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function handoverRecord()
    {
        return $this->hasOne(HandoverRecord::class);
    }
}
