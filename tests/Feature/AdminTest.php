<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\PostApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function admin()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Create an admin
        $admin = User::factory()->create(['admin' => 1]);

        //Authenticating the user
        $this->actingAs($admin);

        //Checking the user is successfully logged in
        $this->assertTrue(Auth::check());

        //Returning the admin
        return $admin;
    }

    public function user()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Creating a user
        $user = User::factory()->create(['admin' => 0]);

        //Authenticate user
        $this->actingAs($user);

        //Checking if the user is successfully logged in
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

    public function test_user_is_not_admin()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created admin
        $this->admin();

        //Making a request to the admin page
        $response = $this->followingRedirects()->json('GET', '/admin');

        //200 response
        $response->assertStatus(200);
    }

    public function test_user_is_admin()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created admin
        $this->admin();

        //Making a response to the admin page
        $response = $this->json('GET', '/admin');

        //200 response
        $response->assertStatus(200);
    }

    public function test_get_all_users()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $this->admin();

        //Making a request to get all of the users
        $response = $this->json('GET', '/admin/users');

        //OK response (200)
        $response->assertStatus(200);
    }

    public function test_allow_the_admin_to_update_a_users_post_status()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Without middleware
        $this->withoutMiddleware();

        //Fake notifications
        Notification::fake();

        //Created admin
        $this->admin();

        //Created user
        $user = $this->user();

        //Created post
        $post = $this->newPost($user->id);

        //Making a response to update a users post status
        $response = $this->json('PUT', '/admin/update/post', ['id' => $post->id]);

        //201 response
        $response->assertStatus(204);

        //Notification information
        $info = [
            'post_body' => $post->body,
        ];

        //Send a notification
        $user->notify(new PostApprovedNotification($info));

        //Checking the notification has been sent
        Notification::assertSentTo($user, PostApprovedNotification::class, function ($notification, $channels) {
            return in_array('database', $channels);
        });
    }

    public function test_delete_a_users_account()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Without middleware
        $this->withoutMiddleware();

        //Created admin
        $this->admin();

        //Created user
        $user = $this->user();

        //Making a request to delete a users account
        $response = $this->json('DELETE', '/admin/delete/users/account/'.$user->id);

        //204 response
        $response->assertStatus(204);
    }

    public function test_announcement_title_is_required()
    {
        //Create an admin
        $admin = User::factory()->create(['admin' => 1]);

        //Authenticating the user
        $this->actingAs($admin);

        //Checking the user is successfully logged in
        $this->assertTrue(Auth::check());

        //Making a request to create an announcement
        $response = $this->json('POST', '/admin/create/announcement', [
            'title' => '',
            'body' => 'This is a body'
        ]);

        //Getting the error response (checking the title)
        $response->assertJsonValidationErrors('title');
    }

    public function test_announcement_body_is_required()
    {
        //Create an admin
        $admin = User::factory()->create(['admin' => 1]);

        //Authenticating the user
        $this->actingAs($admin);

        //Checking the user is successfully logged in
        $this->assertTrue(Auth::check());

        //Making a request to create an announcement
        $response = $this->json('POST', '/admin/create/announcement', [
            'title' => 'This is a title',
            'body' => ''
        ]);

        //Getting the error response (checking the body)
        $response->assertJsonValidationErrors('body');
    }

    public function test_get_all_announcements()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created admin
        $this->admin();

        //Making a request to get all the announcements
        $response = $this->json('GET', '/admin/announcements');

        //OK response (200)
        $response->assertStatus(200);
    }

    public function test_creating_an_announcement()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created admin
        $this->admin();

        //Making a request to create an announcement
        $response = $this->json('POST', '/admin/create/announcement', [
            'title' => 'This is a title',
            'body' => 'This is a body'
        ]);

        //201 response
        $response->assertStatus(201);
    }

    public function test_deleting_an_announcement()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created admin
        $this->admin();

        //Making a request to create an announcement
        $create_announcement = $this->json('POST', '/admin/create/announcement', [
            'title' => 'This is a title',
            'body' => 'This is a body'
        ]);

        //201 response
        $create_announcement->assertStatus(201);

        //Announcement data
        $announcement = $create_announcement->getData();

        //Making a request to delete an announcement
        $delete_announcement = $this->json('DELETE', '/admin/delete/announcement/'.$announcement->id);

        //204 response
        $delete_announcement->assertStatus(204);
    }
}
