@extends('layouts.app')

@section('title', 'لیست دانش‌آموزان')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
    <h2 class="text-2xl font-bold">لیست دانش‌آموزان</h2>
    <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg button-press">افزودن دانش‌آموز</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden table-responsive">
    <table class="w-full text-sm table-hover">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">نام</th>
                <th class="p-3 text-right">مدرک</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-right">{{ $student->id }}</td>
                <td class="p-3 text-right">{{ $student->name }}</td>
                <td class="p-3 text-right">{{ $student->graduation }}</td>
                <td class="p-3 text-center flex justify-center items-center gap-3">
                    <a href="{{ route('students.edit', $student) }}" class="text-blue-600">ویرایش</a>
                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirmDelete(this);">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    هنوز دانش‌آموزی وجود ندارد — <a href="{{ route('students.create') }}" class="text-blue-600">افزودن اولین دانش‌آموز</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $students->links() }}
    </div>
</div>
@endsection
