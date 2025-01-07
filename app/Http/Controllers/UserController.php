<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return response()->json($user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'required|confirmed',
        ]);

        $user = auth()->user();
        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}
