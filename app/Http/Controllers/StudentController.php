<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Presentation;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $students = Student::all();
        $presentations = Presentation::all();
        
        return view('students.create', compact('students', 'presentations'));
    }

    public function store(StudentStoreRequest $request)
    {
        Student::create($request->validated());

        return redirect()->route('students.index')
            ->with('success', 'دانشجو افزوده شد.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('students.index')
            ->with('success', 'دانشجو به‌روز شد.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'دانشجو حذف شد.');
    }
}
