<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function user()
    {
        //Creating a user
        $user = User::factory()->create();

        //Authenticating the user
        $this->actingAs($user);

        //Checking if the user is successfully logged in
        $this->assertTrue(Auth::check());

        //Returning the user
        return $user;
    }

    public function test_show_announcements()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();
        
        //Created user
        $this->user();

        //Making a request to get all the announcements
        $response = $this->json('GET', '/announcements');

        //OK response
        $response->assertOk();
    }
}
