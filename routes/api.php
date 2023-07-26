<?php

use App\Http\Controllers\StudentController;
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

Route::prefix('student')->group(__DIR__ . '/api/studentRoutes.php');
Route::resource('students', StudentController::class)
    ->missing(function () {
        $data = [
            'message' => 'Student resource not found'
        ];
        return response()->json($data, 404);
    });
