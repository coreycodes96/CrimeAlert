<?php

namespace App\Http\Actions\Notifications;

class getNotifications
{
    public function execute()
    {
        return auth()->user()->notifications;
    }
}
