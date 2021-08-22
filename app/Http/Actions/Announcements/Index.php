<?php

namespace App\Http\Actions\Announcements;

class Index
{
    //Returning the announcement view
    public function execute()
    {
        return view('layouts.Announcements.announcment');
    }
}
