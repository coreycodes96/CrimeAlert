<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->admin === 0) {
            return $next($request);
        } else {
            return redirect('/admin');
        }
    }
}
