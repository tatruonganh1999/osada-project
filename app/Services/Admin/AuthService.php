<?php
namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Validator;
class AuthService
{
    //Post login 
    public function login($data)
    {
        $credentials = $data->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token]);
        }

        return response()->json(['error'      => true,
                                 'code'       => 401,
                                 'msg'        => 'Unauthorized',
                                 'expires_in' => auth('api')->factory()->getTTL() * 60],401);
    }
    //Get profile
    public function profile()
    {
        $userdata = auth()->user();
        if(!$userdata)
        {
          return response()->json(['error' => true,'code'  => 401,'msg' => 'Unauthorized'],401);
        }
        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ], 200);
    }

    public function updated($request)
    {
        $dataProfile = auth()->user();
        $dataProfile->update([
            'email'             => $request['email'],
            'fullname'          => $request['fullname'],
            'dateofbirth'       => $request['dateofbirth'],
        ]);
        return response()->json([
            "status"            => true,
            "code"              => 200,
            "message"           => "Update profile data successfully",
            "data"              => $dataProfile
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
