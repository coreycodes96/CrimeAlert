<?php

namespace App\Http\Actions\Notifications;

class markNotificationsAsRead
{
    //Mark all of the notifications
    public function execute()
    {
        //Marking all the users notifications as read
        return auth()->user()->unreadNotifications->markAsRead();
    }
}
