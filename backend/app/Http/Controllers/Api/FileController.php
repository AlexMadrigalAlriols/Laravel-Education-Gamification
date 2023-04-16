<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use Illuminate\Http\Response;
use PharIo\Manifest\Url;

class FileController extends Controller
{
    public function store(Request $request){
        if($request->hasFile('img')){
            $path = $request->file('img')->storeAs('public/posts', $request->file('img')->hashName());

            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data" => $path
            ]);
        }

        return response()->json([
            "success" => false,
            "msg" => "Something went wrong"
        ], Response::HTTP_BAD_REQUEST);
    }
}
