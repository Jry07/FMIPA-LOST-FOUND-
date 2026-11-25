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

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * Sesuai KONTRAK.md (title, message, url, type) dan kompatibel dengan view (judul, pesan, jenis).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->judul,
            'message' => $this->pesan,
            'url' => $this->url,
            'type' => $this->jenis,
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'jenis' => $this->jenis,
        ];
    }
}
