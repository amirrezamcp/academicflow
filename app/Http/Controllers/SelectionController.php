<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSelectionRequest;
use App\Http\Requests\UpdateSelectionRequest;
use App\Models\Selection;
use App\Models\Student;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SelectionController extends Controller
{
    public function index()
    {
        $selections = Selection::with(['student', 'presentation.master', 'presentation.lesson'])->latest()->paginate(15);
        return view('selections.index', compact('selections'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        $presentations = Presentation::with(['master', 'lesson'])->get();
        return view('selections.create', compact('students', 'presentations'));
    }

    public function store(StoreSelectionRequest $request)
    {
        foreach ($request->presentation_ids as $presentationId) {
            Selection::create([
                'student_id' => $request->student_id,
                'presentation_id' => $presentationId,
                'year_education' => now()->year,
            ]);
        }

        return redirect()->route('selections.index')
            ->with('success', 'انتخاب واحدها با موفقیت ثبت شد.');
    }

    public function edit(Selection $selection)
    {
        $students = Student::orderBy('name')->get();
        $presentations = Presentation::with(['master', 'lesson'])->get();
        return view('selections.edit', compact('selection', 'students', 'presentations'));
    }

    public function update(UpdateSelectionRequest $request, Selection $selection)
    {
        $selection->update($request->validated());
        return redirect()->route('selections.index')->with('success', 'انتخاب واحد به‌روز شد.');
    }

    public function destroy(Selection $selection)
    {
        $selection->delete();
        return redirect()->route('selections.index')->with('success', 'انتخاب واحد حذف شد.');
    }
}
