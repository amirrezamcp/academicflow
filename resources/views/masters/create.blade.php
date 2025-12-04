@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">افزودن استاد جدید</h2>

<form action="{{ route('masters.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-semibold">نام استاد</label>
        <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-semibold">مدرک</label>
        <input type="text" name="graduation" class="w-full border border-gray-300 p-2 rounded">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">ذخیره</button>
</form>
@endsection
