@extends('layouts.app')

@section('title', 'مدیریت دانش‌آموزان')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
    <h2 class="text-2xl font-bold">مدیریت دانش‌آموزان</h2>

    <a href="{{ route('students.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
        افزودن دانش‌آموز
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">

    @if (session('success'))
        <div class="p-4 bg-green-100 text-green-700 border-b">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full text-sm border-collapse">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">نام</th>
                <th class="p-3 text-right">مقطع</th>
                <th class="p-3 text-center">معدل</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $student)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="p-3 text-right">{{ $student->id }}</td>
                <td class="p-3 text-right font-medium">{{ $student->name }}</td>
                <td class="p-3 text-right">{{ $student->graduation ?? '—' }}</td>

                <td class="p-3 text-center">
                    {{ $student->gpa !== null ? number_format($student->gpa, 2) : '—' }}
                </td>

                <td class="p-3 text-center">
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('students.edit', $student) }}"
                           class="text-blue-600 hover:underline">
                            ویرایش
                        </a>

                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                              onsubmit="return confirmDelete(this);">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">
                                حذف
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">
                    هیچ دانش‌آموزی ثبت نشده —
                    <a href="{{ route('students.create') }}" class="text-blue-600 hover:underline">
                        افزودن اولین دانش‌آموز
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 border-t">
        {{ $students->links() }}
    </div>
</div>

@endsection
