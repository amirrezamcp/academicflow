@extends('layouts.app')

@section('title', 'انتخاب واحد')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
    <h2 class="text-2xl font-bold">انتخاب واحد دانشجوان</h2>
    <a href="{{ route('selections.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg button-press">افزودن انتخاب واحد</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden table-responsive">
    <table class="w-full text-sm table-hover">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">دانشجو</th>
                <th class="p-3 text-right">درس</th>
                <th class="p-3 text-right">نمره</th>
                <th class="p-3 text-right">سال تحصیلی</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($selections as $selection)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-right">{{ $selection->id }}</td>
                <td class="p-3 text-right">{{ $selection->student->name }}</td>
                <td class="p-3 text-right">{{ $selection->presentation->lesson->name }} - {{ $selection->presentation->master->name }}</td>
                <td class="p-3 text-right">{{ $selection->score }}</td>
                <td class="p-3 text-right">{{ $selection->year_education }}</td>
                <td class="p-3 text-center flex justify-center items-center gap-3">
                    <a href="{{ route('selections.edit', $selection) }}" class="text-blue-600">ویرایش</a>
                    <form method="POST" action="{{ route('selections.destroy', $selection) }}" onsubmit="return confirmDelete(this);">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-gray-500">
                    هنوز انتخاب واحدی وجود ندارد — <a href="{{ route('selections.create') }}" class="text-blue-600">افزودن اولین انتخاب</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $selections->links() }}
    </div>
</div>
@endsection
