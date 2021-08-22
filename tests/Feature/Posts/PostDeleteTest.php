<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostDeleteTest extends TestCase
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

    public function test_delete_a_post()
    {
        //Error exception handling
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Created post
        $newPost = $this->newPost($user->id);
        
        //Making a request to delete the post
        $delete_post = $this->json('DELETE', '/posts/delete/'.$newPost['response']->id);
        Storage::disk('public')->delete($newPost['media']);
        Storage::disk('public')->assertMissing($newPost['media']);

        //204 response
        $delete_post->assertStatus(204);

        $this->assertCount(0, Post::get());
    }
}
