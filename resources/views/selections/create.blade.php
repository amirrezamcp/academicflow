@extends('layouts.app')

@section('title', 'ثبت انتخاب واحد')
@section('page-title', 'ثبت انتخاب واحد جدید')
@section('page-subtitle', 'انتخاب درس برای دانشجو')

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
                <span class="text-sm font-medium text-gray-500">ثبت انتخاب واحد</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-3xl mx-auto page-animate">

    <x-card title="فرم انتخاب واحد" icon="fas fa-clipboard-list">
        <form action="{{ route('selections.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    دانشجو
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-user-graduate text-gray-400"></i>
                    </div>
                    <select name="student_id"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('student_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            required
                            autofocus>
                        <option value="">انتخاب دانشجو...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} - {{ $student->graduation }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('student_id')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500 ml-1">*</span>
                        ارائه‌های انتخاب شده
                    </label>
                    <span id="total-units" class="text-sm font-medium text-blue-600">
                        ۰ واحد
                    </span>
                </div>

                <div id="presentations-container" class="space-y-4">
                    <div class="presentation-row card-modern p-4 border-2 border-dashed border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <span class="text-sm font-medium text-gray-700">درس ۱</span>
                            <button type="button"
                                    class="remove-row text-red-500 hover:text-red-700 hidden"
                                    title="حذف این درس">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                    <select name="presentation_ids[]"
                                            class="presentation-select input-modern pr-10 appearance-none cursor-pointer"
                                            required>
                                        <option value="">انتخاب ارائه...</option>
                                        @if($presentations && $presentations->count() > 0)
                                            @foreach($presentations as $presentation)
                                                @if($presentation->master && $presentation->lesson) {{-- بررسی کن ارتباطات وجود دارن --}}
                                                    <option value="{{ $presentation->id }}"
                                                            data-unit="{{ $presentation->lesson->unit }}"
                                                            data-day="{{ $presentation->day_hold }}"
                                                            data-start="{{ $presentation->start_time }}"
                                                            data-finish="{{ $presentation->finish_time }}"
                                                            data-master="{{ $presentation->master->name }}"
                                                            data-lesson="{{ $presentation->lesson->name }}">
                                                        {{ $presentation->master->name }} -
                                                        {{ $presentation->lesson->name }}
                                                        ({{ $presentation->lesson->unit }} واحد)
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="" disabled>هیچ ارائه‌ای موجود نیست</option>
                                        @endif
                                    </select>
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>

                            <div class="presentation-info hidden p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-day text-blue-500"></i>
                                        <span class="presentation-day text-gray-700"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-clock text-blue-500"></i>
                                        <span class="presentation-time text-gray-700"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-graduate text-blue-500"></i>
                                        <span class="presentation-master text-gray-700"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @error('presentation_ids')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
                @error('presentation_ids.*')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror

                <button type="button"
                        id="add-presentation"
                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg
                               text-gray-600 hover:text-gray-800 hover:border-gray-400
                               hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    افزودن درس دیگر
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        نمره (۰ تا ۲۰)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-star text-gray-400"></i>
                        </div>
                        <input type="number" name="score" value="{{ old('score') }}"
                            class="input-modern pr-10 @error('score') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            min="0" max="20" step="0.01"
                            placeholder="0-20">
                    </div>
                    @error('score')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-gray-500">در صورت تمایل وارد کنید (حداکثر ۲۰)</p>
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
                        <input type="number" name="year_education" value="{{ old('year_education', now()->year) }}"
                            class="input-modern pr-10 @error('year_education') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            placeholder="۱۴۰۲"
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

            <div id="selection-summary" class="p-4 bg-green-50 rounded-lg border border-green-200 hidden">
                <h4 class="text-sm font-medium text-green-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    خلاصه انتخاب واحد
                </h4>
                <div class="space-y-2 text-sm text-gray-700">
                    <p id="summary-text"></p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-save"></i>
                    ثبت انتخاب واحد
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
        const container = document.getElementById('presentations-container');
        const addButton = document.getElementById('add-presentation');
        const totalUnitsElement = document.getElementById('total-units');
        const summaryElement = document.getElementById('selection-summary');
        const summaryTextElement = document.getElementById('summary-text');

        let rowCount = 1;
        let selectedPresentations = [];
        let totalUnits = 0;

        function updateSummary() {
            if (selectedPresentations.length === 0) {
                summaryElement.classList.add('hidden');
                return;
            }

            summaryElement.classList.remove('hidden');
            summaryTextElement.innerHTML = `
                <div class="mb-2">
                    <span class="font-medium">تعداد درس‌ها:</span>
                    <span class="text-green-600 font-bold">${selectedPresentations.length}</span>
                </div>
                <div>
                    <span class="font-medium">مجموع واحدها:</span>
                    <span class="text-green-600 font-bold">${totalUnits}</span>
                </div>
            `;
        }

        function updateTotalUnits() {
            totalUnitsElement.textContent = totalUnits + ' واحد';
            updateSummary();
        }

        function addPresentationRow() {
            rowCount++;
            const newRow = document.createElement('div');
            newRow.className = 'presentation-row card-modern p-4';
            newRow.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700">درس ${rowCount}</span>
                    <button type="button"
                            class="remove-row text-red-500 hover:text-red-700"
                            title="حذف این درس">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-book text-gray-400"></i>
                        </div>
                        <select name="presentation_ids[]"
                                class="presentation-select input-modern pr-10 appearance-none cursor-pointer"
                                required>
                            <option value="">انتخاب ارائه...</option>
                            @foreach($presentations as $presentation)
                                <option value="{{ $presentation->id }}"
                                        data-unit="{{ $presentation->lesson->unit }}"
                                        data-day="{{ $presentation->day_hold }}"
                                        data-start="{{ $presentation->start_time }}"
                                        data-finish="{{ $presentation->finish_time }}"
                                        data-master="{{ $presentation->master->name }}"
                                        data-lesson="{{ $presentation->lesson->name }}">
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

                    <div class="presentation-info hidden p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-day text-blue-500"></i>
                                <span class="presentation-day text-gray-700"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-blue-500"></i>
                                <span class="presentation-time text-gray-700"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-graduate text-blue-500"></i>
                                <span class="presentation-master text-gray-700"></span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(newRow);

            newRow.querySelector('.remove-row').addEventListener('click', function() {
                removePresentationRow(this.closest('.presentation-row'));
            });

            const select = newRow.querySelector('.presentation-select');
            select.addEventListener('change', handlePresentationChange);
        }

        function removePresentationRow(row) {
            const select = row.querySelector('.presentation-select');
            if (select.value) {
                const unit = parseInt(select.options[select.selectedIndex].getAttribute('data-unit')) || 0;
                totalUnits -= unit;

                const index = selectedPresentations.indexOf(select.value);
                if (index > -1) {
                    selectedPresentations.splice(index, 1);
                }
            }

            row.remove();
            updateTotalUnits();
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const rows = container.querySelectorAll('.presentation-row');
            rows.forEach((row, index) => {
                row.querySelector('.text-sm').textContent = `درس ${index + 1}`;
            });
            rowCount = rows.length;
        }

        function handlePresentationChange(e) {
            const select = e.target;
            const row = select.closest('.presentation-row');
            const infoDiv = row.querySelector('.presentation-info');
            const daySpan = row.querySelector('.presentation-day');
            const timeSpan = row.querySelector('.presentation-time');
            const masterSpan = row.querySelector('.presentation-master');

            if (select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const unit = parseInt(selectedOption.getAttribute('data-unit')) || 0;
                const day = selectedOption.getAttribute('data-day');
                const start = selectedOption.getAttribute('data-start');
                const finish = selectedOption.getAttribute('data-finish');
                const master = selectedOption.getAttribute('data-master');
                const lesson = selectedOption.getAttribute('data-lesson');

                infoDiv.classList.remove('hidden');
                daySpan.textContent = day;
                timeSpan.textContent = `${start} - ${finish}`;
                masterSpan.textContent = master;

                if (!selectedPresentations.includes(select.value)) {
                    totalUnits += unit;
                    selectedPresentations.push(select.value);
                }
            } else {
                infoDiv.classList.add('hidden');
            }

            updateTotalUnits();
        }

        addButton.addEventListener('click', addPresentationRow);

        container.querySelectorAll('.presentation-select').forEach(select => {
            select.addEventListener('change', handlePresentationChange);
        });

        container.querySelectorAll('.remove-row').forEach(button => {
            button.addEventListener('click', function() {
                removePresentationRow(this.closest('.presentation-row'));
            });
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            let isValid = true;

            const studentSelect = document.querySelector('select[name="student_id"]');
            if (!studentSelect.value) {
                showError(studentSelect, 'انتخاب دانشجو الزامی است');
                isValid = false;
            } else {
                clearError(studentSelect);
            }

            const presentationSelects = document.querySelectorAll('.presentation-select');
            let hasPresentation = false;

            presentationSelects.forEach(select => {
                if (select.value) {
                    hasPresentation = true;
                    clearError(select);
                } else {
                    showError(select, 'انتخاب حداقل یک ارائه الزامی است');
                    isValid = false;
                }
            });

            if (!hasPresentation) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                const firstError = form.querySelector('.border-red-300');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        function showError(input, message) {
            const parent = input.parentElement.parentElement;
            let errorElement = parent.querySelector('.text-red-600');

            if (!errorElement) {
                errorElement = document.createElement('p');
                errorElement.className = 'text-sm text-red-600 flex items-center gap-1 mt-1';
                errorElement.innerHTML = `<i class="fas fa-exclamation-circle text-sm"></i> ${message}`;
                parent.appendChild(errorElement);
            }

            input.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
            input.classList.remove('border-gray-300');
        }

        function clearError(input) {
            const parent = input.parentElement.parentElement;
            const errorElement = parent.querySelector('.text-red-600');
            if (errorElement) {
                errorElement.remove();
            }

            input.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
            input.classList.add('border-gray-300');
        }
    });
</script>
@endpush
