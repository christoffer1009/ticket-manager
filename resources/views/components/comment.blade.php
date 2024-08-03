@props(['comment'])

@php
    $isAdmin = auth()->user()->role->name === 'admin';
@endphp

<div class="bg-gray-50 p-4 rounded-lg mb-4 shadow-md">
    <div class="flex items-center mb-2">
        <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
        <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <p class="text-gray-700">{{ $comment->content }}</p>

    @if ($isAdmin)
        <div class="mt-4 flex space-x-4">
            <!-- Botão de Edição -->
            <a href="{{ route('comments.edit', [$comment->ticket_id, $comment->id]) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>

            <!-- Formulário de Exclusão -->
            <form action="{{ route('comments.destroy', [$comment->ticket_id, $comment->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
            </form>
        </div>
    @endif
</div>
