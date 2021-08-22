<?php

namespace App\Http\Actions\Admins;

use App\Models\Announcement;

class deleteAnnouncement
{
    //Deleting the announcment
    public function execute(int $id)
    {
        //Finding and deleting the announcement
        Announcement::where('id', $id)
        ->delete();

        return 'Announcement deleted!';
    }
}
