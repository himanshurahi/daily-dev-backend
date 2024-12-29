<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $inputs = $request->validated();
            User::create($inputs);
            return response()->json([
                'message' => 'User Created',
            ], 201);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Occured',
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $inputs = $request->validated();

            if (Auth::attempt(['email' => $inputs['email'], 'password' => $inputs['password']])) {
                $user = Auth::user();
                $token = $user->createToken('web')->plainTextToken;
                $user->token = $token;

                return response()->json([
                    'message' => 'Login successful!',
                    'user' => $user,
                ], 200);
            }
            throw new AuthenticationException('Invalid credentials provided.');
        }
        catch (AuthenticationException $e)
        {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logged out',
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Occured',
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {

        try {
            $user = $request->user();
            $user->update($request->all());
            return response()->json([
                'message' => 'Profile Updated',
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Occured',
            ], 500);
        }
    }
}
