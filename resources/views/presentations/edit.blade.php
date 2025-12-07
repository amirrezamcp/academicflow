@extends('layouts.app')

@section('title', 'ویرایش ارائه')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">ویرایش ارائه</h2>

    <form action="{{ route('presentations.update', $presentation) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-medium">استاد:</label>

            <select name="master_id" class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                @foreach($masters as $master)
                    <option value="{{ $master->id }}"
                        {{ old('master_id', $presentation->master_id) == $master->id ? 'selected' : '' }}>
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

            <select name="lesson_id" class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}"
                        {{ old('lesson_id', $presentation->lesson_id) == $lesson->id ? 'selected' : '' }}>
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
            <input type="text" name="day_hold"
                   value="{{ old('day_hold', $presentation->day_hold) }}"
                   class="w-full p-3 border rounded-lg input-focus">

            @error('day_hold')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت شروع:</label>
            <input type="time" name="start_time"
                   value="{{ old('start_time', $presentation->start_time) }}"
                   class="w-full p-3 border rounded-lg input-focus">

            @error('start_time')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت پایان:</label>
            <input type="time" name="finish_time"
                   value="{{ old('finish_time', $presentation->finish_time) }}"
                   class="w-full p-3 border rounded-lg input-focus">

            @error('finish_time')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg shadow button-press hover:bg-blue-700">
            ذخیره تغییرات
        </button>
    </form>

</div>

@endsection
