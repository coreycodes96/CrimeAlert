<?php

namespace App\Http\Actions\Notifications;

class Index
{
    //Returning the notification view
    public function execute()
    {
        return view('layouts.Notifications.notifications');
    }
}
