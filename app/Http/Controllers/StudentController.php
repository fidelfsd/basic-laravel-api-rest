<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $students = Student::with('courses')->paginate(20);
            // $students = Student::all();
            return response()->json($students, Response::HTTP_OK);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error retrieving students',
                'error' => $error->getMessage()
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $student = new Student;
            $student->name = $request->name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->active = $request->active;
            $student->save();

            $data = [
                'message' => 'Successfully created a new student'
            ];
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error creating a new student',
                'error' => $error->getMessage()
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        try {
            $data = Student::with('courses')->find($student);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error retreiving student',
                'error' => $error->getMessage()
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        try {
            // put default value if not set in request body
            $student->name = $request->input('name', $student->name);
            $student->last_name = $request->input('last_name', $student->last_name);
            $student->email = $request->input('email', $student->email);
            $student->address = $request->input('address', $student->address);
            $student->active = $request->input('active', $student->active);
            $student->save();

            $data = [
                'message' => 'Student successfully updated'
            ];
            return response()->json($data, Response::HTTP_OK);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error updating student',
                'error' => $error->getMessage()
            ];

            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {

        try {
            $student->delete();
            $data = [
                'message' => 'Student successfully deleted'
            ];
            return response()->json($data, Response::HTTP_OK);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error deleting student',
                'error' => $error->getMessage()
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Attach course to student.
     */
    public function attach(Request $request)
    {
        try {
            $student = Student::find($request->student_id);
            $student->courses()->attach($request->course_id);

            $data = [
                'message' => 'Course successfully attached',
                'student' => $student->id
            ];
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error attaching course to student',
                'error' => $error->getMessage()
            ];
            return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
