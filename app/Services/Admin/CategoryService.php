<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class CategoryService
{
    
    public function getList()
    {
       $data = Category::all();
       return response()->json([
        "status"  => true,
        "message" => "List data category",
        "data"    => $data
    ], 200);
    }
    
    public function created($data)
    {
        $validator = $this->validateRequest($data);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        $data = Category::create([
            'name'        => $data['name'],
            'isdelete'    => $data['isdelete'],
            'created_by'  => $userdata,
            'updated_by'  => '',
        ]);
        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Category created successfully",
            "data"        => $data
        ], 200);
    }

    public function updated($id, $request)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        $data = Category::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Category not found'], 404);
        }
        $data->update([
            'name'        => $request['name'],
            'isdelete'    => $request['isdelete'],
            'created_by'  => $data->created_by,
            'updated_by'  => $userdata,
        ]);

        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Category update successfully",
            "data"        => $data
        ], 200);
    }

    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = Category::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Category not found'], 404);
        }
        $data->update([
            'isdelete'    => $request['isdelete'],
            'updated_by'  => $userdata,
        ]);
        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Category delete successfully"
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'name'        => 'required|',
            'isdelete'    => 'required|',
        ];

        $messages = [
            'name.required'     => 'Tên là trường bắt buộc.',
            'isdelete.required' => 'isdelete là trường bắt buộc.',
        ];

        return validator($request->all(), $rules, $messages);
    }
}
