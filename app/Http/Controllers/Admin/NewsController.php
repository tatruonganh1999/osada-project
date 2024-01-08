<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function newsList(NewsService $data)
    {
        $response = $data->getList();
        return response()->json($response);
    }

    public function newsCreate(Request $request, NewsService $data)
    {
        $response = $data->created($request);
        return response()->json($response);
    }

    public function newsUpdate(Request $request, NewsService $news, $id)
    {       
        $response = $news->updated($id,$request);
        return response()->json($response);
    }

    public function NewsDelete(Request $request, NewsService $data, $id)
    {
        $response = $data->deleted($id,$request);
        return response()->json($response);
    }
}
