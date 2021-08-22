<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowOnlyAjaxRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        return $next($request);
    }
}
