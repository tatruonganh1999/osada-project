<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\UserService;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    //Get list all user
    public function userList(UserService $users)
    {
        $response = $users->getList();
        return response()->json($response);
    }

    //Add new user 
    public function userCreate(Request $request, UserService $users)
    {
        $response = $users->created($request);
        return response()->json($response);
    }
    // Get data user detail 
    public function userDetail(UserService $users, $id)
    {
        $response = $users->userDetail($id);
        return response()->json($response);
    }
    //Update data user
    public function userUpdate(Request $request, UserService $users, $id)
    {       
        $response = $users->updated($id,$request);
        return response()->json($response);
    }

    public function changePassword(Request $request, UserService $users)
    {
        $response = $users->changePassword($request);
        return response()->json($response);
    }
    
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
