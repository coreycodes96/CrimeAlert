<?php

namespace App\Http\Actions\Search;

use App\Models\User;
use Illuminate\Http\Request;

class Show
{
    //Show search results
    public function execute(Request $request)
    {
        //Getting the search results
        $search = User::
        where([
            ['username', 'LIKE', '%'.$request->data.'%'],
            ['admin', 0]
        ])
        ->get();

        return $search;
    }
}
