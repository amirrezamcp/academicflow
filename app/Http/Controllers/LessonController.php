<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::query();

        // جستجو
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $lessons = $query->latest()->paginate(10);

        // آمارها
        $totalLessons = Lesson::count();
        $avgUnit = Lesson::avg('unit') ?? 0;
        $maxUnit = Lesson::max('unit') ?? 0;
        $minUnit = Lesson::min('unit') ?? 0;

        return view('lessons.index', compact('lessons', 'totalLessons', 'avgUnit', 'maxUnit', 'minUnit'));
    }

    public function create()
    {
        return view('lessons.create');
    }

    public function store(LessonStoreRequest $request)
    {
        Lesson::create($request->validated());

        return redirect()->route('lessons.index')->with('success', 'درس افزوده شد.');
    }

    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }

    public function update(LessonUpdateRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return redirect()->route('lessons.index')->with('success', 'درس به‌روز شد.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'درس حذف شد.');
    }
}
