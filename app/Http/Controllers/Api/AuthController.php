<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    /**
     * Login Authentication
     *
     * @responseFile responses/login.success.json
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::validate($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 400);
        }

        /** @var \App\Models\User */
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken($user->email);
        $profile = [
            "id" => $user->id,
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
