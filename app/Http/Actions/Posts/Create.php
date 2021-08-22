<?php

namespace App\Http\Actions\Posts;

use App\Models\Post;
use Illuminate\Http\Request;

class Create
{
    //Creating a post
    public function execute(Request $request)
    {
        //Validating the request
        $data = $request->validate([
            'user_id' => ['required'],
            'body' => ['required'],
            'location' => ['required'],
            'media' => ['required', 'mimes:jpg,jpeg,png,mp4,webm'],
            'status' => ['required']
        ]);

        //Creating the post
        $post = Post::create([
            'user_id' => $data['user_id'],
            'body' => $data['body'],
            'location' => $data['location'],
            'media' => $data['media']->store('posts', 'public'),
            'status' => $data['status']
        ]);

        return $post;
    }
}
