<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        $user->loadRelationshipCounts();

        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        return view('users.show', [
            'user' => $user,
            'tasks' => $tasks,
        ]);
    }
}
