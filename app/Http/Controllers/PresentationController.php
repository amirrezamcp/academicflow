<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\Master;
use App\Models\Lesson;
use App\Http\Requests\StorePresentationRequest;
use App\Http\Requests\UpdatePresentationRequest;

class PresentationController extends Controller
{
    public function index()
    {
        $presentations = Presentation::with(['master', 'lesson'])->latest()->paginate(15);
        return view('presentations.index', compact('presentations'));
    }

    public function create()
    {
        $masters = Master::orderBy('name')->get();
        $lessons = Lesson::orderBy('name')->get();

        return view('presentations.create', compact('masters', 'lessons'));
    }

    public function store(StorePresentationRequest $request)
    {
        Presentation::create($request->validated());

        return redirect()
            ->route('presentations.index')
            ->with('success', 'ارائه با موفقیت ایجاد شد.');
    }

    public function edit(Presentation $presentation)
    {
        $masters = Master::orderBy('name')->get();
        $lessons = Lesson::orderBy('name')->get();

        return view('presentations.edit', compact('presentation', 'masters', 'lessons'));
    }

    public function update(UpdatePresentationRequest $request, Presentation $presentation)
    {
        $presentation->update($request->validated());

        return redirect()
            ->route('presentations.index')
            ->with('success', 'ارائه با موفقیت به‌روز شد.');
    }

    public function destroy(Presentation $presentation)
    {
        $presentation->delete();

        return redirect()
            ->route('presentations.index')
            ->with('success', 'ارائه حذف شد.');
    }
}
