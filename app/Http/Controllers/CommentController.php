<?php

namespace App\Http\Controllers;

use App\Http\Actions\Comments\Show;
use App\Http\Actions\Comments\Create;
use App\Http\Actions\Comments\Destroy;
use App\Http\Actions\Comments\CreateLike;
use App\Http\Actions\Comments\DeleteLike;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    public function show(int $id, Show $action)
    {
        return response()->json($action->execute($id), 200);
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
