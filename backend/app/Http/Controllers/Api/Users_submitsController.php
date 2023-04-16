<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User_Submits\SubmitsCreateRequest;
use App\Http\Requests\User_Submits\SubmitsEditRequest;
use App\Http\Requests\Course\GetByCourseRequest;
use App\Http\Requests\User_Submits\SubmitsGetByIdRequest;
use Illuminate\Http\Request;
use App\Models\Users_submits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class Users_submitsController extends Controller
{
    public function findOne(SubmitsGetByIdRequest $request) {
        $request = $request->validated();

        if($submit = Users_submits::where("id_users_submits", "=", $request["id_users_submits"])->first()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $submit
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }


     public function create(SubmitsCreateRequest $request) {
        if(Users_submits::create($request->validated())) {
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

    public function findByCourse(GetByCourseRequest $request) {
        $request = $request->validated();

        if($submits = Users_submits::where("id_course", "=", $request["id_course"])->get()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $submits
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function update(SubmitsEditRequest $request) {
        $validated = $request->validated();

        if($submit = Users_submits::find($validated["id_users_submits"])) {
            $submit->fill($validated);

            if($submit->save()) {
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

    public function delete(SubmitsGetByIdRequest $request) {
        $request = $request->validated();
        
        if($submit = Users_submits::find($request["id_user_submits"])) {
            if($submit->delete()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "Submit not found",
        ]);
    }
}
