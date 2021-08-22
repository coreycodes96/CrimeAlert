<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function user()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Create a user
        $user = User::factory()->create();

        //Authenticate a user
        $this->actingAs($user);

        //Check a user is successfully logged in
        $this->assertTrue(Auth::check());

        //Returning the user
        return $user;
    }

    public function test_search()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Create a user
        $user = $this->user();
        
        //Making a request to search for a user
        $response = $this->json('POST', '/search/show/', ['data' => 'test']);

        //Expecting a 201 status code
        $response->assertStatus(201);
    }
}
