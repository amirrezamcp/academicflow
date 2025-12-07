@extends('layouts.app')

@section('title', 'افزودن ارائه')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">افزودن ارائه جدید</h2>

    <form action="{{ route('presentations.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">استاد:</label>
            <select name="master_id"
                class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                <option value="">انتخاب کنید…</option>

                @foreach($masters as $master)
                    <option value="{{ $master->id }}" {{ old('master_id') == $master->id ? 'selected' : '' }}>
                        {{ $master->name }}
                    </option>
                @endforeach
            </select>

            @error('master_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">درس:</label>
            <select name="lesson_id"
                class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                <option value="">انتخاب کنید…</option>

                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                        {{ $lesson->name }} ({{ $lesson->unit }} واحد)
                    </option>
                @endforeach
            </select>

            @error('lesson_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">روز برگزاری:</label>
            <input type="text" name="day_hold" value="{{ old('day_hold') }}"
                class="w-full p-3 border rounded-lg input-focus">

            @error('day_hold')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت شروع:</label>
            <input type="time" name="start_time" value="{{ old('start_time') }}"
                class="w-full p-3 border rounded-lg input-focus">

            @error('start_time')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت پایان:</label>
            <input type="time" name="finish_time" value="{{ old('finish_time') }}"
                class="w-full p-3 border rounded-lg input-focus">

            @error('finish_time')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            class="w-full bg-green-600 text-white py-3 rounded-lg shadow button-press hover:bg-green-700">
            ثبت ارائه
        </button>
    </form>

</div>

@endsection
