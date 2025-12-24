@extends('layouts.app')

@section('title', 'لیست استادها')
@section('page-title', 'مدیریت استادها')
@section('page-subtitle', 'ایجاد، ویرایش و حذف اساتید آموزشی')

@section('content')
<div class="space-y-6 page-animate">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $totalMasters }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">کل اساتید</h4>
            <p class="text-white/90 text-sm">تعداد کل اساتید سیستم</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activeMasters }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">اساتید فعال</h4>
            <p class="text-white/90 text-sm">در حال تدریس</p>
        </div>

        <!-- ویجت دکترا -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $phdCount }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">دارای دکترا</h4>
            <p class="text-white/90 text-sm">اساتید با مدرک دکتری</p>
        </div>

        <!-- ویجت غیرفعال -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-user-slash text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $inactiveMasters }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">اساتید غیرفعال</h4>
            <p class="text-white/90 text-sm">مرخصی یا غیرفعال</p>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">لیست اساتید</h3>
                <p class="text-sm text-gray-600 mt-1">مدیریت کامل اساتید آموزشی</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('masters.index') }}" class="flex-1 md:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="input-modern pr-10 w-full"
                               placeholder="جستجوی استاد...">
                    </div>
                </form>

                <select name="status" onchange="this.form.submit()"
                        class="input-modern w-full md:w-auto">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    <option value="sabbatical" {{ request('status') == 'sabbatical' ? 'selected' : '' }}>مرخصی</option>
                </select>

                <a href="{{ route('masters.create') }}"
                   class="btn-primary flex items-center justify-center gap-2 px-6 py-3 whitespace-nowrap">
                    <i class="fas fa-user-plus"></i>
                    افزودن استاد جدید
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
                        <th class="p-4 text-right font-semibold text-gray-700">استاد</th>
                        <th class="p-4 text-right font-semibold text-gray-700">مدرک</th>
                        <th class="p-4 text-right font-semibold text-gray-700">تخصص‌ها</th>
                        <th class="p-4 text-right font-semibold text-gray-700">وضعیت</th>
                        <th class="p-4 text-center font-semibold text-gray-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($masters as $master)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                        {{ $loop->iteration % 2 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $loop->iteration + (($masters->currentPage() - 1) * $masters->perPage()) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $master->name }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($master->email)
                                        <a href="mailto:{{ $master->email }}" class="text-xs text-gray-500 hover:text-blue-600">
                                            <i class="fas fa-envelope ml-1"></i>{{ Str::limit($master->email, 20) }}
                                        </a>
                                        @endif
                                        @if($master->phone)
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-phone ml-1"></i>{{ $master->phone }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="text-sm text-gray-700">
                                {{ $master->graduation }}
                            </div>
                        </td>

                        <td class="p-4">
                            @if($master->specialties)
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(',', $master->specialties) as $specialty)
                                @if(trim($specialty))
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                    {{ trim($specialty) }}
                                </span>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @php
                                $statusConfig = [
                                    'active' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                                    'inactive' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle'],
                                    'sabbatical' => ['color' => 'bg-amber-100 text-amber-800', 'icon' => 'fa-calendar-alt']
                                ];
                                $config = $statusConfig[$master->status] ?? $statusConfig['active'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full {{ $config['color'] }} text-sm">
                                <i class="fas {{ $config['icon'] }} text-xs"></i>
                                {{ $master->status == 'active' ? 'فعال' : ($master->status == 'inactive' ? 'غیرفعال' : 'مرخصی') }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('masters.edit', $master) }}"
                                   class="w-9 h-9 rounded-lg border border-blue-300 bg-blue-50 flex items-center justify-center
                                          text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition"
                                   title="ویرایش">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <button onclick="confirmDelete({{ $master->id }}, '{{ $master->name }}')"
                                        class="w-9 h-9 rounded-lg border border-red-300 bg-red-50 flex items-center justify-center
                                               text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>

                                <form id="delete-form-{{ $master->id }}"
                                      action="{{ route('masters.destroy', $master) }}"
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
                                    <i class="fas fa-user-graduate text-2xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700">استادی یافت نشد</h4>
                                    <p class="text-gray-500 mt-1">می‌توانید اولین استاد را اضافه کنید</p>
                                </div>
                                <a href="{{ route('masters.create') }}"
                                   class="btn-primary inline-flex items-center gap-2 mt-2">
                                    <i class="fas fa-user-plus"></i>
                                    افزودن استاد
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($masters->hasPages())
        <div class="p-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    نمایش
                    <span class="font-medium">{{ $masters->firstItem() }}</span>
                    تا
                    <span class="font-medium">{{ $masters->lastItem() }}</span>
                    از
                    <span class="font-medium">{{ $masters->total() }}</span>
                    نتیجه
                </div>
                <div class="flex items-center gap-2">
                    {{ $masters->links() }}
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
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            html: `<div class="text-right">
                     <p class="mb-3">آیا می‌خواهید استاد زیر را حذف کنید؟</p>
                     <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-graduate text-red-600"></i>
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
