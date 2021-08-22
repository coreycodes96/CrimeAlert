<?php

namespace App\Http\Controllers;

use App\Http\Actions\Posts\Index;
use App\Http\Actions\Posts\Show;
use App\Http\Actions\Posts\Create;
use App\Http\Actions\Posts\Destroy;
use App\Http\Actions\Posts\CreateLike;
use App\Http\Actions\Posts\DeleteLike;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    public function index(Index $action)
    {
        return $action->execute();
    }

    public function show(Show $action)
    {
        return response()->json($action->execute(), 200);
    }

    protected function create(Request $request, Create $action)
    {
        return response()->json($action->execute($request), 201);
    }

    protected function destroy(int $id, Destroy $action)
    {
        return response()->json($action->execute($id), 204);
    }

    protected function like(Request $request, CreateLike $action)
    {
        return response()->json($action->execute($request), 201);
    }

    protected function unlike(int $id, DeleteLike $action)
    {
        return response()->json($action->execute($id), 204);
    }
}
