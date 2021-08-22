<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_firstname_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => '',
            'surname' => 'Smith',
            'username' => 'Johnny',
            'email' => 'john@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '123456',
        ]);

        //getting the error response (the firstname is required)
        $response->assertJsonValidationErrors('firstname');
    }

    public function test_surname_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => '',
            'username' => 'Johnny',
            'email' => 'john@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '123456',
        ]);

        //getting the error response (the surname is required)
        $response->assertJsonValidationErrors('surname');
    }

    public function test_username_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => 'Smith',
            'username' => '',
            'email' => 'john@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '123456',
        ]);

        //getting the error response (the username is required)
        $response->assertJsonValidationErrors('username');
    }

    public function test_email_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => 'Smith',
            'username' => 'Johnny',
            'email' => '',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '123456',
        ]);

        //getting the error response (the email is required)
        $response->assertJsonValidationErrors('email');
    }

    public function test_dob_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => 'Smith',
            'username' => 'Johnny',
            'email' => 'john@hotmail.com',
            'dob' => '',
            'admin' => 0,
            'password' => '123456',
        ]);

        //getting the error response (the dob is required)
        $response->assertJsonValidationErrors('dob');
    }

    public function test_admin_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => 'Smith',
            'username' => 'Johnny',
            'email' => 'john@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => '',
            'password' => '123456',
        ]);

        //getting the error response (the admin is required)
        $response->assertJsonValidationErrors('admin');
    }

    public function test_password_is_required()
    {
        //Sending a post request to the login route
        $response = $this->json('POST', '/register', [
            'firstname' => 'John',
            'surname' => 'Smith',
            'username' => 'Johnny',
            'email' => 'john@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '',
        ]);

        //getting the error response (the password is required)
        $response->assertJsonValidationErrors('password');
    }

    public function test_registering_the_user()
    {
        //without exception handlers
        $this->withoutExceptionHandling();

        //Sending a post request to the register route
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'surname' => 'Test 2',
            'username' => 'Corzah',
            'email' => 'test@hotmail.com',
            'dob' => '2003-12-31',
            'admin' => 0,
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(200);
    }

    public function test_logging_in_the_user()
    {
        //without exception handlers
        $this->withoutExceptionHandling();
        
        //Creating a user
        $user = User::factory()->create();

        //Logging user in
        $this->actingAs($user);

        //Sending a post request to the login route
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);
    
        //Redirecting to the home route
        $response->assertRedirect('/announcements');
    
        //Auth check
        $this->assertTrue(Auth::check());
    }
}
