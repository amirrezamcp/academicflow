@extends('layouts.app')

@section('title', 'مدیریت دانش‌آموزان')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
    <h2 class="text-2xl font-bold">مدیریت دانش‌آموزان</h2>

    <a href="{{ route('students.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg button-press">
        افزودن دانش‌آموز
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden table-responsive">

    @if (session('success'))
        <div class="p-4 bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full text-sm table-hover">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">نام</th>
                <th class="p-3 text-right">مقطع</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $student)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-right">{{ $student->id }}</td>
                <td class="p-3 text-right">{{ $student->name }}</td>
                <td class="p-3 text-right">{{ $student->graduation ?? '-' }}</td>

                <td class="p-3 text-center flex items-center justify-center gap-3">

                    <a href="{{ route('students.edit', $student) }}" class="text-blue-600">
                        ویرایش
                    </a>

                    <form action="{{ route('students.destroy', $student) }}" method="POST"
                          onsubmit="return confirmDelete(this);">
                        @csrf @method('DELETE')
                        <button class="text-red-600">حذف</button>
                    </form>

                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    هیچ دانش‌آموزی ثبت نشده —
                    <a href="{{ route('students.create') }}" class="text-blue-600">افزودن اولین دانش‌آموز</a>
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
