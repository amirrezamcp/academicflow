@extends('layouts.app')

@section('title', 'لیست ارائه‌ها')

@section('content')

<div class="bg-white shadow rounded-xl p-6 page-animate">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">لیست ارائه‌ها</h2>

        <a href="{{ route('presentations.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 button-press">
            + ارائه جدید
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-right border rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">استاد</th>
                    <th class="p-3 border">درس</th>
                    <th class="p-3 border">روز</th>
                    <th class="p-3 border">ساعت</th>
                    <th class="p-3 border">عملیات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($presentations as $presentation)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 border">{{ $loop->iteration }}</td>
                    <td class="p-3 border">{{ $presentation->master->name }}</td>
                    <td class="p-3 border">{{ $presentation->lesson->name }}</td>
                    <td class="p-3 border">{{ $presentation->day_hold }}</td>
                    <td class="p-3 border">
                        {{ $presentation->start_time }} - {{ $presentation->finish_time }}
                    </td>

                    <td class="p-3 border flex items-center gap-2">
                        <a href="{{ route('presentations.edit', $presentation) }}"
                           class="text-blue-600 font-medium hover:underline">ویرایش</a>

                        <form action="{{ route('presentations.destroy', $presentation) }}"
                              method="POST"
                              onsubmit="return confirm('حذف شود؟');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        هیچ ارائه‌ای ثبت نشده است.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $presentations->links() }}
    </div>

</div>

@endsection
