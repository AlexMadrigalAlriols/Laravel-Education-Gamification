<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\GetByIdCollegeRequest;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseEditRequest;
use App\Http\Requests\Course\GetByCourseRequest;
use App\Http\Requests\Course\ResolveInvitationRequest;
use App\Http\Requests\Users\GetByIdUserRequest;
use App\Models\User;
use App\Models\Courses;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    //Esta funcion muestra el perfil del usuario
    public function getAllCoursesByUser(GetByIdUserRequest $request) {
        $request = $request->validated();

        if($user = User::find($request["id_user"])) {
            $courses = array();

            if($user->role == "college_manager") {
                $courses = Courses::where("courses.id_college", "=", $user->id_college)->leftJoin('users', 'courses.id_teacher', '=', 'users.id_user')->get();
            } else if($user->role == "teacher") {
                $courses = Courses::where("courses.id_college", "=", $user->id_college)->where("courses.id_teacher", "=", $user->id_user)->leftJoin('users', 'courses.id_teacher', '=', 'users.id_user')->get();
            } else if($user->role == "admin") {
                $courses = Courses::leftJoin('users', 'courses.id_teacher', '=', 'users.id_user')->get();
            } else {
                foreach (json_decode($user->courses, true) as $id_course) {
                    $courses[] = Courses::where("id_course", "=", $id_course)->leftJoin('users', 'courses.id_teacher', '=', 'users.id_user')->first();
                }    
            }

            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $courses
            ]);
        }
    
        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function findOne(GetByCourseRequest $request) {
        $request = $request->validated();

        if($course = Courses::find($request["id_course"])) {
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
    
    public function getRanking(GetByCourseRequest $request) {
        $request = $request->validated();

        if($users = User::whereJsonContains('courses', $request["id_course"])->orderBy('pepas', 'desc')->get()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data" => $users
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function create(CourseCreateRequest $request) {
        $validated = $request->validated();
        $validated["code"] = Str::random(5);

        if(Courses::create($validated)) {
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

    public function update(CourseEditRequest $request) {
        $validated = $request->validated();

        if($course = Courses::find($validated["id_course"])) {
            $course->fill($validated);

            if($course->save()) {
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

    public function delete(GetByCourseRequest $request) {
        $request = $request->validated();
        
        if($course = Courses::find($request["id_category"])) {
            if($course->delete()) {
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

    public function getAllUsersByRequests(GetByCourseRequest $request) {
        $request = $request->validated();

        $users = array();
        $course = Courses::find($request["id_course"]);

        foreach (json_decode($course->requests, true) as $id_user) {
            if($user = User::find($id_user)) {
                $users[] = $user;
            }
        }

        return response()->json([
            "status" => Response::HTTP_OK,
            "success"=> true,
            "data" => $users
        ]);
    }

    public function resolveRequest(ResolveInvitationRequest $request) {
        $request = $request->validated();

        if($course = Courses::find($request["id_course"])) {
            $user_request = json_decode($course["requests"], true);

            foreach ($user_request as $idx => $id_user) {
                if($id_user == $request->id_user) {
                    unset($user_request[$idx]);
                }
            }
            $course->requests = json_encode($user_request);
            $course->save();
            
            if($course->save()) {
                if($request->accepted) {
                    $user = User::where("id_user", "=", $request->id_user)->first();
                    $json = json_decode($user->courses, true);
                    $user->courses = json_encode(array_merge(array($request->id_course), $json));
                    $user->save();
                }
            }

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

    public function refreshCode(GetByCourseRequest $request) {
        $request = $request->validated();

        $new_code = false;

        if($course = Courses::find($request["id_course"])) {
            do {
                $new_code = Str::random(5);
            } while (!$rows_affected = DB::update("UPDATE courses SET code='".$new_code."' where id_course = ?", [$request["id_course"]]));
        }

        if($rows_affected > 0) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "new_code"  => $new_code
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }
}
