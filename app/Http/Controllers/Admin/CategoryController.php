<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryList(CategoryService $data)
    {
        $response = $data->getList();
        return response()->json($response);
    }

    public function categoryCreate(Request $request, CategoryService $data)
    {
        $response = $data->created($request);
        return response()->json($response);
    }

    public function categoryUpdate(Request $request, CategoryService $category, $id)
    {       
        $response = $category->updated($id,$request);
        return response()->json($response);
    }

    public function categoryDelete(Request $request, CategoryService $data, $id)
    {
        $response = $data->deleted($id,$request);
        return response()->json($response);
    }
}
