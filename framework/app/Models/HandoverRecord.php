<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandoverRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'claim_id',
        'receiver_id',
        'officer_id',
        'handed_over_at',
        'return_note',
    ];

    protected $casts = [
        'handed_over_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}
