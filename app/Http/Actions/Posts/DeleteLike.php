<?php

namespace App\Http\Actions\Posts;

use App\Models\Like;

class DeleteLike
{
    //Deleting a like
    public function execute(int $id)
    {
        //Check if the post is already liked
        $isLiked = Like::where([['user_id', auth()->user()->id], ['post_id', $id]])->count();

        //Deleting the like
        if ($isLiked === 1) {
            //Delete the like
            Like::where('post_id', $id)
            ->delete();
        }

        return 'Post Deleted';
    }
}
