{{-- resources/views/components/modal.blade.php --}}
<div id="{{ $id }}" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         onclick="hideModal('{{ $id }}')"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto
                    transform transition-all page-animate">
            <div class="p-6">
                @if(isset($title))
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
                    <button onclick="hideModal('{{ $id }}')"
                            class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                @endif

                <div class="{{ isset($title) ? 'mt-4' : '' }}">
                    {{ $slot }}
                </div>

                @if(isset($actions))
                <div class="mt-6 flex justify-end gap-3">
                    {{ $actions }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
