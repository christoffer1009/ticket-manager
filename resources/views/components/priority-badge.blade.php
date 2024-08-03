@props(['priority'])


@php
    $color = match ($priority->name) {
        'low' => 'bg-green-200 text-green-800',
        'medium' => 'bg-yellow-200 text-yellow-800',
        'high' => 'bg-orange-200 text-orange-800',
        'critical' => 'bg-red-200 text-red-800',
        default => 'bg-green-200 text-green-800',
    };
@endphp

<span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $color }}">
    {{ ucfirst($priority->name) }}
</span>
