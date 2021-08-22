<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CommentDeleteTest extends TestCase
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

    public function newComment(?int $user_id, ?int $post_id)
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

    public function test_deleting_a_comment()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Getting the post ID
        $p_id = $this->newPost($user->id)->id;
        
        //Getting the comment ID
        $c_id = $this->newComment($user->id, $p_id)->id;

        //Making a request to delete a comment
        $delete_comment = $this->json('DELETE', '/comments/delete/'.$c_id);

        //204 response
        $delete_comment->assertStatus(204);

        //Checking the comment has been deleted
        $this->assertDatabaseMissing('comments', [
            'post_id' => $p_id
        ]);
    }
}
