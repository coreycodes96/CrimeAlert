<?php

namespace App\Http\Actions\Notifications;

use Illuminate\Support\Facades\DB;

class getNotification
{
    //Getting a notification
    public function execute(String $id)
    {
        //Finding and getting a notification
        $notification = DB::
            table('notifications')
            ->where('id', $id)
            ->get();

        return $notification;
    }
}
