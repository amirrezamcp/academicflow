@extends('layouts.app')

@section('title', 'افزودن دانشجو')
@section('page-title', 'افزودن دانشجوی جدید')
@section('page-subtitle', 'ثبت اطلاعات دانشجوی جدید')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('students.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-user-graduate ml-2"></i>
                دانشجویان
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">افزودن دانشجوی جدید</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="فرم افزودن دانشجو" icon="fas fa-user-plus">
        <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    نام و نام خانوادگی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="input-modern pr-10 @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                           placeholder="مثلاً: علی محمدی"
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

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    مقطع تحصیلی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-graduation-cap text-gray-400"></i>
                    </div>
                    <select name="graduation"
                            class="input-modern pr-10 appearance-none cursor-pointer
                                   @error('graduation') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                            required>
                        <option value="">انتخاب مقطع...</option>
                        <option value="کارشناسی" {{ old('graduation') == 'کارشناسی' ? 'selected' : '' }}>کارشناسی</option>
                        <option value="کارشناسی ارشد" {{ old('graduation') == 'کارشناسی ارشد' ? 'selected' : '' }}>کارشناسی ارشد</option>
                        <option value="دکتری" {{ old('graduation') == 'دکتری' ? 'selected' : '' }}>دکتری</option>
                        <option value="کاردانی" {{ old('graduation') == 'کاردانی' ? 'selected' : '' }}>کاردانی</option>
                        <option value="دیپلم" {{ old('graduation') == 'دیپلم' ? 'selected' : '' }}>دیپلم</option>
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('graduation')
                    <p class="text-sm text-red-600 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    شماره دانشجویی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" name="student_number" value="{{ old('student_number') }}"
                           class="input-modern pr-10"
                           placeholder="مثلاً: 401234567">
                </div>
                <p class="text-xs text-gray-500">در صورت تمایل وارد کنید</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    ایمیل
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-modern pr-10"
                           placeholder="example@university.ac.ir">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    شماره تماس
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="input-modern pr-10"
                           placeholder="۰۹۱۲۱۲۳۴۵۶۷">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    وضعیت
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
                        <input type="radio" name="status" value="graduated"
                               {{ old('status') == 'graduated' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">فارغ التحصیل</span>
                    </label>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none"
                          placeholder="توضیحات اضافی درباره دانشجو...">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-user-plus"></i>
                    ثبت دانشجوی جدید
                </button>

                <a href="{{ route('students.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

    <x-card title="راهنمای پر کردن فرم" icon="fas fa-info-circle" class="bg-blue-50 border-blue-100">
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>نام و نام خانوادگی باید کامل و صحیح وارد شود</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>مقطع تحصیلی باید متناسب با سطح دانشجو انتخاب شود</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>وضعیت "فعال" برای دانشجویان در حال تحصیل</span>
            </li>
        </ul>
    </x-card>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const nameInput = form.querySelector('input[name="name"]');
        const graduationSelect = form.querySelector('select[name="graduation"]');

        form.addEventListener('submit', function(e) {
            let isValid = true;

            if (!nameInput.value.trim()) {
                showError(nameInput, 'نام دانشجو الزامی است');
                isValid = false;
            } else if (nameInput.value.trim().length < 3) {
                showError(nameInput, 'نام باید حداقل ۳ کاراکتر باشد');
                isValid = false;
            } else {
                clearError(nameInput);
            }

            if (!graduationSelect.value) {
                showError(graduationSelect, 'انتخاب مقطع تحصیلی الزامی است');
                isValid = false;
            } else {
                clearError(graduationSelect);
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
