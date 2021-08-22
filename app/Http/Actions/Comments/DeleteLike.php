<?php

namespace App\Http\Actions\Comments;

use App\Models\LikeComment;

class DeleteLike
{
    //Delete comment like
    public function execute(int $id)
    {
        //Checking if the user has already liked the comment
        $isLike = LikeComment::where([['user_id', auth()->user()->id], ['comment_id', $id]])->count();

        //If the user has already liked the comment
        if ($isLike === 1) {
            //Delete the comment like
            LikeComment::where('comment_id', $id)->delete();

            return 'Comment like deleted';
        }
    }
}
