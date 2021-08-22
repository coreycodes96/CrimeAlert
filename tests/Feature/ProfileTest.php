<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\FavouriteNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function user()
    {
        //Create a user
        $user = User::factory()->create();

        //Authenticate a user
        $this->actingAs($user);

        //Check a user is successfully logged in
        $this->assertTrue(Auth::check());

        //Returning the user
        return $user;
    }

    public function changeUsernameError(?int $user_id, ?string $username, string $error)
    {
        //Making a request to change username
        $response = $this->json('PUT', '/profile/change/username', [
            'user_id' => $user_id,
            'username' => $username
        ]);

        //Error response
        $response->assertJsonValidationErrors($error);
    }

    public function changePasswordError(?int $user_id, ?string $current_password, ?string $new_password, string $error)
    {
        //Making a request to change username
        $response = $this->json('PUT', '/profile/change/password', [
            'user_id' => $user_id,
            'current_password' => $current_password,
            'new_password' => $new_password
        ]);

        //Error response
        $response->assertJsonValidationErrors($error);
    }

    public function test_view_a_users_profile()
    {
        //With exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Making a request to a certain users profile
        $response = $this->json('GET', '/profile/'.$user->username);

        //OK response
        $response->assertOk();
    }

    public function test_users_profile_not_found()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Making a request to a certain users profile (A user that does not exist)
        $response = $this->json('GET', '/profile/'. 'test');
        
        //Making sure the 404 view is being used
        $response->assertViewIs('errors.404');
    }

    public function test_get_users_information()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        //Making a request to get the users information
        $response = $this->json('GET', '/profile/get_user_information/'. $user->username);

        //OK response
        $response->assertOk();
    }

    public function test_favourite_a_users_profile()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Fake notifications
        Notification::fake();

        //Created users
        $user1 = $this->user();
        $user2 = $this->user();

        //Making a request to favourite a users profile
        $response = $this->json('POST', '/profile/favourite', [
            'user_id' => $user2->id,
            'profile_id' => $user1->id
        ]);

        //201 response
        $response->assertStatus(201);

        //Send a notification
        $user1->notify(new FavouriteNotification($user2->username));

        //Check the notification has been sent
        Notification::assertSentTo($user1, FavouriteNotification::class, function ($notification, $channels) {
            return in_array('database', $channels);
        });
    }

    public function test_unfavourite_a_users_profile()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created users
        $user1 = $this->user();
        $user2 = $this->user();

        //Making a request to favourite a users profile
        $favourite_profile = $this->json('POST', '/profile/favourite', [
            'user_id' => $user1->id,
            'profile_id' => $user2->id
        ]);

        //201 response
        $favourite_profile->assertStatus(201);

        //Favourite ID
        $favourite_id = $favourite_profile->getData()->id;

        //Making a request to remove a favourite
        $remove_favourite = $this->json('DELETE', '/profile/unfavourite/'.$favourite_id);

        //204 response
        $remove_favourite->assertStatus(204);
    }

    public function test_change_username()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        $response = $this->json('PUT', '/profile/change/username', [
            'user_id' => $user->id,
            'username' => 'Dean'
        ]);

        $response->assertStatus(202);
    }

    public function test_change_username_user_id_is_required()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changeUsernameError(null, 'Testing', 'user_id');
    }

    public function test_change_username_username_is_required()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changeUsernameError($user->id, null, 'username');
    }

    public function test_change_password()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();

        $response = $this->json('PUT', '/profile/change/password', [
            'user_id' => $user->id,
            'current_password' => 'password',
            'new_password' => 'testing123'
        ]);

        $response->assertStatus(202);
    }

    public function test_change_password_user_id_is_required()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changePasswordError(null, $user->password, 'testing1234', 'user_id');
    }

    public function test_change_password_current_password_is_required()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changePasswordError($user->id, null, 'testing1234', 'current_password');
    }

    public function test_change_password_new_password_is_required()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changePasswordError($user->id, $user->password, null, 'new_password');
    }

    public function test_change_password_new_password_min_8()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changePasswordError($user->id, $user->password, 'testing', 'new_password');
    }

    public function test_change_password_new_password_max_255()
    {
        //Created user
        $user = $this->user();
        
        //Creating an error
        $this->changePasswordError($user->id, $user->password, 'HE4GjfBxXKsBraYsJHRqGDrXhXdsVACuRnvLPf5h7DyFEyPrxSzUvQWXqun6s2ugK77j3dVDMNNaKSeXPY7jxqaN3rxTedMFaEbLa4LBZ5prDU8PC77Z6EwSTM4N3GEHkwuX3QPb2JjT2RupuGUvJZSRHJT2jgNszceYt9CVyuyJVXmfhj4FfuRDPQsrXSngp8bm4zAtqaMEZRqDKtRzKBQHjyMvs7ePbsu4tahpDyZgZCv5m4qE2MEmBZpfvknL', 'new_password');
    }

    public function test_delete_account()
    {
        //Without exception handlers
        $this->withoutExceptionHandling();

        //Created user
        $user = $this->user();
        
        //Delete users account request
        $response = $this->json('DELETE', '/profile/delete/account/'.$user->id);
        
        //Response status 204
        $response->assertStatus(204);
    }
}
