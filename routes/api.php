<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// http://localhost:8000/api/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth-api')->get('/check-token', [AuthController::class, 'checkToken']);
Route::middleware('auth-api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth-api')->get('/search', [AuthController::class, 'search']);

// http://localhost:8000/api/projects/
Route::prefix('/projects')->middleware(['auth:api'])->group(function(){
    Route::get('/',[ProjectsController::class, 'index']);
    Route::post('/', [ProjectsController::class, 'create']);
    Route::patch('/{project}', [ProjectsController::class, 'update']);
    Route::delete('/{project}', [ProjectsController::class, 'destroy']);
});