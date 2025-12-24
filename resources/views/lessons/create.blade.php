@extends('layouts.app')

@section('title', 'افزودن درس')
@section('page-title', 'افزودن درس جدید')
@section('page-subtitle', 'اطلاعات درس جدید را وارد کنید')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('lessons.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-book-open ml-2"></i>
                درس‌ها
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">افزودن درس جدید</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="فرم افزودن درس" icon="fas fa-plus-circle" class="mb-6">
        <form action="{{ route('lessons.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- نام درس --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    نام درس
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="input-modern pr-10 @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                           placeholder="مثلاً: پایگاه داده‌ها"
                           required
                           autofocus>
                </div>
                @error('name')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- تعداد واحد --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    تعداد واحد
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="number" name="unit" value="{{ old('unit') }}"
                           class="input-modern pr-10 @error('unit') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                           placeholder="مثلاً: ۳"
                           min="1" max="6"
                           required>
                </div>
                @error('unit')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- کد درس (اختیاری) --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    کد درس
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" name="code" value="{{ old('code') }}"
                           class="input-modern pr-10"
                           placeholder="مثلاً: CS-301">
                </div>
                <p class="text-xs text-gray-500">کد اختصاصی درس (در صورت تمایل)</p>
            </div>

            {{-- توضیحات --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                          placeholder="توضیحاتی درباره درس...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-check-circle"></i>
                    ثبت درس جدید
                </button>

                <a href="{{ route('lessons.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

    {{-- راهنما --}}
    <x-card title="راهنمای پر کردن فرم" icon="fas fa-info-circle" class="bg-blue-50 border-blue-100">
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>نام درس باید واضح و مرتبط با محتوای آموزشی باشد</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>تعداد واحد معمولاً بین ۱ تا ۴ واحد است</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>کد درس برای شناسایی سریعتر در سیستم استفاده می‌شود</span>
            </li>
        </ul>
    </x-card>

</div>
@endsection

@push('scripts')
<script>
    // اعتبارسنجی سمت کلاینت
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const nameInput = form.querySelector('input[name="name"]');
        const unitInput = form.querySelector('input[name="unit"]');

        form.addEventListener('submit', function(e) {
            let isValid = true;

            // اعتبارسنجی نام درس
            if (!nameInput.value.trim()) {
                showError(nameInput, 'نام درس الزامی است');
                isValid = false;
            } else if (nameInput.value.trim().length < 3) {
                showError(nameInput, 'نام درس باید حداقل ۳ کاراکتر باشد');
                isValid = false;
            } else {
                clearError(nameInput);
            }

            // اعتبارسنجی واحد
            if (!unitInput.value) {
                showError(unitInput, 'تعداد واحد الزامی است');
                isValid = false;
            } else if (unitInput.value < 1 || unitInput.value > 6) {
                showError(unitInput, 'تعداد واحد باید بین ۱ تا ۶ باشد');
                isValid = false;
            } else {
                clearError(unitInput);
            }

            if (!isValid) {
                e.preventDefault();
                // اسکرول به اولین خطا
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
