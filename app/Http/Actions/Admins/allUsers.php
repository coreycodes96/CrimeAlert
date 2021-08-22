<?php

namespace App\Http\Actions\Admins;

use App\Models\User;

class allUsers
{
    //Getting all users
    public function execute()
    {
        //Getting the users that are not admins
        $allUsers = User::
        where('admin', 0)
        ->get();

        return $allUsers;
    }
}
