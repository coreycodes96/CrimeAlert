<?php

namespace App\Http\Actions\Announcements;

use App\Models\Announcement;

class getAnnouncements
{
    //Getting the announcements
    public function execute()
    {
        //Getting all announcements starting from the latest
        $announcements = Announcement::latest()->get();

        return $announcements;
    }
}
