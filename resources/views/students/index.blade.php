@extends('layouts.app')

@section('title', 'دانشجویان')
@section('page-title', 'مدیریت دانشجویان')
@section('page-subtitle', 'لیست دانشجویان و اطلاعات آن‌ها')

@section('content')
<div class="space-y-6 page-animate">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- ویجت کل دانشجویان -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $totalStudents }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">کل دانشجویان</h4>
            <p class="text-white/90 text-sm">تعداد کل دانشجویان سیستم</p>
        </div>

        <!-- ویجت دانشجویان فعال -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activeStudents }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">دانشجویان فعال</h4>
            <p class="text-white/90 text-sm">در حال تحصیل</p>
        </div>

        <!-- ویجت فارغ التحصیلان -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $graduatedStudents }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">فارغ التحصیلان</h4>
            <p class="text-white/90 text-sm">پایان دوره تحصیلی</p>
        </div>

        <!-- ویجت میانگین معدل -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ number_format($avgGpa, 2) }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">میانگین معدل</h4>
            <p class="text-white/90 text-sm">میانگین معدل دانشجویان</p>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">لیست دانشجویان</h3>
                <p class="text-sm text-gray-600 mt-1">مدیریت کامل اطلاعات دانشجویان</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('students.index') }}" class="flex-1 md:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="input-modern pr-10 w-full"
                               placeholder="جستجوی دانشجو...">
                    </div>
                </form>

                <select name="graduation" onchange="this.form.submit()"
                        class="input-modern w-full md:w-auto">
                    <option value="">همه مقاطع</option>
                    <option value="کارشناسی" {{ request('graduation') == 'کارشناسی' ? 'selected' : '' }}>کارشناسی</option>
                    <option value="کارشناسی ارشد" {{ request('graduation') == 'کارشناسی ارشد' ? 'selected' : '' }}>کارشناسی ارشد</option>
                    <option value="دکتری" {{ request('graduation') == 'دکتری' ? 'selected' : '' }}>دکتری</option>
                </select>

                <a href="{{ route('students.create') }}"
                   class="btn-primary flex items-center justify-center gap-2 px-6 py-3 whitespace-nowrap">
                    <i class="fas fa-user-plus"></i>
                    دانشجوی جدید
                </a>
            </div>
        </div>
    </div>

    <div class="card-modern overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-right font-semibold text-gray-700">#</th>
                        <th class="p-4 text-right font-semibold text-gray-700">دانشجو</th>
                        <th class="p-4 text-right font-semibold text-gray-700">اطلاعات تحصیلی</th>
                        <th class="p-4 text-right font-semibold text-gray-700">وضعیت</th>
                        <th class="p-4 text-center font-semibold text-gray-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($students as $student)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                        {{ $loop->iteration % 2 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $loop->iteration + (($students->currentPage() - 1) * $students->perPage()) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $student->name }}</h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        @if($student->student_number)
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-hashtag ml-1"></i>{{ $student->student_number }}
                                        </span>
                                        @endif
                                        @if($student->email)
                                        <a href="mailto:{{ $student->email }}" class="text-xs text-gray-500 hover:text-blue-600">
                                            <i class="fas fa-envelope ml-1"></i>ایمیل
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">مقطع:</span>
                                    <span class="font-medium text-gray-900">{{ $student->graduation }}</span>
                                </div>
                                @if($student->gpa !== null)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">معدل:</span>
                                    <span class="font-medium {{ $student->gpa >= 12 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($student->gpa, 2) }}
                                        @if($student->gpa >= 12)
                                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                                        @else
                                            <i class="fas fa-arrow-down text-xs mr-1"></i>
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="p-4">
                            @php
                                $statusConfig = [
                                    'active' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle', 'text' => 'فعال'],
                                    'inactive' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle', 'text' => 'غیرفعال'],
                                    'graduated' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-graduation-cap', 'text' => 'فارغ التحصیل']
                                ];
                                $config = $statusConfig[$student->status] ?? $statusConfig['active'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full {{ $config['color'] }} text-sm">
                                <i class="fas {{ $config['icon'] }} text-xs"></i>
                                {{ $config['text'] }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('students.edit', $student) }}"
                                   class="w-9 h-9 rounded-lg border border-blue-300 bg-blue-50 flex items-center justify-center
                                          text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition"
                                   title="ویرایش">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <button onclick="confirmDelete({{ $student->id }}, '{{ $student->name }}')"
                                        class="w-9 h-9 rounded-lg border border-red-300 bg-red-50 flex items-center justify-center
                                               text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>

                                <form id="delete-form-{{ $student->id }}"
                                      action="{{ route('students.destroy', $student) }}"
                                      method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-2xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700">دانشجویی یافت نشد</h4>
                                    <p class="text-gray-500 mt-1">می‌توانید اولین دانشجو را اضافه کنید</p>
                                </div>
                                <a href="{{ route('students.create') }}"
                                   class="btn-primary inline-flex items-center gap-2 mt-2">
                                    <i class="fas fa-user-plus"></i>
                                    افزودن دانشجو
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
        <div class="p-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    نمایش
                    <span class="font-medium">{{ $students->firstItem() }}</span>
                    تا
                    <span class="font-medium">{{ $students->lastItem() }}</span>
                    از
                    <span class="font-medium">{{ $students->total() }}</span>
                    نتیجه
                </div>
                <div class="flex items-center gap-2">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, studentName) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            html: `<div class="text-right">
                     <p class="mb-3">آیا می‌خواهید دانشجوی زیر را حذف کنید؟</p>
                     <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-graduate text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800">${studentName}</h4>
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
