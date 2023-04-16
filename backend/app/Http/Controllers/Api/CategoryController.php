<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryEditRequest;
use App\Http\Requests\Category\GetByIdCategoryRequest;
use App\Http\Requests\Course\GetByCourseRequest;
use App\Models\Category;
use Illuminate\Http\Response;


class CategoryController extends Controller
{
    public function findOne(GetByIdCategoryRequest $request) {
        $request = $request->validated();

        if($category = Category::find($request["id_category"])) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "success"=> true,
                "data"  => $category
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "success"=> false
        ]);
    }


     public function create(CategoryCreateRequest $request) {
        if(Category::create($request->validated())) {
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

    public function update(CategoryEditRequest $request) {
        $validated = $request->validated();

        if($category = Category::find($validated["id_category"])) {
            $category->fill($validated);

            if($category->save()) {
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

    public function delete(GetByIdCategoryRequest $request) {
        $request = $request->validated();
        
        if($category = Category::find($request["id_category"])) {
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

    public function getCategoriesOnCourse(GetByCourseRequest $request) {
        $request = $request->validated();

        if($categories = Category::where("id_course", "=", $request["id_course"])->get()) {
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
}
