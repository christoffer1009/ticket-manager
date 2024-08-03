@props(['ticket', 'users', 'statuses'])


@php
    $isAdmin = auth()->user()->role->name === 'admin';
    $isTechnician = auth()->user()->role->name === 'technician';
    $isAssignedToUser = auth()->user()->id === $ticket->assignee_id;
@endphp


<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="mb-4">
        <h3 class="text-xl font-semibold">Title:</h3>
        <p class="text-gray-700">{{ $ticket->title }}</p>
    </div>

    <div class="mb-4">
        <h3 class="text-xl font-semibold">Description:</h3>
        <p class="text-gray-700">{{ $ticket->description }}</p>
    </div>

    <div class="mb-4">
        <h3 class="mb-2 text-xl font-semibold">Status:</h3>
        <x-status-badge :status="$ticket->status" />
    </div>

    <div class="mb-4">
        <h3 class="mb-2 text-xl font-semibold">Priority:</h3>
        <x-priority-badge :priority="$ticket->priority" />
    </div>

    <div class="mb-4">
        <h3 class="text-xl font-semibold">Requester:</h3>
        <p class="text-gray-700">{{ $ticket->requester->name }}</p>
    </div>

    <div class="mb-4">
        <h3 class="text-xl font-semibold">Assignee:</h3>
        <p class="text-gray-700">{{ $ticket->assignee ? $ticket->assignee->name : 'None' }}</p>
    </div>

    @if (($isTechnician && !$ticket->assignee) || $isAdmin)
        <form action="{{ route('tickets.assignToMe', $ticket->id) }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Assign to
                Me</button>
        </form>
    @endif
    @if (($isTechnician && $isAssignedToUser) || $isAdmin)
        <div class="flex space-x-4">
            <a href="{{ route('tickets.edit', $ticket->id) }}"
                class="px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
    @endif
    @if ($isAdmin)
        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Delete</button>
        </form>
</div>
@endif


</div>
