<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\User;
use App\Services\Admin\AuthService;
use Validator;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    // User Login (POST)
    public function login(Request $request, AuthService $userService)
    {
        $response = $userService->login($request);
        return response()->json($response);
    }
    // User Profile (GET)
    public function profile(AuthService $userService){
        $response = $userService->profile();
        return response()->json($response);
    } 
    // User Update Profile (PUT)
    public function profileUpdate(Request $request, AuthService $userService)
    {
        $response = $userService->updated($request);
        return response()->json($response);
    }
    // User Logout (POST)
    public function logout(AuthService $userService) {
        $response = $userService->logout();
        return response()->json($response);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
