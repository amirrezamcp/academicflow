@extends('layouts.app')

@section('title', 'ویرایش ارائه')
@section('page-title', 'ویرایش ارائه')
@section('page-subtitle', 'ویرایش اطلاعات ارائه')

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
                <span class="text-sm font-medium text-gray-500">ویرایش ارائه</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-3xl mx-auto page-animate">

    <x-card title="ویرایش ارائه" icon="fas fa-edit" class="mb-6">
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-sm font-medium text-blue-700 mb-2">اطلاعات فعلی</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">استاد:</span>
                    <span class="text-gray-800">{{ $presentation->master->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">درس:</span>
                    <span class="text-gray-800">{{ $presentation->lesson->name }} ({{ $presentation->lesson->unit }} واحد)</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">زمان:</span>
                    <span class="text-gray-800">{{ $presentation->day_hold }}، {{ $presentation->start_time }} - {{ $presentation->finish_time }}</span>
                </div>
                @if($presentation->location)
                <div>
                    <span class="font-medium text-gray-600">محل:</span>
                    <span class="text-gray-800">{{ $presentation->location }}</span>
                </div>
                @endif
            </div>
        </div>

        <form action="{{ route('presentations.update', $presentation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                        @foreach($masters as $master)
                            <option value="{{ $master->id }}"
                                    {{ old('master_id', $presentation->master_id) == $master->id ? 'selected' : '' }}
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
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    {{ old('lesson_id', $presentation->lesson_id) == $lesson->id ? 'selected' : '' }}
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
                        @foreach(['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه'] as $day)
                            <option value="{{ $day }}" {{ old('day_hold', $presentation->day_hold) == $day ? 'selected' : '' }}>
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
                        <input type="time" name="start_time" value="{{ old('start_time', $presentation->start_time) }}"
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
                        <input type="time" name="finish_time" value="{{ old('finish_time', $presentation->finish_time) }}"
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
                    <input type="text" name="location" value="{{ old('location', $presentation->location) }}"
                           class="input-modern pr-10"
                           placeholder="مثلاً: کلاس ۱۰۱، سالن آمفی‌تئاتر">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none"
                          placeholder="توضیحات اضافی درباره ارائه...">{{ old('description', $presentation->description) }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    وضعیت ارائه
                </label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="active"
                               {{ old('status', $presentation->status ?? 'active') == 'active' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">فعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive"
                               {{ old('status', $presentation->status ?? 'active') == 'inactive' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">غیرفعال</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="completed"
                               {{ old('status', $presentation->status ?? 'active') == 'completed' ? 'checked' : '' }}
                               class="text-primary-600 focus:ring-primary-500">
                        <span class="mr-2">پایان یافته</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>

                <a href="{{ route('presentations.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

</div>
@endsection
