<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FavouriteNotification extends Notification
{
    use Queueable;

    protected $favourite;

    public function __construct($favourite)
    {
        $this->favourite = $favourite;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'favourite' => $this->favourite
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'favourite' => $this->favourite,
        ]);
    }
}
