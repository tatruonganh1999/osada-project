<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\News;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class NewsService
{
    public function getList()
    {
       $data = News::all();
       return response()->json([
        "status"  => true,
        "message" => "List data news",
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
        $data = News::create([
            'title'       => $data['title'],
            'content'     => $data['content'],
            'image_avata' => $data['image_avata'],
            'isdelete'    => $data['isdelete'],
            'created_by'  => $userdata,
            'updated_by'  => '',
        ]);
        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "News created successfully",
            "data"        => $data
        ], 200);
    }

    public function updated($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = News::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'News not found'], 404);
        }
        $data->update([
            'title'       => $request['title'],
            'content'     => $request['content'],
            'image_avata' => $request['image_avata'],
            'isdelete'    => $request['isdelete'],
            'created_by'  => $data->created_by,
            'updated_by'  => $userdata,
        ]);

        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "News update successfully",
            "data"        => $data
        ], 200);
    }

    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = News::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'News not found'], 404);
        }
        $data->update([
            'isdelete'  => $request['isdelete'],
            'updated_by'=> $userdata,
        ]);
        return response()->json([
            "status"    => true,
            "code"      => 200,
            "message"   => "News delete successfully"
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'title'       => 'required|',
            'content'     => 'required|email',
            'image_avata' => 'required|string',
        ];

        $messages = [
            'name.required'  => 'Tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email'    => 'Email không hợp lệ.',
        ];

        return validator($request->all(), $rules, $messages);
    }

}
