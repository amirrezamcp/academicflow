@props(['type' => 'info', 'dismissible' => true])

@php
    $classes = match($type) {
        'success' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 text-green-800',
        'error' => 'bg-gradient-to-r from-red-50 to-pink-50 border-red-200 text-red-800',
        'warning' => 'bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-gradient-to-r from-blue-50 to-cyan-50 border-blue-200 text-blue-800',
        default => 'bg-gray-50 border-gray-200 text-gray-800'
    };

    $icons = match($type) {
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
        default => 'fa-bell'
    };
@endphp

<div class="p-4 rounded-xl border {{ $classes }} shadow-sm alert-message flex items-center justify-between mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full flex items-center justify-center
            {{ match($type) {
                'success' => 'bg-green-100 text-green-600',
                'error' => 'bg-red-100 text-red-600',
                'warning' => 'bg-yellow-100 text-yellow-600',
                'info' => 'bg-blue-100 text-blue-600',
                default => 'bg-gray-100 text-gray-600'
            } }}">
            <i class="fas {{ $icons }}"></i>
        </div>
        <div>
            @if($message)
                <span class="font-medium">{{ $message }}</span>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>

    @if($dismissible)
    <button type="button"
            class="text-gray-400 hover:text-gray-600 transition"
            onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
    @endif
</div>
