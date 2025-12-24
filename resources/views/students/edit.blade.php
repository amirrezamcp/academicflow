@extends('layouts.app')

@section('title', 'ویرایش دانشجو')
@section('page-title', 'ویرایش دانشجو')
@section('page-subtitle', 'ویرایش اطلاعات دانشجوی ' . $student->name)

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
                <span class="text-sm font-medium text-gray-500">ویرایش دانشجو</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="ویرایش دانشجو" icon="fas fa-user-edit"
            :badge="['text' => $student->status == 'active' ? 'فعال' : ($student->status == 'inactive' ? 'غیرفعال' : 'فارغ التحصیل'),
                    'class' => $student->status == 'active' ? 'badge-success' : ($student->status == 'inactive' ? 'badge-warning' : 'badge-info')]">

        <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="text-red-500 ml-1">*</span>
                    نام و نام خانوادگی
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}"
                           class="input-modern pr-10 @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
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
                        <option value="کارشناسی" {{ old('graduation', $student->graduation) == 'کارشناسی' ? 'selected' : '' }}>کارشناسی</option>
                        <option value="کارشناسی ارشد" {{ old('graduation', $student->graduation) == 'کارشناسی ارشد' ? 'selected' : '' }}>کارشناسی ارشد</option>
                        <option value="دکتری" {{ old('graduation', $student->graduation) == 'دکتری' ? 'selected' : '' }}>دکتری</option>
                        <option value="کاردانی" {{ old('graduation', $student->graduation) == 'کاردانی' ? 'selected' : '' }}>کاردانی</option>
                        <option value="دیپلم" {{ old('graduation', $student->graduation) == 'دیپلم' ? 'selected' : '' }}>دیپلم</option>
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
                    <input type="text" name="student_number" value="{{ old('student_number', $student->student_number) }}"
                           class="input-modern pr-10">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    ایمیل
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}"
                           class="input-modern pr-10">
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
                    <input type="tel" name="phone" value="{{ old('phone', $student->phone) }}"
                           class="input-modern pr-10">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    وضعیت
                </label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="active"
                               {{ old('status', $student->status) == 'active' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">فعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive"
                               {{ old('status', $student->status) == 'inactive' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">غیرفعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="graduated"
                               {{ old('status', $student->status) == 'graduated' ? 'checked' : '' }}
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
                          class="input-modern resize-none">{{ old('description', $student->description) }}</textarea>
            </div>

            @if($student->gpa || $student->selections_count > 0)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-chart-line"></i>
                    اطلاعات آکادمیک
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                    @if($student->gpa)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span>معدل کل:</span>
                        <span class="font-medium">{{ number_format($student->gpa, 2) }}</span>
                    </div>
                    @endif
                    @if($student->selections_count > 0)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-book text-blue-500"></i>
                        <span>تعداد واحدها:</span>
                        <span class="font-medium">{{ $student->selections_count }}</span>
                    </div>
                    @endif
                    @if($student->created_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-plus text-green-500"></i>
                        <span>تاریخ ثبت:</span>
                        <span class="font-medium">{{ $student->created_at->format('Y/m/d') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>

                <a href="{{ route('students.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

</div>
@endsection
