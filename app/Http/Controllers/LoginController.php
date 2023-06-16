<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['username', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->respondForbidden('These credentials do not match our records');
        }

        $user = $request->user();
        $token = $user->createToken("{$user->email} Personal Access Token");

        $user->token = [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ];

        return $this->respondWithSuccess($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess();
    }
}
