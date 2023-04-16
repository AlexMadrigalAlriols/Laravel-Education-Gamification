<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Popers\GetByPoperIdRequest;
use App\Http\Requests\Popers\PoperCreateRequest;
use App\Models\Popers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PopersController extends Controller
{
    public function findOne(GetByPoperIdRequest $request) {
        $request = $request->validated();

        if($course = Popers::find($request["id_poper"])) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $course
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function create(PoperCreateRequest $request) {
        $request = $request->validated();
        $request["level"] = 1;
        $request["current_exp"] = 0;
        $request["stats_base"] = '{"health": "200", "strength": "50"}';
        $request["abilities"] = '{}';

        if($poper = Popers::create($request)) {
            $user = User::find($request["id_user"]);
            $user->id_poper = $poper->id;

            if($user->save()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true,
                    "id_poper" => $poper->id_poper
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function delete(GetByPoperIdRequest $request) {
        $request = $request->validated();
        
        if($poper = Popers::find($request["id_poper"])) {
            if($poper->delete()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "Category not found",
        ]);
    }
}


