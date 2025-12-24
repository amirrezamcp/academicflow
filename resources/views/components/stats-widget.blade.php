<div class="bg-gradient-to-br {{ $color }} rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
            <i class="{{ $icon }} text-2xl"></i>
        </div>
        <span class="text-3xl font-bold drop-shadow-sm">{{ $value }}</span>
    </div>
    <h4 class="font-bold text-lg mb-2">{{ $title }}</h4>
    @if($description)
    <p class="text-white/90 text-sm mb-3">{{ $description }}</p>
    @endif

    @if($trend && is_array($trend))
    <div class="flex items-center text-sm pt-3 border-t border-white/20">
        @php
            $trendIcon = match($trend['direction'] ?? 'up') {
                'up' => 'fa-arrow-up',
                'down' => 'fa-arrow-down',
                'stable' => 'fa-minus',
                default => 'fa-chart-line'
            };

            $trendColor = match($trend['direction'] ?? 'up') {
                'up' => 'text-green-300',
                'down' => 'text-red-300',
                'stable' => 'text-yellow-300',
                default => 'text-white'
            };
        @endphp
        <i class="fas {{ $trendIcon }} {{ $trendColor }} ml-1"></i>
        <span class="text-white/80">
            {{ $trend['value'] ?? '' }}% {{ $trend['text'] ?? '' }}
        </span>
    </div>
    @endif
</div>
