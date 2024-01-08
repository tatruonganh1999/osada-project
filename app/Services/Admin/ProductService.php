<?php

namespace App\Services\Admin;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class ProductService
{
    public function getList()
    {
       $data = Product::all();
       return response()->json([
        "status" => true,
        "message" => "List data product",
        "data" => $data
    ], 200);
    }

    public function created($data)
    {
        $validator = $this->validateRequest($data);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        $data = Product::create([
            'product_name'     => $data['product_name'],
            'product_model'    => $data['product_model'],
            'category_id'      => $data['category_id'],
            'product_image'    => $data['product_image'],
            'product_detailed' => $data['product_detailed'],
            'isdelete'         => $data['isdelete'],
            'created_by'       => $userdata,
            'updated_by'       => '',
        ]);
        return response()->json([
            "status"           => true,
            "code"             => 200,
            "message"          => "Product created successfully",
            "data"             => $data
        ], 200);
    }

    public function updated($id, $request)
    {
        $validator = $this->validateRequest($data);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $userdata = auth('api')->user()->fullname;
        $data = Product::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Product not found'], 404);
        }
        $data->update([
            'product_name'     => $request['product_name'],
            'product_model'    => $request['product_model'],
            'category_id'      => $request['category_id'],
            'product_image'    => $request['product_image'],
            'product_detailed' => $request['product_detailed'],
            'isdelete'         => $request['isdelete'],
            'create_by'        => $data->created_by,
            'updated_by'       => $userdata,
        ]);

        return response()->json([
            "status"           => true,
            "code"             => 200,
            "message"          => "Product update successfully",
            "data"             => $data
        ], 200);
    }


    public function deleted($id, $request)
    {
        $userdata = auth('api')->user()->fullname;
        $data = product::find($id);
        if (!$data) 
        {
         return response()->json(['error' => 'Product not found'], 404);
        }
        $data->update([
            'isdelete'         => $request['isdelete'],
            'updated_by'       => $userdata,
        ]);
        return response()->json([
            "status"           => true,
            "code"             => 200,
            "message"          => "Product delete successfully"
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'product_name'    => 'required|',
            'product_model'   => 'required|',
            'category_id'     => 'required|',
            'product_image'   => 'required|',
            'product_detailed'=> 'required|',
            'isdelete'        => 'required|',

        ];

        $messages = [
            'product_name.required'     => 'Tên product là trường bắt buộc.',
            'product_model.required'    => 'Tên model là trường bắt buộc.',
            'category_id.required'      => 'Category là trường bắt buộc.',
            'product_image.required'    => 'Image là trường bắt buộc.',
            'product_detailed.required' => 'Detailed là trường bắt buộc.',
            'isdelete.required'         => 'Isdelete là trường bắt buộc.',
        ];

        return validator($request->all(), $rules, $messages);
    }
}
