<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Slogan;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class SloganService
{
    public function getList()
    {
       $data = Slogan::all();
       return response()->json([
        "status"     => true,
        "message"    => "List data slogan",
        "data"       => $data
    ], 200);
    }

    public function created($data)
    {
        $validator = $this->validateRequest($data);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        $data = Slogan::create([
            'content'     => $data['content'],
            'isdelete'    => $data['isdelete'],
            'created_by'  => $userdata,
            'updated_by'  => '',
        ]);
        return response()->json([
            "status"      => true,
            "message"     => "Slogan created successfully",
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
        $data = Slogan::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Slogan not found'], 404);
        }
        $data->update([
            'content'     => $request['content'],
            'isdelete'    => $request['isdelete'],
            'created_by'  => $data->created_by,
            'updated_by'  => $userdata,
        ]);
        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Slogan update successfully",
            "data"        => $data
        ], 200);
    }

    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = Slogan::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Slogan not found'], 404);
        }
        $data->update([
            'isdelete'  => $request['isdelete'],
            'updated_by'=> $userdata,
        ]);
        return response()->json([
            "status"    => true,
            "code"      => 200,
            "message"   => "Slogan delete successfully"
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'content'  => 'required|',
            'isdelete' => 'required|',
        ];

        $messages = [
            'content.required'  => 'content là trường bắt buộc.',
            'isdelete.required' => 'isdelete là trường bắt buộc.',
        ];

        // Validate the request
        return validator($request->all(), $rules, $messages);
    }
}
