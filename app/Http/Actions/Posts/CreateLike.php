<?php

namespace App\Http\Actions\Posts;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\LikePostNotification;
use Illuminate\Http\Request;

class CreateLike
{
    //Liking a post
    public function execute(Request $request)
    {
        //Validating the request
        $request->validate([
            'post_id' => ['required'],
            'user_id' => ['required']
        ]);

        //Check if the post is already liked
        $isLiked = Like::where([['user_id', $request->user_id], ['post_id', $request->post_id,]])->count();

        //Liking the post
        if ($isLiked === 0) {
            //Create the like
            $new_like = Like::create([
                'post_id' => $request->post_id,
                'user_id' => $request->user_id
            ]);

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
                'liker_username' => auth()->user()->username
            ];
            
            //Checking if the post belongs to the user that is liking the post
            if ($postInfo[0]->user_id !== auth()->user()->id) {
                //Sending a notification
                $userToNotify[0]->notify(new LikePostNotification($info));
            }

            return $new_like;
        }
    }
}
