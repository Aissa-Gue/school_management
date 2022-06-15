<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrolmentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Public routes
Route::post('/login', [UserController::class, 'login']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::apiResource('levels', LevelController::class);
    Route::apiResource('classrooms', ClassroomController::class);
    Route::apiResource('agendas', AgendaController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('enrolments', EnrolmentController::class);
    Route::apiResource('subscriptions', SubscriptionController::class)->except(['index','show','update']);
    Route::apiResource('agendas', AgendaController::class);
    Route::apiResource('expenses', ExpenseController::class);

});
//cant write date manualy in create/edit student
//go to prev page after deleting last row of current page
//spatie laravel /multinancy
//laravel jetstream



