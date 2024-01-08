<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Banner;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class BannerService
{
    public function getList()
    {
       $data = Banner::all();
       return response()->json([
        "status"   => true,
        "message"  => "List data banner",
        "data"     => $data
        ], 200);
    }

    public function created($data)
    {
        $validator = $this->validateRequest($data);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        // $image = $data->file('image');
        // $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Lưu hình ảnh vào thư mục storage/app/public
        // $path = storage_path('app/public/images' . $imageName);
        // Image::make($image->getRealPath())->save($path);
        $data = Banner::create([
            'title'       => $data['title'],
            'content'     => $data['content'],
            // 'image'       => $imageName,
            'image'       => $data['image'],
            'link'        => $data['link'],
            'isdelete'    => $data['isdelete'],
            'created_by'  => $userdata,
            'updated_by'  => '',
        ]);
        return response()->json([
            "status"      => true,
            "message"     => "Banner created successfully",
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
        $data = Banner::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Banner not found'], 404);
        }
        $data->update([
            'title'       => $request['title'],
            'content'     => $request['content'],
            'image'       => $request['image'],
            'link'        => $request['link'],
            'isdelete'    => $request['isdelete'],
            'created_by'  => $data->created_by,
            'updated_by'  => $userdata,
        ]);

        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Banner update successfully",
            "data"        => $data
        ], 200);
    }

    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = Banner::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Banner not found'], 404);
        }
        $data->update([
            'isdelete'    => $request['isdelete'],
            'updated_by'  => $userdata,
        ]);
        return response()->json([
            "status"      => true,
            "code"        => 200,
            "message"     => "Banner delete successfully"
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'title'            => 'required|',
            'content'          => 'required|',
            'image'            => 'required|string',
            'link'             => 'required|string',
            'isdelete'         => 'required|string',

        ];

        $messages = [
            'title.required'   => 'title là trường bắt buộc.',
            'content.required' => 'content là trường bắt buộc.',
            'image.required'   => 'image là trường bắt buộc.',
            'link.required'    => 'link là trường bắt buộc.',

        ];

        return validator($request->all(), $rules, $messages);
    }
}
