@extends('layouts.app')

@section('title', 'ویرایش درس')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">ویرایش درس</h2>

    <form action="{{ route('lessons.update', $lesson) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">نام درس:</label>
            <input type="text" name="name" value="{{ old('name', $lesson->name) }}"
                class="w-full p-3 border rounded-lg input-focus">

            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">تعداد واحد:</label>
            <input type="number" name="unit" value="{{ old('unit', $lesson->unit) }}"
                class="w-full p-3 border rounded-lg input-focus"
                min="1">

            @error('unit')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg shadow button-press hover:bg-blue-700">
            ذخیره تغییرات
        </button>
    </form>

</div>
@endsection
