<?php

namespace App\Http\Controllers\Admin;
use App\Services\Admin\SloganService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SloganController extends Controller
{
    public function sloganList(SloganService $data)
    {
        $response = $data->getList();
        return response()->json($response);
    }

    public function sloganCreate(Request $request, SloganService $data)
    {
        $response = $data->created($request);
        return response()->json($response);
    }

    public function sloganUpdate(Request $request, SloganService $data, $id)
    {
        $response = $data->updated($id,$request);
        return response()->json($response);
    }

    public function sloganDelete(Request $request, SloganService $data, $id)
    {
        $response = $data->deleted($id,$request);
        return response()->json($response);
    }
}
