@extends('layouts.app')

@section('title', 'لیست درس‌ها')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">لیست درس‌ها</h2>
    <a href="{{ route('lessons.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow button-press hover:bg-blue-700">
        افزودن درس
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden page-animate">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 text-right">#</th>
                <th class="p-3 text-right">نام درس</th>
                <th class="p-3 text-right">تعداد واحد</th>
                <th class="p-3 text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lessons as $lesson)
            <tr class="border-b hover:bg-blue-50/30 transition">
                <td class="p-3">{{ $lesson->id }}</td>
                <td class="p-3">{{ $lesson->name }}</td>
                <td class="p-3">{{ $lesson->unit }}</td>

                <td class="p-3 text-center flex justify-center gap-4">
                    <a href="{{ route('lessons.edit', $lesson) }}" class="text-blue-600 hover:underline">
                        ویرایش
                    </a>

                    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST"
                          onsubmit="return confirm('آیا از حذف این درس مطمئن هستید؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    درسی یافت نشد — <a href="{{ route('lessons.create') }}" class="text-blue-600">افزودن درس جدید</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $lessons->links() }}
    </div>
</div>
@endsection
