<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;

class NotifikasiService
{
    public static function kirim(User $penerima, string $judul, string $pesan, ?string $url = null, string $jenis = 'info'): void
    {
        $penerima->notify(new SystemNotification($judul, $pesan, $url, $jenis));
    }
}
