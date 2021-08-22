<?php

namespace App\Http\Actions\Profiles;

use App\Models\User;

class deleteAccount
{
    //Delete an account
    public function execute(int $id)
    {
        //Getting the user
        $user = User::where('id', $id)->first();

        //Checking if the user exists
        if ($user) {
            //Deleting the users account
            User::where('id', $user->id)
            ->delete();

            return 'Your account has been deleted';
        }
    }
}
