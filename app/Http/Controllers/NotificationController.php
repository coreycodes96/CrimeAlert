<?php

namespace App\Http\Controllers;

use App\Http\Actions\Notifications\Index;
use App\Http\Actions\Notifications\notificationCount;
use App\Http\Actions\Notifications\getNotifications;
use App\Http\Actions\Notifications\markNotificationsAsRead;
use App\Http\Actions\Notifications\deleteNotification;
use App\Http\Actions\Notifications\getNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }
    
    public function index(Index $action)
    {
        return $action->execute();
    }

    protected function notificationCount(notificationCount $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function getNotifications(getNotifications $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function markNotificationsAsRead(markNotificationsAsRead $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function deleteNotification(deleteNotification $action, String $id)
    {
        return response()->json($action->execute($id), 202);
    }

    protected function getNotification(getNotification $action, String $id)
    {
        return response()->json($action->execute($id), 200);
    }
}
