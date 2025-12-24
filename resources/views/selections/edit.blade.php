@extends('layouts.app')

@section('title', 'ویرایش انتخاب واحد')
@section('page-title', 'ویرایش انتخاب واحد')
@section('page-subtitle', 'ویرایش نمره و اطلاعات انتخاب')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('selections.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-clipboard-check ml-2"></i>
                انتخاب واحد
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">ویرایش انتخاب</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="ویرایش انتخاب واحد" icon="fas fa-edit">
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-sm font-medium text-blue-700 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                اطلاعات فعلی
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">دانشجو:</span>
                    <span class="text-gray-800">{{ $selection->student->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">مقطع:</span>
                    <span class="text-gray-800">{{ $selection->student->graduation }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">درس:</span>
                    <span class="text-gray-800">{{ $selection->presentation->lesson->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">واحد:</span>
                    <span class="text-gray-800">{{ $selection->presentation->lesson->unit }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">استاد:</span>
                    <span class="text-gray-800">{{ $selection->presentation->master->name }}</span>
                </div>
                @if($selection->score)
                <div>
                    <span class="font-medium text-gray-600">نمره:</span>
                    <span class="text-gray-800">{{ $selection->score }}</span>
                </div>
                @endif
            </div>
        </div>

        <form action="{{ route('selections.update', $selection) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    ارائه
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <select name="presentation_id"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('presentation_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            required>
                        @foreach($presentations as $presentation)
                            <option value="{{ $presentation->id }}"
                                    {{ old('presentation_id', $selection->presentation_id) == $presentation->id ? 'selected' : '' }}
                                    data-unit="{{ $presentation->lesson->unit }}"
                                    data-day="{{ $presentation->day_hold }}"
                                    data-start="{{ $presentation->start_time }}"
                                    data-finish="{{ $presentation->finish_time }}">
                                {{ $presentation->master->name }} -
                                {{ $presentation->lesson->name }}
                                ({{ $presentation->lesson->unit }} واحد)
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('presentation_id')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div id="presentation-info" class="p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-day text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-600">روز</div>
                            <div id="info-day" class="text-gray-800">{{ $selection->presentation->day_hold }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-600">ساعت</div>
                            <div id="info-time" class="text-gray-800">
                                {{ $selection->presentation->start_time }} - {{ $selection->presentation->finish_time }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hashtag text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-600">واحد</div>
                            <div id="info-unit" class="text-gray-800">{{ $selection->presentation->lesson->unit }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        نمره
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-star text-gray-400"></i>
                        </div>
                        <input type="number" name="score" value="{{ old('score', $selection->score) }}"
                               class="input-modern pr-10 @error('score') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                               min="0" max="100" step="0.01"
                               placeholder="0-100">
                    </div>
                    @error('score')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500 ml-1">*</span>
                        سال تحصیلی
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="number" name="year_education" value="{{ old('year_education', $selection->year_education) }}"
                               class="input-modern pr-10 @error('year_education') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                               placeholder="1402"
                               required>
                    </div>
                    @error('year_education')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>

                <a href="{{ route('selections.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const presentationSelect = document.querySelector('select[name="presentation_id"]');
        const infoDay = document.getElementById('info-day');
        const infoTime = document.getElementById('info-time');
        const infoUnit = document.getElementById('info-unit');

        function updatePresentationInfo() {
            const selectedOption = presentationSelect.options[presentationSelect.selectedIndex];
            if (selectedOption.value) {
                const day = selectedOption.getAttribute('data-day');
                const start = selectedOption.getAttribute('data-start');
                const finish = selectedOption.getAttribute('data-finish');
                const unit = selectedOption.getAttribute('data-unit');

                infoDay.textContent = day;
                infoTime.textContent = `${start} - ${finish}`;
                infoUnit.textContent = unit;
            }
        }

        presentationSelect.addEventListener('change', updatePresentationInfo);

        updatePresentationInfo();
    });
</script>
@endpush
