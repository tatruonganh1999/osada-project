<?php
// app/Http/Controllers/CodeSnippetController.php
namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $snippet = Test::create($request->all());
        return response()->json(['message' => ' created successfully', 'snippet' => $snippet]);
    }

}
