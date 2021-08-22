<?php

namespace App\Http\Actions\Admins;

use App\Models\Post;

class showUsersPosts
{
    //Getting all the users posts
    public function execute()
    {
        //Getting all the users posts with a status of 0
        $allPosts = Post::where('status', 0)
        ->with(['user' => function ($query) {
            $query->select('id', 'username');
        }])
        ->get();
        
        return $allPosts;
    }
}
