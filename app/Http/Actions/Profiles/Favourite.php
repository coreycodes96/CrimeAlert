<?php

namespace App\Http\Actions\Profiles;

use App\Models\FavouriteProfile;
use App\Models\User;
use App\Notifications\FavouriteNotification;
use Illuminate\Http\Request;

class Favourite
{
    //Favourite a profile
    public function execute(Request $request)
    {
        //Validate request
        $data = $request->validate([
            'user_id' => ['required'],
            'profile_id' => ['required']
        ]);

        //Favourite the profile
        $favourite = FavouriteProfile::create($data);

        //Getting the users information
        $userToNotify = User::
            select('id', 'username')
            ->where('id', $request->profile_id)
            ->get();
        
        //Sending a notification
        $userToNotify[0]->notify(new FavouriteNotification(auth()->user()->username));

        return $favourite;
    }
}
