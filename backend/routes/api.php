<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CollegeController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\PopersController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\Users_submitsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('users/get-user', [UserController::class, 'findOne']);
Route::post('users/edit-user', [UserController::class, 'update']);
Route::post('users/modify-gems', [UserController::class, 'modifyGems']);
Route::post('users/get-users-college', [UserController::class, 'getAllUsersByCollege']);
Route::post('users/get-teachers-college', [UserController::class, 'getAllUsersByCollege']);
Route::post('users/add-course', [UserController::class, 'addCourseToUser']);
Route::post('users/remove-course', [UserController::class, 'removeCourseToUser']);

// Courses
Route::post('users/get-courses', [CoursesController::class, 'getAllCoursesByUser']);
Route::post('users/join-course', [UserController::class, 'joinCourseByCode']);
Route::post('course/create-course', [CoursesController::class, 'create']);
Route::post('course/save-course', [CoursesController::class, 'update']);
Route::post('course/get-details', [CoursesController::class, 'findOne']);
Route::post('course/get-users', [UserController::class, 'getAllUsersByCourse']);
Route::post('course/get-ranking', [CoursesController::class, 'getRanking']);
Route::post('course/refresh-code', [CoursesController::class, 'refreshCode']);

//Requests Course
Route::post('course/get-requests', [CoursesController::class, 'getAllUsersByRequests']);
Route::post('course/resolve-request', [CoursesController::class, 'resolveRequest']);

// Popers
Route::post('popers/create-poper', [PopersController::class, 'create']);

// College
Route::post('college/get-college', [CollegeController::class, 'findOne']);
Route::post('college/save-college', [CollegeController::class, 'update']);

// Tasks
Route::post('tasks/new-task', [TasksController::class, 'create']);
Route::post('tasks/edit-task', [TasksController::class, 'update']);
Route::post('tasks/delete-task', [TasksController::class, 'delete']);
Route::post('tasks/get-task', [TasksController::class, 'findOne']);
Route::post('tasks/get-tasks-list', [TasksController::class, 'getTaskList']);

// Category
Route::post('tasks/new-category', [CategoryController::class, 'create']);
Route::post('tasks/get-categories', [CategoryController::class, 'getCategoriesOnCourse']);

// Task_submits
Route::post('tasks/new-upload', [Users_submitsController::class, 'create']);
Route::post('tasks/get-submits', [Users_submitsController::class, 'findByCourse']);
Route::post('tasks/set-mark', [Users_submitsController::class, 'update']);

// Post Files
Route::post('file', [FileController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

