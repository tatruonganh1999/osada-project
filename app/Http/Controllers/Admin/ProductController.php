<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productList(ProductService $data)
    {
        $response = $data->getList();
        return response()->json($response);
    }

    public function productCreate(Request $request, ProductService $data)
    {
        $response = $data->created($request);
        return response()->json($response);
    }

    public function productUpdate(Request $request, ProductService $data, $id)
    {
        $response = $data->updated($id,$request);
        return response()->json($response);
    }

    public function productDelete(Request $request, ProductService $data, $id)
    {
        $response = $data->deleted($id,$request);
        return response()->json($response);
    }
}
