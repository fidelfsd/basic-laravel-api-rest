<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// -----------------------------------------------------------------------------

// public routes

//Route::get('/', [StudentController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/course', [StudentController::class, 'attach']);
Route::post('/course/detach', [StudentController::class, 'detach']);

// protected routes for admin
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/', [StudentController::class, 'store']);
    Route::get('/{student}', [StudentController::class, 'show']);
});

// protected routes for authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('/{student}', [StudentController::class, 'update']);
});
