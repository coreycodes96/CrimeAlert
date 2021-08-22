<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\LikeCommentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentLikeTest extends TestCase
{
    use RefreshDatabase;

    public function user()
    {
        //Creating a user
        $user = User::factory()->create();

        //Authenticating the user
        $this->actingAs($user);

        //Checking if the user is succesfully logged in
        $this->assertTrue(Auth::check());

        //Returning the user
        return $user;
    }

    public function newPost(int $user_id)
    {
        //Making a request to create a post
        $response  = $this->json('POST', '/posts/create', [
            'user_id' => $user_id,
            'body' => 'This is a new post',
            'location' => 'New York',
            'media' => UploadedFile::fake()->image('photo1.jpg'),
            'status' => 0
        ]);
        
        //201 response
        $response->assertStatus(201);
        
        //Returning the new post
        return $response->getData();
    }

    public function newComment(int $user_id, int $post_id)
    {
        //Making a request to the create a comment
        $response = $this->json('POST', '/comments/create', [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'body' => 'This is a new comment'
        ]);
        
        //201 response
        $response->assertStatus(201);
        
        //Returning the new comment
        return $response->getData();
    }

    public function commentLikeError(?int $user_id, ?int $comment_id, string $error)
    {
        //Making a request to try and create a comment
        $response = $this->json('POST', '/comments/like', [
            'user_id' => $user_id,
            'comment_id' => $comment_id,
        ]);
        
        //Comment error response
        $response->assertJsonValidationErrors($error);
    }

    public function test_liking_a_comment()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Fake notifications
        Notification::fake();

        //Created users
        $user1 = $this->user();
        $user2 = $this->user();

        //Getting the post ID
        $p_id = $this->newPost($user1->id)->id;

        //Getting the comment information
        $comment_info = [
            'id' => $this->newComment($user1->id, $p_id)->id,
            'body' => $this->newComment($user1->id, $p_id)->body
        ];

        //Making a request to like a comment
        $response = $this->json('POST', '/comments/like/', [
            'user_id' => $user2->id,
            'comment_id' => $comment_info['id']
        ]);

        //201 response
        $response->assertStatus(201);

        //Notification info
        $info = [
            'comment_body' => $comment_info['body'],
            'liker_username' => $user2->username
        ];

        //Send a notification
        $user1->notify(new LikeCommentNotification($info));

        //Check the notification has been sent
        Notification::assertSentTo($user1, LikeCommentNotification::class, function ($notification, $channels) {
            return in_array('database', $channels);
        });
    }

    public function test_comment_like_user_id_is_required()
    {
        //Created user
        $user = $this->user();

        //New post
        $post = $this->newPost($user->id);

        //New comment
        $comment = $this->newComment($user->id, $post->id);

        //Creating an error
        $this->commentLikeError(null, $comment->id, 'user_id');
    }

    public function test_comment_like_comment_id_is_required()
    {
        //Created user
        $user = $this->user();

        //New post
        $post = $this->newPost($user->id);

        //New comment
        $comment = $this->newComment($user->id, $post->id);

        //Creating an error
        $this->commentLikeError($user->id, null, 'comment_id');
    }
    
    public function test_unliking_a_comment()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created Users
        $user = $this->user();

        //Getting the post ID
        $p_id = $this->newPost($user->id)->id;

        //Getting the comment ID
        $c_id = $this->newComment($user->id, $p_id)->id;

        //Making a request to like a comment
        $create_a_like = $this->json('POST', '/comments/like/', [
            'user_id' => $user->id,
            'comment_id' => $c_id
        ]);

        //201 response
        $create_a_like->assertStatus(201);

        //Getting the like data
        $like = $create_a_like->getData();
        
        //Making a request to delete a comment like
        $delete_a_like = $this->json('DELETE', '/comments/unlike/'.$like->id);

        //204 response
        $delete_a_like->assertStatus(204);
        
        //Checking the comment like has been deleted
        $this->assertDatabaseMissing('like_comments', [
            'comment_id' => $c_id
        ]);
    }
}
