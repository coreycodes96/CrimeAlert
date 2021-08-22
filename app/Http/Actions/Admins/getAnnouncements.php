<?php

namespace App\Http\Actions\Admins;

use App\Models\Announcement;

class getAnnouncements
{
    //Getting all the announcements
    public function execute()
    {
        //Getting all the announcments starting from the latest
        $announcements = Announcement::latest()->get();

        return $announcements;
    }
}
