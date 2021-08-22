<?php

namespace App\Http\Controllers;

use App\Http\Actions\Profiles\Show;
use App\Http\Actions\Profiles\userProfileInformation;
use App\Http\Actions\Profiles\Favourite;
use App\Http\Actions\Profiles\Unfavourite;
use App\Http\Actions\Profiles\changeUsername;
use App\Http\Actions\Profiles\changePassword;
use App\Http\Actions\Profiles\deleteAccount;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    public function show(string $username, Show $action)
    {
        return $action->execute($username);
    }

    protected function userProfileInformation(string $username, userProfileInformation $action)
    {
        return response()->json($action->execute($username), 200);
    }

    protected function favourite(Request $request, Favourite $action)
    {
        return response()->json($action->execute($request), 201);
    }

    protected function unfavourite(int $id, Unfavourite $action)
    {
        return response()->json($action->execute($id), 204);
    }

    protected function changeUsername(Request $request, changeUsername $action)
    {
        return $action->execute($request);
    }

    protected function changePassword(Request $request, changePassword $action)
    {
        return response()->json($action->execute($request), 202);
    }

    protected function deleteAccount(int $id, deleteAccount $action)
    {
        return response()->json($action->execute($id), 204);
    }
}
