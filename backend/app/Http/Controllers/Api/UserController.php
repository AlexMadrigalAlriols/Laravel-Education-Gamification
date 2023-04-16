<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\GetByIdCollegeRequest;
use App\Http\Requests\Course\GetByCourseRequest;
use App\Http\Requests\Users\GetByIdUserRequest;
use App\Http\Requests\Users\UserEditRequest;
use App\Http\Requests\Users\UserLoginRequest;
use App\Http\Requests\Users\UserRegisterRequest;
use App\Models\User;
use App\Models\Colleges;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request) {
        $request = $request->validated();

        $college = new Colleges();
        $college->college_name = $request->college;
        $college->logo = '/assets/img/default_logo_college.png';
        $college->shop = '{}';
        $college->requests = '[]';
        $college->save();

        $request["password"] = Hash::make($request->password);
        $request["id_college"] = $college->id;
        $request["role"] = 'college_manager';
        $request["inventory"] = "{}";
        $request["courses"] = "{}";

        if(User::create($request)) {
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

    public function login(UserLoginRequest $request) {
        $request = $request->validated();

        if($user = User::where("email", "=", $request["email"])->first()) {
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true,
                    "id_user" => $user->id_user,
                ]);
            }else{
                return response()->json([
                    "status" => Response::HTTP_BAD_REQUEST,
                    "success"=> false,
                    "msg"   => "Password not match",
                ]);
            }
        }
        
        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "User not found",
        ]);
    }
    
    public function update(UserEditRequest $request) {
        $validated = $request->validated();

        if($user = User::find($validated["id_user"])) {
            $user->fill($validated);

            if($user->save()) {
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

    public function delete(GetByIdUserRequest $request) {
        $request = $request->validated();
        
        if($user = Courses::find($request["id_user"])) {
            if($user->delete()) {
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "success"=> true
                ]);
            }
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "User not found",
        ]);
    }

    public function findOne(GetByIdUserRequest $request) {
        $request = $request->validated();

        $user = User::where("id_user", "=", $request["id_user"])
                    ->leftJoin('colleges', 'users.id_college', '=', 'colleges.id_college')
                    ->leftJoin('popers', 'users.id_poper', '=', 'popers.id_poper')
                    ->first();

        if($user) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data" => $user
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "User not found",
        ]);
    }

    public function getAllUsersByCourse(GetByCourseRequest $request) {
        $request = $request->validated();

        $users = User::whereJsonContains('courses', $request["id_course"])->leftJoin('colleges', 'users.id_college', '=', 'colleges.id_college')->get();

        if($users) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data" => $users
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "User not found",
        ]);
    }

    public function getAllUsersByCollege(GetByIdCollegeRequest $request) {
        $request = $request->validated();

        if($users = User::where("id_college", "=", $request["id_college"])->get()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data" => $users
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false,
            "msg"   => "User not found",
        ]);
    }

    public function addCourseToUser(Request $request) {
        $request->validate([
            "id_course" => "required",
            "id_user" => "required"
        ]);

        $user = User::where("id_user", "=", $request->id_user)->first();
        $json = json_decode($user->courses, true);
        $json_encoded = json_encode(array_merge(array($request->id_course), $json));

        $rows_affected = DB::update("UPDATE users SET courses='".$json_encoded."' where id_user = ?", [$request->id_user]);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha actualizado con exito",
            ]);
        }

        return response()->json([
            "status" => 400,
            "msg" => "No user data"
        ]);
    }

    public function removeCourseToUser(Request $request) {
        $request->validate([
            "id_course" => "required",
            "id_user" => "required"
        ]);

        $user = User::where("id_user", "=", $request->id_user)->first();
        $json = json_decode($user->courses, true);
        if (in_array($request->id_course, $json)) {
            unset($json[array_search($request->id_course ,$json)]);
        }

        $json_encoded = json_encode($json);
        $rows_affected = DB::update("UPDATE users SET courses='".$json_encoded."' where id_user = ?", [$request->id_user]);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha actualizado con exito",
            ]);
        }

        return response()->json([
            "status" => 400,
            "msg" => "No user data"
        ]);
    }

    public function modifyGems(Request $request) {
        $request->validate([
            "id_user" => "required",
            "pepas" => "required",
            "action"=> "required"
        ]);

        $user = User::where("id_user", "=", $request->id_user)->first();
        if($request->action == "sum") {
            $pepas = $user->pepas + $request->pepas;
        } else if($request->action == "res") {
            $pepas = $user->pepas - $request->pepas;
        } else {
            $pepas = $request->pepas;
        }

        if($pepas < 0) {
            $pepas = 0;
        }

        $rows_affected = DB::update("UPDATE users SET pepas='".$pepas."' where id_user = ?", [$request->id_user]);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha actualizado con exito",
            ]);
        }

        return response()->json([
            "status" => 400,
            "msg" => "No user data"
        ]);
    }

    public function joinCourseByCode(Request $request) {
        $request->validate([
            "id_user" => "required",
            "code" => "required"
        ]);

        if($course = Courses::where("code", "=", $request->code)->first()) {
            $user = User::where("id_user", "=", $request->id_user)->whereJsonContains('courses', $course->id_course)->first();

            if(!$user) {
                $json = json_decode($course->requests, true);
                if(!in_array($request->id_user, $json)) {
                    $json_encoded = json_encode(array_merge(array(strval($request->id_user)), $json));

                    $rows_affected = DB::update("UPDATE courses SET requests='".$json_encoded."' where id_course = ?", [$course->id_course]);
        
                    if($rows_affected > 0) {
                        return response()->json([
                            "status" => 200,
                            "msg"   => "Se ha actualizado con exito",
                        ]);
                    }
                }
            }
            
            return response()->json([
                "status" => 200,
                "msg"   => "Ya esta en el curso",
            ]);

        }

        return response()->json([
            "status" => 400,
            "msg" => "No user data"
        ]);
    }
}
