<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemStatusHistory;
use App\Models\User;

class StatusHistoryService
{
    public static function catatAwal(Item $item, User $user, ?string $catatan = 'Laporan dibuat'): ItemStatusHistory
    {
        return ItemStatusHistory::create([
            'item_id' => $item->id,
            'changed_by' => $user->id,
            'previous_status' => null,
            'new_status' => $item->status,
            'note' => $catatan,
        ]);
    }

    public static function ubah(Item $item, string $statusBaru, User $user, ?string $catatan = null): ItemStatusHistory
    {
        $statusLama = $item->status;
        $item->status = $statusBaru;
        $item->save();

        return ItemStatusHistory::create([
            'item_id' => $item->id,
            'changed_by' => $user->id,
            'previous_status' => $statusLama,
            'new_status' => $statusBaru,
            'note' => $catatan,
        ]);
    }

    public static function catatPerubahan(Item $item, User $user, ?string $catatan = null): ItemStatusHistory
    {
        return ItemStatusHistory::create([
            'item_id' => $item->id,
            'changed_by' => $user->id,
            'previous_status' => $item->status,
            'new_status' => $item->status,
            'note' => $catatan,
        ]);
    }
}
