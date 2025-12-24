<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\Master;
use App\Models\Lesson;
use App\Http\Requests\StorePresentationRequest;
use App\Http\Requests\UpdatePresentationRequest;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function index(Request $request)
    {
        $query = Presentation::with(['master', 'lesson']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('master', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('lesson', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhere('day_hold', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->has('day') && $request->day) {
            $query->where('day_hold', $request->day);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $presentations = $query->latest()->paginate(10);

        $totalPresentations = Presentation::count();
        $activePresentations = Presentation::where('status', 'active')->count();
        $activeMasters = Presentation::where('status', 'active')
            ->distinct('master_id')
            ->count('master_id');
        $activeLessons = Presentation::where('status', 'active')
            ->distinct('lesson_id')
            ->count('lesson_id');

        return view('presentations.index', compact(
            'presentations',
            'totalPresentations',
            'activePresentations',
            'activeMasters',
            'activeLessons'
        ));
    }

    public function create()
    {
        $masters = Master::orderBy('name')->get();
        $lessons = Lesson::orderBy('name')->get();

        return view('presentations.create', compact('masters', 'lessons'));
    }

    public function store(StorePresentationRequest $request)
    {
        $data = $request->validated();

        $data['start_time'] = $this->formatTime($data['start_time']);
        $data['finish_time'] = $this->formatTime($data['finish_time']);

        Presentation::create($data);

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
        $data = $request->validated();

        $data['start_time'] = $this->formatTime($data['start_time']);
        $data['finish_time'] = $this->formatTime($data['finish_time']);

        $presentation->update($data);

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

    private function formatTime($time)
    {
        if (empty($time)) {
            return null;
        }

        if (preg_match('/(\d{1,2}):(\d{2})/', $time, $matches)) {
            $hour = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $minute = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            return "{$hour}:{$minute}";
        }

        return $time;
    }
}
