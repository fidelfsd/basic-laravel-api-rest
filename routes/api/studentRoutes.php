<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// -----------------------------------------------------------------------------


Route::get('/', [StudentController::class, 'index']);
Route::get('/{student}', [StudentController::class, 'show']);
Route::post('/', [StudentController::class, 'store']);
Route::put('/{student}', [StudentController::class, 'update']);
Route::post('/course', [StudentController::class, 'attach']);
Route::post('/course/detach', [StudentController::class, 'detach']);
