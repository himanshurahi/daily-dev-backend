<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'username' => 'required|string',
        ]);
        try {
            $user = $request->user();
            $user->update($request->all());
            return response()->json([
                'message' => 'User Updated',
                'user' => $user,
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Occured',
            ], 500);
        }
    }
}
