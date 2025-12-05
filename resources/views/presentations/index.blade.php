@extends('layouts.app')

@section('title', 'لیست ارائه‌ها')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
    <h2 class="text-2xl font-bold">لیست ارائه‌ها</h2>
    <a href="{{ route('presentations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg button-press">افزودن ارائه</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden table-responsive">
    <table class="w-full text-sm table-hover">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">استاد</th>
                <th class="p-3 text-right">درس</th>
                <th class="p-3 text-right">روز</th>
                <th class="p-3 text-right">شروع</th>
                <th class="p-3 text-right">پایان</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presentations as $presentation)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-right">{{ $presentation->id }}</td>
                <td class="p-3 text-right">{{ $presentation->master->name }}</td>
                <td class="p-3 text-right">{{ $presentation->lesson->name }}</td>
                <td class="p-3 text-right">{{ $presentation->day_hold }}</td>
                <td class="p-3 text-right">{{ $presentation->start_time }}</td>
                <td class="p-3 text-right">{{ $presentation->finish_time }}</td>
                <td class="p-3 text-center flex justify-center items-center gap-3">
                    <a href="{{ route('presentations.edit', $presentation) }}" class="text-blue-600">ویرایش</a>
                    <form method="POST" action="{{ route('presentations.destroy', $presentation) }}" onsubmit="return confirmDelete(this);">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-6 text-center text-gray-500">
                    هنوز ارائه‌ای وجود ندارد — <a href="{{ route('presentations.create') }}" class="text-blue-600">افزودن اولین ارائه</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $presentations->links() }}
    </div>
</div>
@endsection
