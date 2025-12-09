@extends('layouts.app')

@section('title', 'ثبت انتخاب واحد')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">افزودن انتخاب واحد</h2>

    <form action="{{ route('selections.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">دانشجو:</label>
            <select name="student_id"
                    class="w-full p-3 border rounded-lg input-focus bg-gray-50 @error('student_id') border-red-500 @enderror">
                <option value="">انتخاب کنید...</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} - {{ $student->graduation }}
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">ارائه:</label>
            <select name="presentation_id" id="presentation_select"
                    class="w-full p-3 border rounded-lg input-focus bg-gray-50 @error('presentation_id') border-red-500 @enderror">
                <option value="">انتخاب کنید...</option>

                @foreach($presentations as $presentation)
                    <option value="{{ $presentation->id }}"
                        data-day="{{ $presentation->day_hold }}"
                        data-start="{{ $presentation->start_time }}"
                        data-finish="{{ $presentation->finish_time }}"
                        {{ old('presentation_id') == $presentation->id ? 'selected' : '' }}>
                        {{ $presentation->master->name }} - {{ $presentation->lesson->name }}
                        ({{ $presentation->lesson->unit }} واحد)
                    </option>
                @endforeach
            </select>

            @error('presentation_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

            <div>
                <label class="block mb-1 font-medium">روز برگزاری:</label>
                <input type="text" id="day_hold" class="w-full p-3 border rounded-lg input-focus bg-gray-100" readonly>
            </div>

            <div>
                <label class="block mb-1 font-medium">ساعت شروع:</label>
                <input type="time" id="start_time" class="w-full p-3 border rounded-lg input-focus bg-gray-100" readonly>
            </div>

            <div>
                <label class="block mb-1 font-medium">ساعت پایان:</label>
                <input type="time" id="finish_time" class="w-full p-3 border rounded-lg input-focus bg-gray-100" readonly>
            </div>

        </div>

        <div>
            <label class="block mb-1 font-medium">نمره (اختیاری):</label>
            <input type="number" name="score"
                   value="{{ old('score') }}"
                   class="w-full p-3 border rounded-lg input-focus @error('score') border-red-500 @enderror"
                   min="0" max="100">

            @error('score')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">سال تحصیلی:</label>
            <input type="number" name="year_education"
                   value="{{ old('year_education') }}"
                   class="w-full p-3 border rounded-lg input-focus @error('year_education') border-red-500 @enderror"
                   placeholder="مثال: 1402">

            @error('year_education')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <script>
            document.getElementById('presentation_select').addEventListener('change', function() {
                const selected = this.selectedOptions[0];
                document.getElementById('day_hold').value = selected.dataset.day || '';
                document.getElementById('start_time').value = selected.dataset.start || '';
                document.getElementById('finish_time').value = selected.dataset.finish || '';
            });
        </script>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg shadow button-press hover:bg-blue-700">
            ثبت انتخاب واحد
        </button>

    </form>

</div>

@endsection
