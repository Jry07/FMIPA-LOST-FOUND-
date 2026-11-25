<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HandoverRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'claim_id',
        'officer_id',
        'receiver_id',
        'notes',
        'return_note',
        'handover_date',
        'handed_over_at',
    ];

    protected function casts(): array
    {
        return [
            'handover_date' => 'datetime',
        ];
    }

    /**
     * Alias handed_over_at <=> handover_date
     */
    protected function handedOverAt(): Attribute
    {
        return Attribute::make(
            get: fn () => isset($this->attributes['handover_date']) ? $this->asDateTime($this->attributes['handover_date']) : null,
            set: fn ($value) => ['handover_date' => $value]
        );
    }

    /**
     * Alias return_note <=> notes
     */
    protected function returnNote(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['notes'] ?? null,
            set: fn ($value) => ['notes' => $value]
        );
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
