<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusAspirasiUpdated extends Notification
{
    use Queueable;

    protected $aspirasi;
    protected $oldStatus;
    protected $newStatus;

    public function __construct($aspirasi, $oldStatus, $newStatus)
    {
        $this->aspirasi = $aspirasi;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'id_aspirasi' => $this->aspirasi->id_aspirasi,
            'message' => "Status aspirasi kamu telah diperbarui dari '{$this->oldStatus}' menjadi '{$this->newStatus}'.",
            'status_baru' => $this->newStatus,
            'feedback' => $this->aspirasi->feedback,
        ];
    }
}
