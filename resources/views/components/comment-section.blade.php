@props(['ticket'])

<div class="mt-8">
    <h2 class="text-xl font-bold mb-4">Comments</h2>

    <!-- Lista de Comentários -->
    @foreach ($ticket->comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach

    <!-- Formulário para Adicionar Comentário -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Add a Comment</h3>
        <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
            @csrf
            <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg p-2"
                placeholder="Write your comment..."></textarea>
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add
                Comment</button>
        </form>
    </div>
</div>
