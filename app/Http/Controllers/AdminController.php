<?php

namespace App\Http\Controllers;

use App\Http\Actions\Admins\Index;
use App\Http\Actions\Admins\showUsersPosts;
use App\Http\Actions\Admins\updatePostStatus;
use App\Http\Actions\Admins\allUsers;
use App\Http\Actions\Admins\deleteUsersAccount;
use App\Http\Actions\Admins\getAnnouncements;
use App\Http\Actions\Admins\createAnnouncement;
use App\Http\Actions\Admins\deleteAnnouncement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Index $action)
    {
        return $action->execute();
    }

    public function showUsersPosts(showUsersPosts $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function updatePostStatus(Request $request, updatePostStatus $action)
    {
        return response()->json($action->execute($request), 204);
    }

    protected function allUsers(allUsers $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function deleteUsersAccount(int $id, deleteUsersAccount $action)
    {
        return response()->json($action->execute($id), 204);
    }

    protected function getAnnouncements(getAnnouncements $action)
    {
        return response()->json($action->execute());
    }

    protected function createAnnouncement(Request $request, createAnnouncement $action)
    {
        return response()->json($action->execute($request), 201);
    }

    protected function deleteAnnouncement(int $id, deleteAnnouncement $action)
    {
        return response()->json($action->execute($id), 204);
    }
}
