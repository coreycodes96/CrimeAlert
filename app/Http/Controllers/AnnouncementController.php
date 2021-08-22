<?php

namespace App\Http\Controllers;

use App\Http\Actions\Announcements\Index;
use App\Http\Actions\Announcements\getAnnouncements;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    public function index(Index $action)
    {
        return $action->execute();
    }

    protected function getAnnouncements(getAnnouncements $action)
    {
        return response()->json($action->execute(), 200);
    }
}
