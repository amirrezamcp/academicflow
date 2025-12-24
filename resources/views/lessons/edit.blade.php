@extends('layouts.app')

@section('title', 'ویرایش درس')
@section('page-title', 'ویرایش درس')
@section('page-subtitle', 'ویرایش اطلاعات درس ' . $lesson->name)

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('lessons.index') }}" class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600">
                <i class="fas fa-book-open ml-2"></i>
                درس‌ها
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <a href="{{ route('lessons.show', $lesson) }}" class="text-sm text-gray-700 hover:text-primary-600">
                    {{ Str::limit($lesson->name, 20) }}
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-left text-gray-400 mx-1"></i>
                <span class="text-sm font-medium text-gray-500">ویرایش</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-w-2xl mx-auto page-animate">

    <x-card title="ویرایش درس" icon="fas fa-edit"
            :badge="['text' => 'کد: ' . ($lesson->code ?? 'ندارد'), 'class' => 'badge-info']">

        <form action="{{ route('lessons.update', $lesson) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                    <input type="text" name="name" value="{{ old('name', $lesson->name) }}"
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
                    <input type="number" name="unit" value="{{ old('unit', $lesson->unit) }}"
                           class="input-modern pr-10 @error('unit') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
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

            {{-- کد درس --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    کد درس
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" name="code" value="{{ old('code', $lesson->code) }}"
                           class="input-modern pr-10">
                </div>
            </div>

            {{-- توضیحات --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    توضیحات
                </label>
                <textarea name="description" rows="3"
                          class="input-modern resize-none">{{ old('description', $lesson->description) }}</textarea>
            </div>

            {{-- اطلاعات اضافی --}}
            @if($lesson->created_at || $lesson->updated_at)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-history"></i>
                    اطلاعات زمانی
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                    @if($lesson->created_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-plus-circle text-green-500"></i>
                        <span>ایجاد شده در:</span>
                        <span class="font-medium">{{ verta($lesson->created_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    @endif
                    @if($lesson->updated_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-edit text-blue-500"></i>
                        <span>آخرین ویرایش:</span>
                        <span class="font-medium">{{ verta($lesson->updated_at)->format('Y/m/d H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- دکمه‌های عملیات --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="btn-primary flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-save"></i>
                    ذخیره تغییرات
                </button>

                <a href="{{ route('lessons.show', $lesson) }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-eye"></i>
                    مشاهده درس
                </a>

                <a href="{{ route('lessons.index') }}"
                   class="btn-outline flex-1 flex items-center justify-center gap-2 py-3">
                    <i class="fas fa-times"></i>
                    انصراف
                </a>
            </div>
        </form>
    </x-card>

</div>
@endsection
