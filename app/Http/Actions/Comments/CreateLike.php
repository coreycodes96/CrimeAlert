<?php

namespace App\Http\Actions\Comments;

use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\User;
use App\Notifications\LikeCommentNotification;
use Illuminate\Http\Request;

class CreateLike
{
    //Like the comment
    public function execute(Request $request)
    {
        //Validate the request
        $request->validate([
            'user_id' => ['required'],
            'comment_id' => ['required']
        ]);
        
        //Checking if user has already liked the comment
        $isLiked = LikeComment::where([
            ['user_id', $request->user_id],
            ['comment_id', $request->comment_id]
        ])->count();
        
        //If the user hasn't already liked the comment
        if ($isLiked === 0) {
            //Create the comment like
            $new_like = LikeComment::create([
                'user_id' => $request->user_id,
                'comment_id' => $request->comment_id
            ]);

            //Getting the user that needs to be notified
            $commentInfo = Comment::
                select('user_id', 'body')
                ->where('id', $request->comment_id)
                ->get();

            
            //Getting the user model
            $userToNotify = User::
                select('id', 'username')
                ->where('id', $commentInfo[0]->user_id)
                ->get();
            
            //Notification info
            $info = [
                'comment_body' => $commentInfo[0]->body,
                'liker_username' => auth()->user()->username
            ];
            
            //Checking if the comment belongs to the user that is liking the comment
            if ($commentInfo[0]->user_id !== auth()->user()->id) {
                //Send the notification
                $userToNotify[0]->notify(new LikeCommentNotification($info));
            }

            return $new_like;
        }
    }
}
