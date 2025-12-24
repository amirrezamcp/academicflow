@extends('layouts.app')

@section('title', 'ویرایش استاد')
@section('page-title', 'ویرایش استاد')
@section('page-subtitle', 'ویرایش اطلاعات استاد ' . $master->name)

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
                <span class="text-sm font-medium text-gray-500">ویرایش استاد</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="ویرایش استاد" icon="fas fa-user-edit"
            :badge="['text' => $master->status == 'active' ? 'فعال' : ($master->status == 'inactive' ? 'غیرفعال' : 'مرخصی'),
                    'class' => $master->status == 'active' ? 'badge-success' : 'badge-warning']">

        <form action="{{ route('masters.update', $master) }}" method="POST" class="space-y-6">
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
                    <input type="text" name="name" value="{{ old('name', $master->name) }}"
                           class="input-modern pr-10 @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"

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
                    <input type="text" name="graduation" value="{{ old('graduation', $master->graduation) }}"
                           class="input-modern pr-10 @error('graduation') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
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
                    <input type="text" name="specialties" value="{{ old('specialties', $master->specialties) }}"
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
                    <input type="email" name="email" value="{{ old('email', $master->email) }}"
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
                    <input type="tel" name="phone" value="{{ old('phone', $master->phone) }}"
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
                               {{ old('status', $master->status) == 'active' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">فعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive"
                               {{ old('status', $master->status) == 'inactive' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">غیرفعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="sabbatical"
                               {{ old('status', $master->status) == 'sabbatical' ? 'checked' : '' }}
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
                          class="input-modern resize-none">{{ old('description', $master->description) }}</textarea>
            </div>

            @if($master->created_at || $master->updated_at)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-history"></i>
                    اطلاعات زمانی
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                    @if($master->created_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-plus-circle text-green-500"></i>
                        <span>ایجاد شده در:</span>
                        <span class="font-medium">{{ $master->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    @endif
                    @if($master->updated_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-edit text-blue-500"></i>
                        <span>آخرین ویرایش:</span>
                        <span class="font-medium">{{ $master->updated_at->format('Y/m/d H:i') }}</span>
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

                <a href="{{ route('masters.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

</div>
@endsection
