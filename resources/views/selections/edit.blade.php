@extends('layouts.app')

@section('title', 'ویرایش انتخاب واحد')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">ویرایش انتخاب واحد</h2>

    <form action="{{ route('selections.update', $selection) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">دانشجو:</label>
            <select name="student_id" class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                @foreach($students as $student)
                    <option value="{{ $student->id }}"
                        {{ old('student_id', $selection->student_id) == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ارائه:</label>
            <select name="presentation_id" class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                @foreach($presentations as $presentation)
                    <option value="{{ $presentation->id }}"
                        {{ old('presentation_id', $selection->presentation_id) == $presentation->id ? 'selected' : '' }}>
                        {{ $presentation->lesson->name }} — {{ $presentation->master->name }}
                    </option>
                @endforeach
            </select>
            @error('presentation_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">نمره:</label>
            <input type="number" name="score"
                   value="{{ old('score', $selection->score) }}"
                   class="w-full p-3 border rounded-lg input-focus"
                   min="0" max="100" step="0.01">
            @error('score')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">سال تحصیلی:</label>
            <input type="number" name="year_education"
                   value="{{ old('year_education', $selection->year_education) }}"
                   class="w-full p-3 border rounded-lg input-focus"
                   min="1300" max="9999">
            @error('year_education')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg shadow button-press hover:bg-blue-700">
            ذخیره تغییرات
        </button>
    </form>

</div>

@endsection
