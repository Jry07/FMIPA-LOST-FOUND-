<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;

class NotifikasiService
{
    /**
     * Mengirim notifikasi database standar Laravel kepada pengguna.
     * Payload data: judul, pesan, url, jenis.
     */
    public function kirim(
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
