<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Http\Requests\StoreMasterRequest;
use App\Http\Requests\UpdateMasterRequest;

class MasterController extends Controller
{
    public function index()
    {
        $masters = Master::latest()->paginate(15);
        return view('masters.index', compact('masters'));
    }

    public function create()
    {
        return view('masters.create');
    }

    public function store(StoreMasterRequest $request)
    {
        Master::create($request->validated());
        return redirect()->route('masters.index')->with('success', 'استاد با موفقیت افزوده شد.');
    }

    public function edit(Master $master)
    {
        return view('masters.edit', compact('master'));
    }

    public function update(UpdateMasterRequest $request, Master $master)
    {
        $master->update($request->validated());

        return redirect()->route('masters.index')->with('success', 'اطلاعات استاد به‌روز شد.');
    }

    public function destroy(Master $master)
    {
        $master->delete();

        return redirect()->route('masters.index')->with('success', 'استاد حذف شد.');
    }
}
