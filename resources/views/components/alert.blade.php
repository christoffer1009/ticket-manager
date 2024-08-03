@props(['message'])


@php
    $color = match ($message->type) {
        'success' => 'text-green-800 bg-green-50',
        'error' => 'text-red-800 bg-red-50',
        'warning' => 'text-yellow-800 bg-yellow-50',
        'info' => 'text-blue-800 bg-blue-50',
        default => 'text-gray-800 bg-gray-50',
    };
@endphp


<div class="p-4 mb-4 text-sm rounded-lg {{ $color }}" role="alert">
    <span class="font-medium">{{ $message->text }}</span>
</div>
