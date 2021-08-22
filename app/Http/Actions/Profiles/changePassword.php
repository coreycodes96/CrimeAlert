<?php

namespace App\Http\Actions\Profiles;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class changePassword
{
    //Changing the users password
    public function execute(Request $request)
    {
        //Validating the request
        $request->validate([
            'user_id' => ['required'],
            'current_password' => ['required', 'min:8', 'max:255'],
            'new_password' => ['required', 'min:8', 'max:255']
        ]);

        //Checking if the user exists
        $user = User::where('id', $request->user_id)->first();

        //If the user exists
        if ($user) {
            //Check the password is correct
            $checkPasswordIsCorrect = password_verify($request->current_password, $user->password);
            
            //If the password is correct
            if ($checkPasswordIsCorrect) {
                //Changing the users password
                User::where('id', $user->id)
                ->update(['password' => Hash::make($request->new_password)]);
                
                //Logging the user out
                Auth::logout();
                
                return 'Password has been changed';
            }
        }
    }
}
