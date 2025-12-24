<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('graduation', 'like', '%' . $request->search . '%');
        }

        if ($request->has('graduation') && $request->graduation) {
            $query->where('graduation', $request->graduation);
        }

        if ($request->has('status') && $request->status && Schema::hasColumn('students', 'status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(10);

        $totalStudents = Student::count();

        if (Schema::hasColumn('students', 'status')) {
            $activeStudents = Student::where('status', 'active')->count();
            $graduatedStudents = Student::where('status', 'graduated')->count();
        } else {
            $activeStudents = $totalStudents;
            $graduatedStudents = 0;
        }

        $avgGpa = 0;

        return view('students.index', compact(
            'students',
            'totalStudents',
            'activeStudents',
            'graduatedStudents',
            'avgGpa'
        ));
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
