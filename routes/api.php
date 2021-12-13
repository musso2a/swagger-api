<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [ApiTokenController::class, 'register']);
Route::post('/login', [ApiTokenController::class, 'login']);

Route::middleware('auth:sanctum')->get('tasks', 'App\Http\Controllers\TasksController@tasks');
Route::middleware('auth:sanctum')->get('checkTask/{id}', 'App\Http\Controllers\TasksController@checkTask');
Route::middleware('auth:sanctum')->post('addTask', 'App\Http\Controllers\TasksController@addTask');
Route::middleware('auth:sanctum')->put('updateTask/{id}', 'App\Http\Controllers\TasksController@updateTask');
Route::middleware('auth:sanctum')->delete('deleteTask/{id}', 'App\Http\Controllers\TasksController@deleteTask');
