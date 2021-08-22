<?php

namespace App\Http\Actions\Posts;

use App\Models\FavouriteProfile;
use App\Models\Post;

class Show
{
    //Showing the posts
    public function execute()
    {
        //Getting favourite IDs
        $favourites = FavouriteProfile::
        where('user_id', auth()->user()->id)
        ->pluck('profile_id');

        //Display the users posts and the users they've favourited
        $posts = Post::
        where([
            ['user_id', auth()->user()->id],
            ['status', 1]
        ])
        ->with(['user' => function ($query) {
            $query->select('id', 'username');
        }])
        ->with('likes')
        ->orWhereIn('user_id', $favourites)
        ->withCount('comments')
        ->latest()
        ->paginate(4);
        
        return $posts;
    }
}
