<?php

namespace App\Http\Actions\Admins;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostApprovedNotification;
use Illuminate\Http\Request;

class updatePostStatus
{
    //Updating the post status
    public function execute(Request $request)
    {
        //Updating the users post
        $updatedPost = Post::
            where('id', $request->id)
            ->update(['status' => 1]);

        //Getting the user that needs to be notified
        $postInfo = Post::
            select('user_id', 'body')
            ->where('id', $request->id)
            ->get();

        //Getting the user model
        $userToNotify = User::
            select('id', 'username')
            ->where('id', $postInfo[0]->user_id)
            ->get();

        //Notification info
        $info = [
            'post_body' => $postInfo[0]->body,
        ];

        //Sending a notification
        $userToNotify[0]->notify(new PostApprovedNotification($info));

        return $updatedPost;
    }
}
