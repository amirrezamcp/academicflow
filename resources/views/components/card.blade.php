<div class="card-modern p-6 {{ $class }}">
    @if($title || $badge)
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
        @if($title)
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            @if($icon)
            <i class="{{ $icon }} text-primary-600"></i>
            @endif
            {{ $title }}
        </h3>
        @endif

        @if($badge)
        @php
            $badgeClass = match($badge['class'] ?? 'info') {
                'success' => 'bg-green-100 text-green-800',
                'warning' => 'bg-yellow-100 text-yellow-800',
                'danger' => 'bg-red-100 text-red-800',
                'info' => 'bg-blue-100 text-blue-800',
                default => 'bg-gray-100 text-gray-800'
            };
        @endphp
        <span class="badge {{ $badgeClass }}">
            {{ $badge['text'] ?? '' }}
        </span>
        @endif
    </div>
    @endif

    <div class="{{ $title ? 'mt-2' : '' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
    <div class="mt-6 pt-6 border-t border-gray-100">
        {{ $footer }}
    </div>
    @endif
</div>
