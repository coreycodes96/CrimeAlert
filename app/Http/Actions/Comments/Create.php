<?php

namespace App\Http\Actions\Comments;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;

class Create
{
    //Create a comment
    public function execute(Request $request)
    {
        //Validate the request
        $data = $request->validate([
            'user_id' => ['required'],
            'post_id' => ['required'],
            'body' => ['required']
        ]);

        //Create the comment
        $new_comment = Comment::create($data);

        //Getting the user that needs to be notified
        $postInfo = Post::
            select('user_id', 'body')
            ->where('id', $request->post_id)
            ->get();

        //Getting the user model
        $userToNotify = User::
            select('id', 'username')
            ->where('id', $postInfo[0]->user_id)
            ->get();

        //Notification info
        $info = [
            'post_body' => $postInfo[0]->body,
            'commenter_username' => auth()->user()->username
        ];

        //Checking if post belongs to the user that is commenting
        if ($postInfo[0]->user_id !== auth()->user()->id) {
            //Send the notification
            $userToNotify[0]->notify(new CommentNotification($info));
        }

        return $new_comment;
    }
}
