<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;

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


Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,'logout'])->middleware('auth:api');;

Route::post('create-task', [TaskController::class, 'create_task']);
Route::post('update-task', [TaskController::class, 'update_task']);
Route::get('tasks', [TaskController::class, 'task_all']);
Route::delete('tasks/{id}', [TaskController::class, 'task_delete']);
