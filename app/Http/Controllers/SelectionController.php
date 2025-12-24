<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSelectionRequest;
use App\Http\Requests\UpdateSelectionRequest;
use App\Models\Lesson;
use App\Models\Master;
use App\Models\Selection;
use App\Models\Student;
use App\Models\Presentation;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Selection::with(['student', 'presentation.master', 'presentation.lesson']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('student', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('presentation.lesson', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('year') && $request->year) {
            $query->where('year_education', $request->year);
        }

        $selections = $query->latest()->paginate(10);

        // آمارها
        $totalSelections = Selection::count();
        $activeStudents = Selection::distinct('student_id')->count('student_id');
        $avgScore = Selection::whereNotNull('score')->avg('score') ?? 0;

        // محاسبه واحدها
        $totalUnits = 0;
        foreach($selections as $selection) {
            $totalUnits += $selection->presentation->lesson->unit ?? 0;
        }

        return view('selections.index', compact(
            'selections',
            'totalSelections',
            'activeStudents',
            'avgScore',
            'totalUnits'
        ));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();

        $presentations = Presentation::with(['master', 'lesson'])
            ->whereHas('master')
            ->whereHas('lesson')
            ->orderBy('day_hold')
            ->orderBy('start_time')
            ->get();

        if ($presentations->isEmpty()) {
            $master = Master::first();
            $lesson = Lesson::first();

            if ($master && $lesson) {
                Presentation::create([
                    'master_id' => $master->id,
                    'lesson_id' => $lesson->id,
                    'day_hold' => 'شنبه',
                    'start_time' => '08:00',
                    'finish_time' => '10:00',
                ]);

                $presentations = Presentation::with(['master', 'lesson'])->get();
            }
        }

        return view('selections.create', compact('students', 'presentations'));
    }

    public function store(StoreSelectionRequest $request)
    {
        $data = [];

        foreach ($request->presentation_ids as $presentationId) {
            $data[] = [
                'student_id' => $request->student_id,
                'presentation_id' => $presentationId,
                'score' => $request->score,
                'year_education' => $request->year_education ?? now()->year,
            ];
        }

        Selection::insert($data);

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
