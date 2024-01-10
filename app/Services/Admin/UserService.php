<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
class UserService
{
    public function getList()
    {
       $user = User::all();
       return response($user);
    //    return response()->json([
    //     "status" => true,
    //     "message" => "List data user",
    //     "users" => $user
    // ], 200);
    }

    public function created($data)
    {   
        // $rules = [
        // 'username'    => 'required|string',
        // 'password'    => 'required|email',
        // 'email'       => 'required|string',
        // 'fullname'    => 'required|string',
        // 'dateofbirth' => 'required|string',
        // 'usertype'    => 'required|string',
        // 'isdelete'    => 'required|string',
        // ];
        // $response = $data->validate($rules);
        $data = User::create([
            'username'     => $data['username'],
            'password'     => Hash::make($data['password']),
            'email'        => $data['email'],
            'fullname'     => $data['fullname'],
            'dateofbirth'  => $data['dateofbirth'],
            'usertype'     => $data['usertype'],
            'isdelete'     => $data['isdelete'],
        ]);
        return response()->json([
            "status"       => true,
            "message"      => "Admin created successfully",
            "users"        => $data
        ], 200);
    }

    public function updated($id, $request)
    {   
        $data = User::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'User not found'], 404);
        }
        $data->update($request->all());
       return response($data);
        // return response()->json(['message' => 'User updated successfully', 'data' => $data],200);
    }

    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = User::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'User not found'], 404);
        }
        $data->update([
            'isdelete'  => $request['isdelete'],
            'updated_by'=> $userdata,
        ]);
        return response()->json([
            "status"    => true,
            "code"      => 200,
            "message"   => "User delete successfully"
        ], 200);
    }

    public function userDetail($id)
    {
        $data = User::find($id);
        if(!$data)
        {
            return response()->json(['status'=>false,'messager'=> 'user not found','code'=>401],404);
        }
        return response($data);

        // return response()->json(['data'=>$data],200);
    }

    public function changePassword($request)
    {
            $user = Auth::user();
            if(!Hash::check($request->input('current_password'), $user->password))
            {
                return response()->json(['messager'=> 'current_password incorrect'], 401);
            }
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return response()->json(['messager'=>'Password changed successfully']);
    }

    protected function response($data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'success'    => true,
            'data'       => $data,
            'message'    => $message,
            'statusCode' => $statusCode,
            // 'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    // public function success($data = null, $message = null, $statusCode = 200)
    // {
    //     return response()->json([
    //         'success' => true,
    //         'data' => $data,
    //         'message' => $message,
    //     ], $statusCode);
    // }
}
