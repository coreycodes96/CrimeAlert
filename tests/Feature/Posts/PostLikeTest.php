<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\LikePostNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use RefreshDatabase;

    public function user()
    {
        //Create a user
        $user = User::factory()->create();

        //Authenticate user
        $this->actingAs($user);

        //Checking if the user is successfully logged in
        $this->assertTrue(Auth::check());

        //Returning the user
        return $user;
    }

    public function newPost(int $user_id)
    {
        //Fake storage disk
        Storage::fake('public');

        //Create an image
        $image = UploadedFile::fake()->image('photo1.jpg');

        //Making a request to create a post
        $response = $this->json('POST', '/posts/create/', [
            'user_id' => $user_id,
            'body' => 'This is the body.',
            'location' => 'New York',
            'media' => $image,
            'status' => 0
        ]);
        
        //201 response
        $response->assertStatus(201);
        
        //Returning the new post
        return ['response' => $response->getData(), 'media' => $image];
    }

    public function likeError(?int $post_id, ?int $user_id, string $error)
    {
        //Making a request to create a like
        $response = $this->json('POST', '/posts/like', [
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);
        
        //Error response
        $response->assertJsonValidationErrors($error);
    }

    public function test_like_a_post()
    {
        //Without error exception handlers
        $this->withoutExceptionHandling();

        //Fake notification
        Notification::fake();
        
        //Created users
        $user1 = $this->user();
        $user2 = $this->user();

        //New post
        $newPost = $this->newPost($user1->id);
        
        //Making a request to like a post
        $like_post = $this->json('POST', '/posts/like', [
            'post_id' => $newPost['response']->id,
            'user_id' => $user2->id
        ]);

        //201 response
        $like_post->assertStatus(201);

        //Notification info
        $info = [
            'post_body' => $newPost['response']->body,
            'liker_username' => $user2->username
        ];

        //Send a notification
        $user1->notify(new LikePostNotification($info));

        //Check the notification has been sent
        Notification::assertSentTo($user1, LikePostNotification::class, function ($notification, $channels) {
            return in_array('database', $channels);
        });
    }

    public function test_post_like_user_id_is_required()
    {
        //Created user
        $user = $this->user();

        //New post
        $post = $this->newPost($user->id);
    
        //Creating an error
        $this->likeError($post['response']->id, null, 'user_id');
    }

    public function test_post_like_post_id_is_required()
    {
        //Created user
        $user = $this->user();

        //New post
        $post = $this->newPost($user->id);

        //Creating an error
        $this->likeError(null, $user->id, 'post_id');
    }

    public function test_delete_a_like()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Making a request to like a post
        $like_post = $this->json('POST', '/posts/like', [
            'post_id' => $newPost['response']->id,
            'user_id' => $user->id
        ]);
        
        //201 response
        $like_post->assertStatus(201);
        
        //Making a request to delete the like
        $delete_like = $this->json('DELETE', '/posts/unlike/'.$like_post->getData()->id);

        //204 response
        $delete_like->assertStatus(204);
    }
}
