<?php

namespace App\Http\Actions\Admins;

use App\Models\Announcement;
use Illuminate\Http\Request;

class createAnnouncement
{
    //Creating an announcement
    public function execute(Request $request)
    {
        //Validate the request
        $data = $request->validate([
            'title' => ['required'],
            'body' => ['required']
        ]);

        //Create the announcement
        $announcement = Announcement::create([
            'title' => $data['title'],
            'body' => $data['body']
        ]);

        return $announcement;
    }
}
