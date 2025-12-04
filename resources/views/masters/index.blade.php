@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">لیست استادها</h2>
    <a href="{{ route('masters.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">افزودن استاد</a>
</div>

<table class="min-w-full bg-white rounded shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 text-left">#</th>
            <th class="py-2 px-4 text-left">نام استاد</th>
            <th class="py-2 px-4 text-left">مدرک</th>
            <th class="py-2 px-4">عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($masters as $master)
        <tr class="border-b hover:bg-gray-50">
            <td class="py-2 px-4">{{ $master->id }}</td>
            <td class="py-2 px-4">{{ $master->name }}</td>
            <td class="py-2 px-4">{{ $master->graduation }}</td>
            <td class="py-2 px-4 space-x-2">
                <a href="{{ route('masters.edit', $master) }}" class="text-blue-600 hover:underline">ویرایش</a>
                <form action="{{ route('masters.destroy', $master) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
