<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(20);
        // $students = Student::all();
        return response()->json($students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

            return response()->json($data);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error creating a new student',
                'error' => $error->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
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
            return response()->json($data);
        } catch (\Throwable $error) {
            $data = [
                'message' => 'Error updating student',
                'error' => $error->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
