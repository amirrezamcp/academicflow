<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::latest()->paginate(15);
        return view('lessons.index', compact('lessons'));
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
