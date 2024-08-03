@props(['status'])

@php
    $color = match ($status->name) {
        'open' => 'bg-green-200 text-green-800',
        'closed' => 'bg-red-200 text-red-800',
        'in progress' => 'bg-yellow-200 text-yellow-800',
        default => 'bg-gray-200 text-gray-800',
    };
@endphp

<span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $color }}">
    {{ ucfirst($status->name) }}
</span>
