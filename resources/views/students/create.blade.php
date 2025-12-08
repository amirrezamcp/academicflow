@extends('layouts.app')

@section('title', 'افزودن دانش‌آموز')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-6">افزودن دانش‌آموز جدید</h2>

    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">نام:</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full p-3 border rounded-lg input-focus bg-gray-50">

            @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">مقطع تحصیلی:</label>
            <input type="text"
                   name="graduation"
                   value="{{ old('graduation') }}"
                   class="w-full p-3 border rounded-lg input-focus bg-gray-50">

            @error('graduation')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg button-press hover:bg-blue-700">
            ذخیره
        </button>
    </form>

</div>

@endsection
