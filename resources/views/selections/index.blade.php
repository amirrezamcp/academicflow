@extends('layouts.app')

@section('title', 'انتخاب واحد')
@section('page-title', 'مدیریت انتخاب واحد')
@section('page-subtitle', 'لیست انتخاب‌های واحد دانشجویان')

@section('content')
<div class="space-y-6 page-animate">

    {{-- آمار و اطلاعات --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- ویجت کل انتخاب‌ها -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $totalSelections }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">کل انتخاب‌ها</h4>
            <p class="text-white/90 text-sm">تعداد کل انتخاب واحدها</p>
        </div>

        <!-- ویجت دانشجویان فعال -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activeStudents }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">دانشجویان فعال</h4>
            <p class="text-white/90 text-sm">دانشجویان دارای انتخاب</p>
        </div>

        <!-- ویجت میانگین نمره -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ number_format($avgScore, 1) }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">میانگین نمره</h4>
            <p class="text-white/90 text-sm">میانگین نمرات ثبت شده</p>
        </div>

        <!-- ویجت واحدها -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $totalUnits }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">مجموع واحدها</h4>
            <p class="text-white/90 text-sm">کل واحدهای انتخاب شده</p>
        </div>
    </div>

    {{-- هدر صفحه با فیلتر --}}
    <div class="card-modern p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">لیست انتخاب واحدها</h3>
                <p class="text-sm text-gray-600 mt-1">مدیریت انتخاب‌های واحد دانشجویان</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                {{-- جستجو --}}
                <form method="GET" action="{{ route('selections.index') }}" class="flex-1 md:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="input-modern pr-10 w-full"
                               placeholder="جستجوی دانشجو یا درس...">
                    </div>
                </form>

                {{-- فیلتر سال تحصیلی --}}
                <select name="year" onchange="this.form.submit()"
                        class="input-modern w-full md:w-auto">
                    <option value="">همه سال‌ها</option>
                    @for($i = 1400; $i <= 1404; $i++)
                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>

                {{-- دکمه افزودن --}}
                <a href="{{ route('selections.create') }}"
                   class="btn-primary flex items-center justify-center gap-2 px-6 py-3 whitespace-nowrap">
                    <i class="fas fa-plus-circle"></i>
                    انتخاب واحد جدید
                </a>
            </div>
        </div>
    </div>

    {{-- جدول انتخاب‌ها --}}
    <div class="card-modern overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-right font-semibold text-gray-700">#</th>
                        <th class="p-4 text-right font-semibold text-gray-700">دانشجو</th>
                        <th class="p-4 text-right font-semibold text-gray-700">درس / استاد</th>
                        <th class="p-4 text-right font-semibold text-gray-700">واحد / نمره</th>
                        <th class="p-4 text-right font-semibold text-gray-700">سال</th>
                        <th class="p-4 text-center font-semibold text-gray-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($selections as $selection)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                        {{ $loop->iteration % 2 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $loop->iteration + (($selections->currentPage() - 1) * $selections->perPage()) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $selection->student->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $selection->student->graduation }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-100 rounded flex items-center justify-center">
                                        <i class="fas fa-book text-green-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $selection->presentation->lesson->name }}</span>
                                </div>
                                <div class="flex items-center gap-2 pr-10">
                                    <div class="w-6 h-6 bg-purple-100 rounded flex items-center justify-center">
                                        <i class="fas fa-user text-purple-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $selection->presentation->master->name }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">واحد:</span>
                                    <span class="font-medium text-gray-900">{{ $selection->presentation->lesson->unit }}</span>
                                </div>
                                @if($selection->score)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">نمره:</span>
                                    <span class="font-medium {{ $selection->score >= 12 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $selection->score }}
                                        @if($selection->score >= 12)
                                            <i class="fas fa-check text-xs mr-1"></i>
                                        @else
                                            <i class="fas fa-times text-xs mr-1"></i>
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="p-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-sm">
                                <i class="fas fa-calendar text-xs"></i>
                                {{ $selection->year_education }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- ویرایش --}}
                                <a href="{{ route('selections.edit', $selection) }}"
                                   class="w-9 h-9 rounded-lg border border-blue-300 bg-blue-50 flex items-center justify-center
                                          text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition"
                                   title="ویرایش">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                {{-- حذف --}}
                                <button onclick="confirmDelete({{ $selection->id }}, '{{ $selection->student->name }} - {{ $selection->presentation->lesson->name }}')"
                                        class="w-9 h-9 rounded-lg border border-red-300 bg-red-50 flex items-center justify-center
                                               text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>

                                {{-- فرم حذف (مخفی) --}}
                                <form id="delete-form-{{ $selection->id }}"
                                      action="{{ route('selections.destroy', $selection) }}"
                                      method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-clipboard-list text-2xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700">انتخاب واحدی یافت نشد</h4>
                                    <p class="text-gray-500 mt-1">می‌توانید اولین انتخاب واحد را ثبت کنید</p>
                                </div>
                                <a href="{{ route('selections.create') }}"
                                   class="btn-primary inline-flex items-center gap-2 mt-2">
                                    <i class="fas fa-plus-circle"></i>
                                    ثبت انتخاب واحد
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($selections->hasPages())
        <div class="p-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    نمایش
                    <span class="font-medium">{{ $selections->firstItem() }}</span>
                    تا
                    <span class="font-medium">{{ $selections->lastItem() }}</span>
                    از
                    <span class="font-medium">{{ $selections->total() }}</span>
                    نتیجه
                </div>
                <div class="flex items-center gap-2">
                    {{ $selections->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // تابع حذف با تایید
    function confirmDelete(id, selectionName) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            html: `<div class="text-right">
                     <p class="mb-3">آیا می‌خواهید انتخاب واحد زیر را حذف کنید؟</p>
                     <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800">${selectionName}</h4>
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
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    // اعمال فیلتر جستجو با تاخیر
    let searchTimeout;
    document.querySelector('input[name="search"]')?.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (e.target.value.length >= 2 || e.target.value.length === 0) {
                e.target.form.submit();
            }
        }, 500);
    });
</script>
@endpush
