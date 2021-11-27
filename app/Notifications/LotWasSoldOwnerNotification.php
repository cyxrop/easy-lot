<?php

namespace App\Notifications;

use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LotWasSoldOwnerNotification extends Notification
{
    use Queueable;

    private Lot $lot;

    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("The lot {$this->lot->name} was successfully purchased.");
    }

    public function toArray($notifiable)
    {
        return [
            'lot_id' => $this->lot->id,
        ];
    }
}
