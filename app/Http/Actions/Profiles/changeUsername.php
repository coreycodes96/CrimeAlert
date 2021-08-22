<?php

namespace App\Http\Actions\Profiles;

use App\Models\User;
use Illuminate\Http\Request;

class changeUsername
{
    //Changing the users username
    public function execute(Request $request)
    {
        //Validating the request
        $request->validate([
            'user_id' => ['required'],
            'username' => ['required', 'max:25']
        ]);

        //Check if username already exists
        $user = User::where('username', $request->username)->count();

        //If the user exists
        if ($user === 0) {
            //Update the users username
            User::where('id', $request->user_id)
            ->update(['username' => $request->username]);

            return response()->json('Username has been changed', 202);
        } else {
            //Telling the user their username has ready been taken
            return response()->json(['errors' =>['username' => 'Username has already been taken']], 422);
        }
    }
}
