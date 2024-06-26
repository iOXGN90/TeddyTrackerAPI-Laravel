<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SectionController;

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

// Start User
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('show-admin', [LoginController::class, 'show_all_users']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class,'logout'])->middleware('auth:api');
// End User

// Start Section Method
    Route::post('create-section', [SectionController::class, 'create_section']);
    Route::post('login-section', [SectionController::class, 'login_section']);
    Route::post('leave-section', [SectionController::class, 'leave_section']);
    Route::post('section/{section_id}', [SectionController::class, 'delete_section']);
    Route::get('section', [SectionController::class, 'section_all']);
    Route::get('section/{section_id}', [SectionController::class, 'section_id']);
// End Section Method

// Start Tasks Method
    Route::post('create-task', [TaskController::class, 'create_task']);
    Route::put('update-task/{id}', [TaskController::class, 'update_task']);
    Route::get('tasks', [TaskController::class, 'task_all']);
    Route::get('tasks-id/{task_id}', [TaskController::class, 'task_get_id']);
    Route::get('tasks/{section_id}', [TaskController::class, 'task_all_ID']);
    Route::get('tasks-guest/{section_id}', [TaskController::class, 'task_get_section_id']);
    Route::post('tasks/{task_id}', [TaskController::class, 'delete_task']);

// End Tasks Method
