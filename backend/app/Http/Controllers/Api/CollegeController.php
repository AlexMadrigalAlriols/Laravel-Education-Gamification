<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CollegeEditRequest;
use App\Http\Requests\Category\GetByIdCollegeRequest;
use App\Http\Requests\College\CollegeCreateRequest;
use App\Models\User;
use App\Models\Colleges;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CollegeController extends Controller
{
    public function find() {

        $colleges = Colleges::get();

        return response()->json([
            "status" => Response::HTTP_OK,
            "success"=> true,
            "data"  => $colleges
        ]);
    }

    public function findOne(GetByIdCollegeRequest $request) {
        $request = $request->validated();

        if($college = Colleges::where("id_category", "=", $request["id_college"])->first()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $college
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function store(CollegeCreateRequest $request) {
        if(Colleges::create($request->validated())) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function update(CollegeEditRequest $request) {
        $validated = $request->validated();

        if($college = Colleges::find($validated["id_college"])) {
            $college->fill($validated);

            if($college->save()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }


    
    public function delete(GetByIdCollegeRequest $request) {
        $request = $request->validated();
        
        if($college = Colleges::find($request["id_college"])) {
            if($college->delete()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "College not found",
        ]);
    }
}
