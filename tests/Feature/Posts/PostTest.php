<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
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

    public function postError(?int $user_id, ?string $body, ?string $location, ?string $image, ?int $status, string $error)
    {
        //Fake storage disk
        Storage::fake('public');

        //Making a request to create a post
        $response = $this->json('POST', '/posts/create/', [
            'user_id' => $user_id,
            'body' => $body,
            'location' => $location,
            'media' => $image,
            'status' => $status
        ]);
        
        //Error response
        $response->assertJsonValidationErrors($error);
    }

    public function test_get_all_the_posts()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $this->user();

        //Making a request to get all the posts
        $response = $this->json('GET', '/posts/show');

        //OK 200 response
        $response->assertOk();
    }

    public function test_creating_a_post()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Created post
        $this->newPost($user->id);
        
        //Checking if the post was created
        $this->assertCount(1, Post::get());
    }

    public function test_storing_an_image()
    {
        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);

        //Getting the created post
        $post = Post::first();
        
        //Checking the post image has been created
        $this->assertNotNull($post->media);
        
        //Checking if the image has been stored
        Storage::disk('public')->assertExists($post->media);
        
        //Checking if the file exists
        $this->assertTrue(Storage::disk('public')->exists($post->media));
    }

    public function test_a_user_id_is_required()
    {
        //Created user
        $user = $this->user();

        //Create an image
        $image = UploadedFile::fake()->image('photo.jpg');

        //Post error
        $this->postError(null, 'Here to report', 'New York', $image, 0, 'user_id');
    }

    public function test_body_is_required()
    {
        //Created user
        $user = $this->user();

        //Create an image
        $image = UploadedFile::fake()->image('photo.jpg');

        //Post error
        $this->postError($user->id, null, 'New York', $image, 0, 'body');
    }

    public function test_location_is_required()
    {
        //Created user
        $user = $this->user();

        //Create an image
        $image = UploadedFile::fake()->image('photo.jpg');

        //Post error
        $this->postError($user->id, 'Here to report', null, $image, 0, 'location');
    }

    public function test_media_is_required()
    {
        //Created user
        $user = $this->user();

        //Post error
        $this->postError($user->id, 'Here to report', 'New York', null, 0, 'media');
    }

    public function test_media_must_have_the_correct_file_extention()
    {
        //Fake storage disk
        Storage::fake('public');

        //Create a user
        $user = $this->user();

        //Create an image
        $image = UploadedFile::fake()->image('photo1.php');

        //Post error
        $this->postError($user->id, 'Here to report', 'New York', $image, 0, 'media');
    }

    public function test_status_is_required()
    {
        //Created user
        $user = $this->user();

        //Create an image
        $image = UploadedFile::fake()->image('photo.jpg');

        //Post error
        $this->postError($user->id, 'Here to report', 'New York', $image, null, 'status');
    }
}
