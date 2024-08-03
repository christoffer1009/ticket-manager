@props(['type', 'message'])

@php
    $color = match ($type) {
        'success' => 'bg-green-50 text-green-600',
        'error' => 'bg-red-50 text-red-600',
        default => 'bg-gray-50 text-gray-600',
    };
@endphp

<div x-data="{ show: true, timeout: null }" x-show="show" x-init="timeout = setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform opacity-0 translate-y-4"
    x-transition:enter-end="transform opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="transform opacity-100 translate-y-0"
    x-transition:leave-end="transform opacity-0 translate-y-4"
    class="fixed z-50 max-w-xs p-4 mb-4 rounded-lg shadow-lg top-5 right-5 {{ $color }}" role="alert">
    <div class="flex items-center">
        <div class="flex-shrink-0 w-8 h-8 text-white">
            @if ($type === 'success')
                <i class="text-green-300 fas fa-check-circle"></i>
            @else
                <i class="text-red-300 fas fa-times-circle"></i>
            @endif
        </div>
        <div class="flex-1 mr-4 text-sm font-normal">{{ $message }}</div>
        <button type="button" @click="show = false; clearTimeout(timeout)" class="ml-4 {{ $color }}">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
