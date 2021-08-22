<?php

namespace App\Http\Actions\Admins;

use App\Models\User;

class deleteUsersAccount
{
    //Deleting the users account
    public function execute(int $id)
    {
        //Finding and deleting the users account
        User::where('id', $id)
        ->delete();

        return 'Users account now deleted!';
    }
}
