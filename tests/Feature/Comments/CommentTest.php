<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentTest extends TestCase
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

    public function commentError(?int $user_id, ?int $post_id, ?string $body, string $error)
    {
        //Making a request to try and create a comment
        $response = $this->json('POST', '/comments/create', [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'body' => $body
        ]);
        
        //Comment error response
        $response->assertJsonValidationErrors($error);
    }

    public function test_get_comments()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Getting all the comments related to the post
        $get_comments = $this->json('GET', '/comments/show/'.$newPost->id);

        //200 status check
        $get_comments->assertStatus(200);
    }

    public function test_user_id_to_create_a_comment_is_required()
    {
        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Comment Error
        $this->commentError(null, $newPost->id, 'This is a comment', 'user_id');
    }

    public function test_post_id_to_create_a_comment_is_required()
    {
        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Comment Error
        $this->commentError($user->id, null, 'This is a comment', 'post_id');
    }

    public function test_body_to_create_a_comment_is_required()
    {
        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Comment Error
        $this->commentError($user->id, $newPost->id, null, 'body');
    }

    public function test_creating_a_comment()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Fake notifications
        Notification::fake();

        //Created users
        $user1 = $this->user();
        $user2 = $this->user();

        //Getting post information
        $post_info = [
            'id' => $this->newPost($user1->id)->id,
            'body' => $this->newPost($user1->id)->body
        ];

        //Created comment
        $this->newComment($user2->id, $post_info['id']);

        //Notification info
        $info = [
            'post_body' => $post_info['body'],
            'commenter_username' => $user2->username
        ];

        //Send a notification
        $user1->notify(new CommentNotification($info));

        //Check the notification has been sent
        Notification::assertSentTo($user1, CommentNotification::class, function ($notification, $channels) {
            return in_array('database', $channels);
        });
    }
}
