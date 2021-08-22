<?php

namespace App\Http\Actions\Admins;

class Index
{
    //Returning the admins view
    public function execute()
    {
        return view('layouts.Admins.admins');
    }
}
