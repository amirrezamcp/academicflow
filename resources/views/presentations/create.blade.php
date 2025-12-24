@extends('layouts.app')

@section('title', 'افزودن ارائه')
@section('page-title', 'افزودن ارائه جدید')
@section('page-subtitle', 'ایجاد برنامه تدریس جدید')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('presentations.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-calendar-alt ml-2"></i>
                ارائه‌ها
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">افزودن ارائه جدید</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-3xl mx-auto page-animate">

    <x-card title="فرم افزودن ارائه" icon="fas fa-calendar-plus" class="mb-6">
        <form action="{{ route('presentations.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    استاد ارائه دهنده
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-user-graduate text-gray-400"></i>
                    </div>
                    <select name="master_id"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('master_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            
                            autofocus>
                        <option value="">انتخاب استاد...</option>
                        @foreach($masters as $master)
                            <option value="{{ $master->id }}"
                                    {{ old('master_id') == $master->id ? 'selected' : '' }}
                                    data-graduation="{{ $master->graduation }}"
                                    data-status="{{ $master->status ?? 'active' }}">
                                {{ $master->name }}
                                @if($master->status && $master->status != 'active')
                                    ({{ $master->status == 'inactive' ? 'غیرفعال' : 'مرخصی' }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('master_id')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
                <div id="master-info" class="text-xs text-gray-500 mt-1 hidden">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    درس
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <select name="lesson_id"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('lesson_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            >
                        <option value="">انتخاب درس...</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}
                                    data-unit="{{ $lesson->unit }}"
                                    data-code="{{ $lesson->code ?? '' }}">
                                {{ $lesson->name }} ({{ $lesson->unit }} واحد)
                                @if($lesson->code)
                                    - {{ $lesson->code }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('lesson_id')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
                <div id="lesson-info" class="text-xs text-gray-500 mt-1 hidden">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    روز برگزاری
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <select name="day_hold"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('day_hold') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            >
                        <option value="">انتخاب روز...</option>
                        @foreach(['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه'] as $day)
                            <option value="{{ $day }}" {{ old('day_hold') == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('day_hold')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500 ml-1">*</span>
                        ساعت شروع
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                               class="input-modern pr-10 @error('start_time') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                               >
                    </div>
                    @error('start_time')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-500 ml-1">*</span>
                        ساعت پایان
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                        <input type="time" name="finish_time" value="{{ old('finish_time') }}"
                               class="input-modern pr-10 @error('finish_time') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                               >
                    </div>
                    @error('finish_time')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    محل برگزاری
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="input-modern pr-10"
                           placeholder="مثلاً: کلاس ۱۰۱، سالن آمفی‌تئاتر">
                </div>
                <p class="text-xs text-gray-500">در صورت نیاز، محل برگزاری کلاس را مشخص کنید</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none"
                          placeholder="توضیحات اضافی درباره ارائه...">{{ old('description') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    وضعیت ارائه
                </label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="active"
                               {{ old('status', 'active') == 'active' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">فعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive"
                               {{ old('status') == 'inactive' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">غیرفعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="completed"
                               {{ old('status') == 'completed' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">پایان یافته</span>
                    </label>
                </div>
            </div>

            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h4 class="text-sm font-medium text-blue-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-eye"></i>
                    پیش‌نمایش ارائه
                </h4>
                <div id="presentation-preview" class="text-sm text-gray-600">
                    <p>پس از پر کردن فرم، اطلاعات ارائه در اینجا نمایش داده می‌شود.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-calendar-plus"></i>
                    ثبت ارائه جدید
                </button>

                <a href="{{ route('presentations.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

    <x-card title="راهنمای ایجاد ارائه" icon="fas fa-info-circle" class="bg-blue-50 border-blue-100">
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>حتماً استاد و درس مربوطه را به درستی انتخاب کنید</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>ساعت پایان باید بعد از ساعت شروع باشد</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>استادان غیرفعال را نمی‌توان برای ارائه جدید انتخاب کرد</span>
            </li>
        </ul>
    </x-card>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const masterSelect = document.querySelector('select[name="master_id"]');
        const lessonSelect = document.querySelector('select[name="lesson_id"]');
        const daySelect = document.querySelector('select[name="day_hold"]');
        const startTimeInput = document.querySelector('input[name="start_time"]');
        const finishTimeInput = document.querySelector('input[name="finish_time"]');
        const previewElement = document.getElementById('presentation-preview');
        const masterInfoElement = document.getElementById('master-info');
        const lessonInfoElement = document.getElementById('lesson-info');

        masterSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const graduation = selectedOption.getAttribute('data-graduation');
                const status = selectedOption.getAttribute('data-status');

                let statusText = '';
                if (status === 'active') statusText = 'فعال';
                else if (status === 'inactive') statusText = 'غیرفعال';
                else if (status === 'sabbatical') statusText = 'مرخصی تحصیلی';

                masterInfoElement.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="font-medium">مدرک:</span>
                        <span>${graduation}</span>
                        ${statusText ? `<span class="mr-4">•</span><span class="font-medium">وضعیت:</span> <span class="${status === 'active' ? 'text-green-600' : 'text-red-600'}">${statusText}</span>` : ''}
                    </div>
                `;
                masterInfoElement.classList.remove('hidden');
            } else {
                masterInfoElement.classList.add('hidden');
            }
            updatePreview();
        });

        lessonSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const unit = selectedOption.getAttribute('data-unit');
                const code = selectedOption.getAttribute('data-code');

                lessonInfoElement.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="font-medium">واحد:</span>
                        <span>${unit}</span>
                        ${code ? `<span class="mr-4">•</span><span class="font-medium">کد درس:</span> <span>${code}</span>` : ''}
                    </div>
                `;
                lessonInfoElement.classList.remove('hidden');
            } else {
                lessonInfoElement.classList.add('hidden');
            }
            updatePreview();
        });

        function updatePreview() {
            const masterName = masterSelect.options[masterSelect.selectedIndex]?.text || 'انتخاب نشده';
            const lessonName = lessonSelect.options[lessonSelect.selectedIndex]?.text || 'انتخاب نشده';
            const day = daySelect.value || 'انتخاب نشده';
            const startTime = startTimeInput.value || '--:--';
            const finishTime = finishTimeInput.value || '--:--';

            previewElement.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-700">استاد:</span>
                        <span>${masterName.split('(')[0].trim()}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-700">درس:</span>
                        <span>${lessonName}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-700">زمان:</span>
                        <span>${day}، از ${startTime} تا ${finishTime}</span>
                    </div>
                </div>
            `;
        }

        daySelect.addEventListener('change', updatePreview);
        startTimeInput.addEventListener('input', updatePreview);
        finishTimeInput.addEventListener('input', updatePreview);

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            let isValid = true;

            if (!masterSelect.value) {
                showError(masterSelect, 'انتخاب استاد الزامی است');
                isValid = false;
            } else {
                clearError(masterSelect);
            }

            if (!lessonSelect.value) {
                showError(lessonSelect, 'انتخاب درس الزامی است');
                isValid = false;
            } else {
                clearError(lessonSelect);
            }

            if (!daySelect.value) {
                showError(daySelect, 'انتخاب روز برگزاری الزامی است');
                isValid = false;
            } else {
                clearError(daySelect);
            }

            if (!startTimeInput.value) {
                showError(startTimeInput, 'ساعت شروع الزامی است');
                isValid = false;
            } else {
                clearError(startTimeInput);
            }

            if (!finishTimeInput.value) {
                showError(finishTimeInput, 'ساعت پایان الزامی است');
                isValid = false;
            } else {
                clearError(finishTimeInput);
            }

            if (startTimeInput.value && finishTimeInput.value) {
                if (finishTimeInput.value <= startTimeInput.value) {
                    showError(finishTimeInput, 'ساعت پایان باید بعد از ساعت شروع باشد');
                    isValid = false;
                }
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

        updatePreview();
    });
</script>
@endpush
