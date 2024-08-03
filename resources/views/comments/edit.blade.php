@extends('layouts.app')

@section('content')
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Edit Comment</h1>

        <form action="{{ route('comments.update', [$ticket->id, $comment->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="content" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"
                placeholder="Edit your comment...">{{ $comment->content }}</textarea>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update
                Comment</button>
        </form>
    </div>
@endsection
