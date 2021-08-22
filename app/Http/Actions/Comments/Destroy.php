<?php

namespace App\Http\Actions\Comments;

use App\Models\Comment;

class Destroy
{
    //Delete the comment
    public function execute(int $id)
    {
        //Checking if the comment exists
        $comment = Comment::where('id', $id)->count();

        //If the comment exists
        if ($comment === 1) {
            //Deleting the comment
            Comment::where('id', $id)->delete();
            
            return 'Comment deleted!';
        }
    }
}
