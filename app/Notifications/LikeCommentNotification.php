<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikeCommentNotification extends Notification
{
    use Queueable;

    protected $like_comment;

    public function __construct($like_comment)
    {
        $this->like_comment = $like_comment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'like_comment' => $this->like_comment
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'like_comment' => $this->like_comment
        ]);
    }
}
