<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatusHistoryService
{
    /**
     * Mencatat histori awal saat laporan pertama kali dibuat (status: menunggu).
     * Dapat dipanggil secara statis maupun via instance service.
     */
    public static function catatAwal(Item $item, ?User $user = null): ItemStatusHistory
    {
        return DB::transaction(function () use ($item, $user) {
            return ItemStatusHistory::create([
                'item_id' => $item->id,
                'user_id' => $user?->id ?? $item->user_id,
                'previous_status' => null,
                'new_status' => $item->status ?? Item::STATUS_MENUNGGU,
                'notes' => 'Laporan dibuat.',
            ]);
        });
    }

    /**
     * Mengubah status item sekaligus mencatat riwayat perubahannya di dalam transaksi DB.
     * Dapat dipanggil secara statis maupun via instance service.
     */
    public static function ubah(Item $item, string $statusBaru, ?User $user = null, ?string $catatan = null): ItemStatusHistory
    {
        return DB::transaction(function () use ($item, $statusBaru, $user, $catatan) {
            $statusLama = $item->status;

            $item->update([
                'status' => $statusBaru,
            ]);

            return static::catatPerubahan($item, $statusLama, $statusBaru, $user, $catatan);
        });
    }

    /**
     * Mencatat riwayat perubahan status item ke tabel item_status_histories.
     * Dapat dipanggil secara statis maupun via instance service.
     */
    public static function catatPerubahan(
        Item $item,
        ?string $statusLama,
        string $statusBaru,
        ?User $user = null,
        ?string $catatan = null
    ): ItemStatusHistory {
        return ItemStatusHistory::create([
            'item_id' => $item->id,
            'user_id' => $user?->id,
            'previous_status' => $statusLama,
            'new_status' => $statusBaru,
            'notes' => $catatan,
        ]);
    }
}
