<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user',function (Request $request){
        return $request->user();
    });
    Route::apiResource('tasks', TaskController::class);
    Route::as("tasks.")->prefix("tasks")->group(function (){
       Route::post('/{id}/updateTaskStatus/',[TaskController::class,'updateStatus'])->name('updateTaskStatus');
    });
    Route::apiResource('categories', CategoryController::class);
});
