<?php

namespace App\Http\Actions\Posts;

class Index
{
    //Returning the posts view
    public function execute()
    {
        return view('layouts.Posts.posts');
    }
}
