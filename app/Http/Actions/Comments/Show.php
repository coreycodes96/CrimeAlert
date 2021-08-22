<?php

namespace App\Http\Actions\Comments;

use App\Models\Comment;

class Show
{
    //Show the comments
    public function execute(int $id)
    {
        //Getting all the comments
        $comments = Comment::
        where('post_id', $id)
        ->with(['user' => function ($query) {
            $query->select('id', 'username');
        }])
        ->with('like_comments')
        ->latest()
        ->get();

        return $comments;
    }
}
