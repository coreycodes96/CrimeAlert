<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;

//Welcome
Route::get('/', [WelcomeController::class, 'index']);

//Auth
Auth::routes();
