@extends('layouts.app')

@section('title', 'ویرایش انتخاب واحد')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-6 border-b pb-2">ویرایش انتخاب واحد</h2>

    <form action="{{ route('selections.update', $selection) }}"
          method="POST"
          class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">دانشجو:</label>
            <input type="text"
                   value="{{ $selection->student->name }}"
                   class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700"
                   disabled>
        </div>

        <div>
            <label class="block mb-1 font-medium">ارائه:</label>
            <select name="presentation_id"
                    class="w-full p-3 border rounded-lg bg-gray-50
                    @error('presentation_id') border-red-500 @enderror">

                @foreach($presentations as $presentation)
                    <option value="{{ $presentation->id }}"
                        {{ old('presentation_id', $selection->presentation_id) == $presentation->id ? 'selected' : '' }}>
                        {{ $presentation->lesson->name }} —
                        {{ $presentation->master->name }}
                        ({{ $presentation->lesson->unit }} واحد)
                    </option>
                @endforeach
            </select>

            @error('presentation_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">نمره:</label>
            <input type="number"
                   name="score"
                   value="{{ old('score', $selection->score) }}"
                   min="0" max="100" step="0.01"
                   class="w-full p-3 border rounded-lg
                   @error('score') border-red-500 @enderror">

            @error('score')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">سال تحصیلی:</label>
            <input type="number"
                   name="year_education"
                   value="{{ old('year_education', $selection->year_education) }}"
                   placeholder="مثال: 1402"
                   class="w-full p-3 border rounded-lg
                   @error('year_education') border-red-500 @enderror">

            @error('year_education')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 button-press">
                ذخیره تغییرات
            </button>

            <a href="{{ route('selections.index') }}"
               class="flex-1 text-center bg-gray-200 py-3 rounded-lg hover:bg-gray-300">
                انصراف
            </a>
        </div>

    </form>

</div>

@endsection
