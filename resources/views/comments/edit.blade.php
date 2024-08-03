@extends('layouts.app')

@section('content')
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Edit Comment</h1>

        <form action="{{ route('comments.update', [$ticket->id, $comment->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="content" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"
                placeholder="Edit your comment...">{{ $comment->content }}</textarea>
            <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">Update
                Comment</button>
        </form>
    </div>
@endsection
