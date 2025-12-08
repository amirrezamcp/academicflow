@extends('layouts.app')

@section('title', 'افزودن ارائه')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 page-animate">

    <h2 class="text-xl font-bold mb-4">افزودن ارائه جدید</h2>

    <form action="{{ route('presentations.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">ارائه:</label>
            <select name="presentation_id" id="presentation_select" class="w-full p-3 border rounded-lg input-focus bg-gray-50">
                <option value="">انتخاب کنید...</option>
                @foreach($presentations as $presentation)
                    <option value="{{ $presentation->id }}"
                        data-day="{{ $presentation->day_hold }}"
                        data-start="{{ $presentation->start_time }}"
                        data-finish="{{ $presentation->finish_time }}">
                        {{ $presentation->master->name }} - {{ $presentation->lesson->name }} ({{ $presentation->lesson->unit }} واحد)
                    </option>
                @endforeach
            </select>
            @error('presentation_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">روز برگزاری:</label>
            <input type="text" id="day_hold" class="w-full p-3 border rounded-lg input-focus" readonly>
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت شروع:</label>
            <input type="time" id="start_time" class="w-full p-3 border rounded-lg input-focus" readonly>
        </div>

        <div>
            <label class="block mb-1 font-medium">ساعت پایان:</label>
            <input type="time" id="finish_time" class="w-full p-3 border rounded-lg input-focus" readonly>
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
            ثبت ارائه
        </button>
    </form>

</div>

@endsection
