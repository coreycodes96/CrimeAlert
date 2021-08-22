<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostApprovedNotification extends Notification
{
    use Queueable;

    protected $post_approved;

    public function __construct($post_approved)
    {
        $this->post_approved = $post_approved;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_approved' => $this->post_approved
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post_approved' => $this->post_approved
        ]);
    }
}
