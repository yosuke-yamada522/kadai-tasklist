<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        $user->loadRelationshipCounts();

        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

        return view('users.show', [
            'user' => $user,
            'tasks' => $tasks,
        ]);
    }
}
