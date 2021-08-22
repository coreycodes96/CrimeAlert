<?php

namespace App\Http\Controllers;

use App\Http\Actions\Welcome\Index;

class WelcomeController extends Controller
{
    public function index(Index $action)
    {
        return $action->execute();
    }
}
