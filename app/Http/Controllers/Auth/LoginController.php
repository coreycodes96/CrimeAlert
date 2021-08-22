<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/announcements';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $data)
    {
        // $credentials = $data->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     $data->session()->regenerate();

        //     return true;
        // }

        $data->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:255']
        ]);

        if (User::where('email', $data['email'])->count() === 0) {
            return response()->json(['errors' => ['email' => ['The email you have entered does not exist']]], 422);
        }

        //attempting to log the user in
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $admin = User::select('admin')->where('email', $data['email'])->get();
            
            //if the data matches
            return response()->json($admin[0], 200);
        } else {
            //if the data does not match
            return response()->json('Incorrect Data', 422);
        }
    }
}
