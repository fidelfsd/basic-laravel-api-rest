<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PhpParser\Node\Stmt\UseUse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // validation
            $rules = [
                'name' => 'required|alpha:ascii|max:100',
                'last_name' => 'required|alpha:ascii|max:100',
                'email' => 'required|email|unique:students|regex:/.+\@.+\..+/|max:100',
                'password' => 'required|string|min:8'
                //'password' => ['required', Password::min(8)->mixedCase()->numbers()]
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error in field validation',
                    'error' => $validator->errors()
                ];
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }

            // create a new student
            $student = new Student();
            $student->name = $request->name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->role_id = UserRole::USER;
            $student->save();

            $data = [
                'message' => 'Successfully created a new student'
            ];
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error creating a new student',
                'error' => $error->getMessage(),
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // -------------------------------------------------------------------------

    public function login(Request $request)
    {
        try {
            // validation
            $rules = [
                'email' => 'required|email|regex:/.+\@.+\..+/|max:100',
                'password' => 'required|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $data = [
                    'message' => 'Error in field validation',
                    'error' => $validator->errors()
                ];
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }

            // validate user
            $student = Student::where('email', $request->email)->first();
            if (!$student) {
                $data = [
                    'message' => 'Email or password incorrect',
                ];
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }

            // validate password
            $isPasswordMatch = Hash::check($request->password, $student->password);
            if (!$isPasswordMatch) {
                $data = [
                    'message' => 'Email or password incorrect',
                ];
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }

            // response
            $data = [
                'message' => 'User login successful',
                'user' => $student,
                'token' => $student->createToken('API_TOKEN')->plainTextToken
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error while login',
                'error' => $error->getMessage(),
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
