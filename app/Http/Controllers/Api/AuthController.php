<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (! Auth::validate($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 400);
        }

        /** @var \App\Models\User */
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken($user->email);
        $profile = [
            'email' => $user->email,
            'name' => $user->name,
            'email_verified' => (bool) $user->email_verified_at,
        ];

        return response()->json([
            'message' => 'Login successful.',
            'data' => [
                'access_token' => $token->accessToken,
                'profile' => $profile
            ]
        ]);
    }
}
