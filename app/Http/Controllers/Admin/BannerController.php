<?php

namespace App\Http\Controllers\Admin;
use App\Services\Admin\BannerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //Banner list
    public function bannerList(BannerService $data)
    {
        $response = $data->getList();
        return response()->json($response);
    }
    //Add new banner
    public function bannerCreate(Request $request, BannerService $data)
    {
        $response = $data->created($request);
        return response()->json($response);
    }
    //Update banner
    public function bannerUpdate(Request $request, BannerService $banner, $id)
    {
        $response = $banner->updated($id,$request);
        return response()->json($response);
    }
    //Delete banner
    public function bannerDelete(Request $request, BannerService $data, $id)
    {
        $response = $data->deleted($id,$request);
        return response()->json($response);
    }
}
