<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Usuario o password incorrectos!']
            ], 404);
        }

        $token = $user->createToken('token-1-minute')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function userProfile(Request $request)
    {
        $user = User::find($request->id);

        return response()->json([
            'usuario' => $user
        ],201);
    }
}
