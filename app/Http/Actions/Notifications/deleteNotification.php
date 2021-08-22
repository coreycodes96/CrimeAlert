<?php

namespace App\Http\Actions\Notifications;

use Illuminate\Support\Facades\DB;

class deleteNotification
{
    //Delete a notification
    public function execute(String $id)
    {
        //Finding the notification and deleting it
        DB::
        table('notifications')
        ->where('id', $id)
        ->delete();

        return 'Notification has been deleted.';
    }
}
