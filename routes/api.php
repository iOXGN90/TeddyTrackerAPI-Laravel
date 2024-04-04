<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\LoginController;

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


Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,'logout'])->middleware('auth:api');;

Route::post('create-task', [TaskController::class, 'create-task']);
Route::post('update-task', [TaskController::class, 'update-task']);
Route::get('tasks', [TaskController::class, 'tasks']);

