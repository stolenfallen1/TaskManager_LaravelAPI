<?php

use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks', [TaskController::class, 'index']);

/* 
    CRUD routes
    This line registers a resource controller for the tasks endpoint, with only the specified actions
    Route::apiResource('tasks', TaskController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Both works the same
    This line registers a resource controller for the tasks endpoint, with all the default actions
*/
Route::apiResource('tasks', TaskController::class);
