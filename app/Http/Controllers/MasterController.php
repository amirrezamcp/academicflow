<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Http\Requests\StoreMasterRequest;
use App\Http\Requests\UpdateMasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $query = Master::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('graduation', 'like', '%' . $request->search . '%')
                  ->orWhere('specialties', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            if (Schema::hasColumn('masters', 'status')) {
                $query->where('status', $request->status);
            }
        }

        $masters = $query->latest()->paginate(10);

        $totalMasters = Master::count();

        if (Schema::hasColumn('masters', 'status')) {
            $activeMasters = Master::where('status', 'active')->count();
            $inactiveMasters = Master::where('status', 'inactive')->count();
        } else {
            $activeMasters = $totalMasters;
            $inactiveMasters = 0;
        }

        $phdCount = Master::where('graduation', 'like', '%دکترا%')->orWhere('graduation', 'like', '%phd%')->count();

        return view('masters.index', compact(
            'masters',
            'totalMasters',
            'activeMasters',
            'inactiveMasters',
            'phdCount'
        ));
    }

    public function create()
    {
        return view('masters.create');
    }

    public function store(StoreMasterRequest $request)
    {
        Master::create($request->validatedData());

        return redirect()->route('masters.index')
            ->with('success', 'استاد با موفقیت اضافه شد.');
    }

    public function edit(Master $master)
    {
        return view('masters.edit', compact('master'));
    }

    public function update(UpdateMasterRequest $request, Master $master)
    {
        $master->update($request->validatedData());

        return redirect()->route('masters.index')
            ->with('success', 'اطلاعات استاد با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Master $master)
    {
        if ($master->presentations()->exists()) {
            return redirect()->route('masters.index')
                ->with('error', 'امکان حذف استاد وجود ندارد زیرا درس‌هایی به این استاد مرتبط هستند.');
        }

        $master->delete();

        return redirect()->route('masters.index')
            ->with('success', 'استاد با موفقیت حذف شد.');
    }
}
