<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $judul,
        public string $pesan,
        public ?string $url = null,
        public string $jenis = 'info'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'url' => $this->url,
            'jenis' => $this->jenis,
        ];
    }
}
