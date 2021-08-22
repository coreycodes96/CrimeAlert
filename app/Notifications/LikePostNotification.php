<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikePostNotification extends Notification
{
    use Queueable;

    protected $like_post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($like_post)
    {
        $this->like_post = $like_post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'like_post' => $this->like_post
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'like_post' => $this->like_post
        ]);
    }
}
