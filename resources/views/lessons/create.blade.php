@extends('layouts.app')

@section('title', 'افزودن درس')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">افزودن درس جدید</h2>

    <form action="{{ route('lessons.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">نام درس:</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full p-3 border rounded-lg input-focus">

            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">تعداد واحد:</label>
            <input type="number" name="unit" value="{{ old('unit') }}"
                class="w-full p-3 border rounded-lg input-focus"
                min="1">

            @error('unit')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg shadow button-press hover:bg-blue-700">
            ثبت درس
        </button>
    </form>

</div>
@endsection
