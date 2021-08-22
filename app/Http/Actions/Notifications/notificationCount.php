<?php

namespace App\Http\Actions\Notifications;

use Illuminate\Support\Facades\DB;

class notificationCount
{
    //Getting the notifications count
    public function execute()
    {
        //Getting the notification count of the notifications that havent been read
        $notificationCount = DB::
            table('notifications')
            ->where([
                ['notifiable_id', auth()->user()->id],
                ['read_at', null]
            ])
            ->count();

        return $notificationCount;
    }
}
