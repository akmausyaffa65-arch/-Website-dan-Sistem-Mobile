<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => auth('api')->tokenById(auth('api')->user()->id),
            'user' => auth('api')->user(),
        ], 200);
    }

    public function refresh_token(Request $request)
    {
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        $user = JWTAuth::setToken($refreshToken)->toUser();

        $request->headers->set(
            'Authorization',
            'Bearer ' . $refreshToken
        );

        return response()->json([
            'success' => true,
            'token' => $refreshToken,
            'user' => $user,
        ], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }
}
