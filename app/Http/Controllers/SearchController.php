<?php

namespace App\Http\Controllers;

use App\Http\Actions\Search\Show;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    protected function show(Request $request, Show $action)
    {
        return response()->json($action->execute($request), 201);
    }
}
