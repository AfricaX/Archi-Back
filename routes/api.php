<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectsController;

// http://localhost:8000/api/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/checkToken', [AuthController::class, 'checkToken']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


// http://localhost:8000/api/projects/
Route::prefix('/projects')->middleware(['auth:api'])->group(function(){
    Route::post('/', [ProjectsController::class, 'create']);
    Route::patch('/{project}', [ProjectsController::class, 'update']);
    Route::delete('/{project}', [ProjectsController::class, 'destroy']);
});
 Route::get('/projects',[ProjectsController::class, 'index']);
 Route::get('/recents', [ProjectsController::class, 'recents']);
 Route::post('projects/filter', [ProjectsController::class, 'filter']);