@extends('layouts.app')

@section('title', 'لیست ارائه‌ها')
@section('page-title', 'مدیریت ارائه‌ها')
@section('page-subtitle', 'برنامه‌های تدریس و کلاس‌ها')

@section('content')
<div class="space-y-6 page-animate">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $totalPresentations }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">کل ارائه‌ها</h4>
            <p class="text-white/90 text-sm">تعداد کل ارائه‌های سیستم</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-play-circle text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activePresentations }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">ارائه‌های فعال</h4>
            <p class="text-white/90 text-sm">در حال برگزاری</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activeMasters }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">استادان فعال</h4>
            <p class="text-white/90 text-sm">در حال تدریس</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <span class="text-3xl font-bold">{{ $activeLessons }}</span>
            </div>
            <h4 class="font-bold text-lg mb-2">درس‌های فعال</h4>
            <p class="text-white/90 text-sm">در حال ارائه</p>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">لیست ارائه‌ها</h3>
                <p class="text-sm text-gray-600 mt-1">برنامه‌ریزی تدریس و کلاس‌ها</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('presentations.index') }}" class="flex-1 md:w-64">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="input-modern pr-10 w-full"
                               placeholder="جستجوی ارائه...">
                    </div>
                </form>

                <select name="day" onchange="this.form.submit()"
                        class="input-modern w-full md:w-auto">
                    <option value="">همه روزها</option>
                    @foreach(['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه'] as $day)
                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>

                <a href="{{ route('presentations.create') }}"
                   class="btn-primary flex items-center justify-center gap-2 px-6 py-3 whitespace-nowrap">
                    <i class="fas fa-calendar-plus"></i>
                    ارائه جدید
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
                        <th class="p-4 text-right font-semibold text-gray-700">استاد / درس</th>
                        <th class="p-4 text-right font-semibold text-gray-700">زمان</th>
                        <th class="p-4 text-right font-semibold text-gray-700">وضعیت</th>
                        <th class="p-4 text-center font-semibold text-gray-700">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($presentations as $presentation)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                        {{ $loop->iteration % 2 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $loop->iteration + (($presentations->currentPage() - 1) * $presentations->perPage()) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $presentation->master->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $presentation->master->graduation }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 pr-12">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $presentation->lesson->name }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $presentation->lesson->unit }} واحد
                                            @if($presentation->lesson->code)
                                                • {{ $presentation->lesson->code }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-day text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $presentation->day_hold }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-amber-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">
                                            {{ $presentation->start_time }} - {{ $presentation->finish_time }}
                                        </span>
                                    </div>
                                </div>
                                @if($presentation->location)
                                <div class="flex items-center gap-2 mt-1">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                    <span class="text-xs text-gray-600">{{ $presentation->location }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="p-4">
                            @php
                                $status = $presentation->status ?? 'active';
                                $statusConfig = [
                                    'active' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-play-circle', 'text' => 'فعال'],
                                    'inactive' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-pause-circle', 'text' => 'غیرفعال'],
                                    'completed' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-check-circle', 'text' => 'پایان یافته']
                                ];
                                $config = $statusConfig[$status] ?? $statusConfig['active'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full {{ $config['color'] }} text-sm">
                                <i class="fas {{ $config['icon'] }} text-xs"></i>
                                {{ $config['text'] }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('presentations.edit', $presentation) }}"
                                   class="w-9 h-9 rounded-lg border border-blue-300 bg-blue-50 flex items-center justify-center
                                          text-blue-600 hover:bg-blue-100 hover:text-blue-800 transition"
                                   title="ویرایش">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <button onclick="confirmDelete({{ $presentation->id }}, '{{ $presentation->master->name }} - {{ $presentation->lesson->name }}')"
                                        class="w-9 h-9 rounded-lg border border-red-300 bg-red-50 flex items-center justify-center
                                               text-red-600 hover:bg-red-100 hover:text-red-800 transition"
                                        title="حذف">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>

                                <form id="delete-form-{{ $presentation->id }}"
                                      action="{{ route('presentations.destroy', $presentation) }}"
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
                                    <i class="fas fa-calendar-alt text-2xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-700">ارائه‌ای یافت نشد</h4>
                                    <p class="text-gray-500 mt-1">می‌توانید اولین ارائه را ایجاد کنید</p>
                                </div>
                                <a href="{{ route('presentations.create') }}"
                                   class="btn-primary inline-flex items-center gap-2 mt-2">
                                    <i class="fas fa-calendar-plus"></i>
                                    ایجاد ارائه
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($presentations->hasPages())
        <div class="p-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    نمایش
                    <span class="font-medium">{{ $presentations->firstItem() }}</span>
                    تا
                    <span class="font-medium">{{ $presentations->lastItem() }}</span>
                    از
                    <span class="font-medium">{{ $presentations->total() }}</span>
                    نتیجه
                </div>
                <div class="flex items-center gap-2">
                    {{ $presentations->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, presentationName) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            html: `<div class="text-right">
                     <p class="mb-3">آیا می‌خواهید ارائه زیر را حذف کنید؟</p>
                     <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-red-800">${presentationName}</h4>
                                    <p class="text-sm text-red-600">این عمل قابل بازگشت نیست!</p>
                                </div>
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
