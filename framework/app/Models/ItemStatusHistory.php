<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'changed_by',
        'previous_status',
        'new_status',
        'note',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
