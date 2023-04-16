<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\GetByIdTaskRequest;
use App\Http\Requests\Tasks\TasksEditRequest;
use App\Http\Requests\Course\GetByCourseRequest;
use App\Http\Requests\Users\GetByIdUserRequest;
use App\Models\Tasks;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TasksController extends Controller
{
    public function create(Request $request) {
        if(Tasks::create($request->validated())) {
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

    public function findOne(GetByIdTaskRequest $request) {
        $request = $request->validated();

        if($task = Tasks::find($request["id_task"])) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $task
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function update(TasksEditRequest $request) {
        $validated = $request->validated();

        if($task = Tasks::find($validated["id_task"])) {
            $task->fill($validated);

            if($task->save()) {
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

    public function getTaskList(GetByCourseRequest $request) {
        $request = $request->validated();

        if($categories = Category::where("id_course", "=", $request["id_course"])->get()) {
            foreach ($categories as $idx => $category) {
                $categories[$idx]["tasks"] = Tasks::where("id_category", "=", $category["id_category"])->get();
            }

            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $categories
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function getAllTasksByUser(GetByIdUserRequest $request) {
        $request = $request->validated();

        if($tasks = Tasks::where("id_user", "=", $request["id_user"])->get()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $tasks
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }

    public function delete(GetByIdTaskRequest $request) {
        $request = $request->validated();
        
        if($category = Tasks::find($request["id_task"])) {
            if($category->delete()) {
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
