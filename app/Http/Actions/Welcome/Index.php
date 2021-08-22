<?php

namespace App\Http\Actions\Welcome;

class Index
{
    //Welcome view
    public function execute()
    {
        return view('welcome');
    }
}
