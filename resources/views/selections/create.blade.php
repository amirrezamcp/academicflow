@extends('layouts.app')

@section('title', 'ثبت انتخاب واحد')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">افزودن انتخاب واحد</h2>

    <form action="{{ route('selections.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- دانشجو --}}
        <div>
            <label class="block mb-1 font-medium">دانشجو:</label>
            <select name="student_id"
                    class="w-full p-3 border rounded-lg bg-gray-50 @error('student_id') border-red-500 @enderror">
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

        {{-- ارور کلی دروس --}}
        @error('presentation_ids')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        {{-- لیست درس‌ها --}}
        <div id="lessons-wrapper" class="space-y-4">

            <div class="lesson-row border rounded-lg p-4 bg-gray-50">
                <label class="block mb-1 font-medium">ارائه:</label>

                <select name="presentation_ids[]"
                        class="w-full p-3 border rounded-lg presentation-select">
                    <option value="">انتخاب کنید...</option>
                    @foreach($presentations as $presentation)
                        <option value="{{ $presentation->id }}"
                                data-day="{{ $presentation->day_hold }}"
                                data-start="{{ $presentation->start_time }}"
                                data-finish="{{ $presentation->finish_time }}">
                            {{ $presentation->master->name }} -
                            {{ $presentation->lesson->name }}
                            ({{ $presentation->lesson->unit }} واحد)
                        </option>
                    @endforeach
                </select>

                @error('presentation_ids.*')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-3 gap-2 mt-3">
                    <input type="text" class="day w-full p-2 border rounded bg-gray-100" readonly placeholder="روز">
                    <input type="time" class="start w-full p-2 border rounded bg-gray-100" readonly>
                    <input type="time" class="finish w-full p-2 border rounded bg-gray-100" readonly>
                </div>

                <button type="button"
                        class="remove-row mt-3 text-red-600 text-sm hidden">
                    حذف این درس
                </button>
            </div>

        </div>

        {{-- افزودن درس --}}
        <button type="button"
                id="add-lesson"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
            + افزودن درس دیگر
        </button>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
            ثبت انتخاب واحد
        </button>

    </form>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/selections.js') }}"></script>
@endpush
