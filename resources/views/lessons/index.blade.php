@extends('layouts.app')

@section('title', 'لیست درس‌ها')
@section('page-title', 'مدیریت درس‌ها')
@section('page-subtitle', 'ایجاد، ویرایش و حذف درس‌های آموزشی')

@section('content')
<div class="space-y-6 page-animate">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-widget
            title="کل درس‌ها"
            value="{{ $totalLessons }}"
            icon="fas fa-book"
            color="from-blue-500 to-blue-600"
            description="تعداد کل درس‌های سیستم"
        />

        <x-stats-widget
            title="میانگین واحدها"
            value="{{ number_format($avgUnit, 1) }}"
            icon="fas fa-balance-scale"
            color="from-green-500 to-green-600"
            description="میانگین واحد درسی"
        />

        <x-stats-widget
            title="بیشترین واحد"
            value="{{ $maxUnit }}"
            icon="fas fa-arrow-up"
            color="from-purple-500 to-purple-600"
            description="بیشترین تعداد واحد"
        />

        <x-stats-widget
            title="کمترین واحد"
            value="{{ $minUnit }}"
            icon="fas fa-arrow-down"
            color="from-amber-500 to-amber-600"
            description="کمترین تعداد واحد"
        />
    </div>

    <x-card class="p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">لیست درس‌ها</h3>
                <p class="text-sm text-gray-600 mt-1">مدیریت کامل درس‌های آموزشی</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('lessons.index') }}" class="flex-1 md:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="input-modern pr-10 w-full"
                               placeholder="جستجوی درس...">
                    </div>
                </form>

                <a href="{{ route('lessons.create') }}"
                   class="btn-primary flex items-center justify-center gap-2 px-6 py-3 whitespace-nowrap">
                    <i class="fas fa-plus-circle"></i>
                    افزودن درس جدید
                </a>
            </div>
        </div>
    </x-card>

    <x-card class="overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern w-full">
                <thead>
                    <tr>
                        <th class="w-16 text-center">#</th>
                        <th class="min-w-48">نام درس</th>
                        <th class="min-w-32">کد درس</th>
                        <th class="min-w-24 text-center">واحد</th>
                        <th class="min-w-40">تاریخ ایجاد</th>
                        <th class="min-w-48 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                    <tr class="group hover:bg-blue-50/50 transition-colors">
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                        {{ $loop->iteration % 2 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $loop->iteration + (($lessons->currentPage() - 1) * $lessons->perPage()) }}
                            </span>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $lesson->name }}</h4>
                                    @if($lesson->description)
                                    <p class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($lesson->description, 50) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($lesson->code)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-sm">
                                <i class="fas fa-hashtag text-xs"></i>
                                {{ $lesson->code }}
                            </span>
                            @else
                            <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full
                                        {{ $lesson->unit >= 3 ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                <i class="fas fa-cube text-xs"></i>
                                {{ $lesson->unit }}
                            </span>
                        </td>

                        <td>
                            <div class="text-sm text-gray-600">
                                <div>{{ verta($lesson->created_at)->format('Y/m/d') }}</div>
                                <div class="text-xs text-gray-500">{{ verta($lesson->created_at)->format('H:i') }}</div>
                            </div>
                        </td>

                        <td>
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('lessons.show', $lesson) }}"
                                   class="w-9 h-9 rounded-lg border border-gray-300 flex items-center justify-center
                                          text-gray-600 hover:bg-gray-50 hover:text-gray-800 transition"
                                   title="مشاهده">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>

                                <a href="{{ route('lessons.edit', $lesson) }}"
                                   class="w-9 h-9 rounded-lg border border-blue-300 bg-blue-50 flex items-center justify-center
                                          text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition"
                                   title="ویرایش">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <button onclick="confirmDelete('{{ $lesson->id }}', '{{ $lesson->name }}')"
                                        class="w-9 h-9 rounded-lg border border-red-300 bg-red-50 flex items-center justify-center
                                               text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>

                                <form id="delete-form-{{ $lesson->id }}"
                                      action="{{ route('lessons.destroy', $lesson) }}"
                                      method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-book-open text-3xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700">درسی یافت نشد</h4>
                                    <p class="text-gray-500 mt-1">هنوز هیچ درسی اضافه نکرده‌اید</p>
                                </div>
                                <a href="{{ route('lessons.create') }}"
                                   class="btn-primary inline-flex items-center gap-2 mt-2">
                                    <i class="fas fa-plus"></i>
                                    افزودن اولین درس
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lessons->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    نمایش
                    <span class="font-medium">{{ $lessons->firstItem() }}</span>
                    تا
                    <span class="font-medium">{{ $lessons->lastItem() }}</span>
                    از
                    <span class="font-medium">{{ $lessons->total() }}</span>
                    نتیجه
                </div>
                <div class="flex items-center gap-2">
                    {{ $lessons->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
        @endif
    </x-card>

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            html: `<div class="text-right">
                     <p class="mb-3">آیا می‌خواهید درس زیر را حذف کنید؟</p>
                     <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800">${name}</h4>
                                <p class="text-sm text-red-600">این عمل قابل بازگشت نیست!</p>
                            </div>
                        </div>
                     </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'بله، حذف شود',
            cancelButtonText: 'انصراف',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn-primary',
                cancelButton: 'btn-outline'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (e.target.value.length >= 2 || e.target.value.length === 0) {
                e.target.form.submit();
            }
        }, 500);
    });
</script>
@endpush
