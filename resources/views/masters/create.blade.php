@extends('layouts.app')

@section('title', 'افزودن استاد')
@section('page-title', 'افزودن استاد جدید')
@section('page-subtitle', 'اطلاعات استاد جدید را وارد کنید')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('masters.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-chalkboard-teacher ml-2"></i>
                استادها
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">افزودن استاد جدید</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="فرم افزودن استاد" icon="fas fa-user-plus" class="mb-6">
        <form action="{{ route('masters.store') }}" method="POST" class="space-y-6">
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
                           placeholder="مثلاً: دکتر احمد احمدی"

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
                    مدرک تحصیلی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-graduation-cap text-gray-400"></i>
                    </div>
                    <input type="text" name="graduation" value="{{ old('graduation') }}"
                           class="input-modern pr-10 @error('graduation') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                           placeholder="مثلاً: دکترای مهندسی نرم‌افزار"
                           >
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
                    زمینه‌های تخصصی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-tags text-gray-400"></i>
                    </div>
                    <input type="text" name="specialties" value="{{ old('specialties') }}"
                           class="input-modern pr-10"
                           placeholder="مثلاً: هوش مصنوعی، پایگاه داده، شبکه‌های کامپیوتری">
                </div>
                <p class="text-xs text-gray-500">تخصص‌های استاد را با کاما جدا کنید</p>
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
                        <input type="radio" name="status" value="sabbatical"
                               {{ old('status') == 'sabbatical' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">مرخصی تحصیلی</span>
                    </label>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                          placeholder="توضیحاتی درباره استاد...">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-user-plus"></i>
                    ثبت استاد جدید
                </button>

                <a href="{{ route('masters.index') }}"
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
                <span>حتماً از عنوان علمی (دکتر، مهندس، استاد) استفاده کنید</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>مدرک تحصیلی باید دقیق و کامل وارد شود</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-500 mt-0.5"></i>
                <span>وضعیت "فعال" برای استادانی که در ترم جاری تدریس می‌کنند</span>
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
        const graduationInput = form.querySelector('input[name="graduation"]');

        form.addEventListener('submit', function(e) {
            let isValid = true;

            if (!nameInput.value.trim()) {
                showError(nameInput, 'نام استاد الزامی است');
                isValid = false;
            } else if (nameInput.value.trim().length < 3) {
                showError(nameInput, 'نام باید حداقل ۳ کاراکتر باشد');
                isValid = false;
            } else {
                clearError(nameInput);
            }

            if (!graduationInput.value.trim()) {
                showError(graduationInput, 'مدرک تحصیلی الزامی است');
                isValid = false;
            } else if (graduationInput.value.trim().length < 2) {
                showError(graduationInput, 'مدرک تحصیلی باید معتبر باشد');
                isValid = false;
            } else {
                clearError(graduationInput);
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
