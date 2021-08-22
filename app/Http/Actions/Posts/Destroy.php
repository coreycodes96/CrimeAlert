<?php

namespace App\Http\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class Destroy
{
    //Delete a post
    public function execute(int $id)
    {
        //Check if the post exists
        $post = Post::where('id', $id)->first();

        //If the post exists
        if ($post) {
            //Delete the post
            Post::where('id', $id)->delete();

            //Delete the image/video from storage
            Storage::disk('public')->delete($post->image);
            
            return 'Post deleted!';
        }
    }
}
