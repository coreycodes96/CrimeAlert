<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/register';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required'],
            'surname' => ['required'],
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'dob' => ['required'],
            'admin' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ]);
    }
    
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'dob' => $data['dob'],
            'admin' => $data['admin'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user);
    }
}
