<?php

namespace App\Http\Actions\Profiles;

use App\Models\User;

class userProfileInformation
{
    //Getting the users information
    public function execute(string $username)
    {
        //Checking user count
        $isUser = User::
        select('id')
        ->where('username', $username)
        ->count();
        
        //if the user exists
        if ($isUser === 1) {
            //Getting all the users information
            $userInfo = User::select('id', 'username')
            ->where('username', $username)
            ->with('post', 'favourite')
            ->with(['post.user' => function ($query) {
                $query->select('id', 'username');
            }])
            ->withCount('comment', 'like', 'favourite')
            ->get();

            return $userInfo;
        }
    }
}
