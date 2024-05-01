<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password, [])) {
            return response()->json(
                [
                    'message' => 'User not exist!',
                ],
                404
            );
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(
            [
                'access_token' => $token,
                'type_token' => 'Bearer',
            ],
            200
        );
    }

    public function index(Request $request)
    {
        return response()->json(
            [
                'data' => $request->user(),
            ],
            200
        );
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(
            $data = 'ok',
            $status = 200,
        );
    }
}
