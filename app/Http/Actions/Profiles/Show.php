<?php

namespace App\Http\Actions\Profiles;

use App\Models\User;

class Show
{
    //Showing the users profile
    public function execute(string $username)
    {
        try {
            //Check if the user exists
            $isUser = User::
            select('id')
            ->where([
                ['username', $username],
                ['admin', 0]
            ])
            ->first();

            User::findOrFail($isUser->id);
            
            //Returning the profile view
            return view('layouts.Profiles.profile');
        } catch (\Exception $e) {
            //Returning to an error page
            return view('errors.404');
        }
    }
}
