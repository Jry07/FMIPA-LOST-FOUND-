<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;

class NotifikasiService
{
    /**
     * Mengirim notifikasi database standar Laravel kepada pengguna.
     * Payload data: judul, pesan, url, jenis (beserta padanan bahasa Inggris: title, message, type).
     * Dapat dipanggil secara statis maupun via instance service.
     */
    public static function kirim(
        User $penerima,
        string $judul,
        string $pesan,
        ?string $url = null,
        string $jenis = 'info'
    ): void {
        $penerima->notify(new SystemNotification(
            judul: $judul,
            pesan: $pesan,
            url: $url,
            jenis: $jenis
        ));
    }
}
