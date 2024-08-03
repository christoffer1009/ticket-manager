@extends('layouts.app')

@section('content')
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Create Ticket</h1>
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Title</label>
                <input type="text" name="title"
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="title" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                <textarea name="description"
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="description" required></textarea>
            </div>

            @if (auth()->user()->role->name === 'admin')
                <div class="mb-4">
                    <label for="status_id" class="block mb-2 text-sm font-bold text-gray-700">Status</label>
                    <select name="status_id"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        id="status_id" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mb-4">
                <label for="priority_id" class="block mb-2 text-sm font-bold text-gray-700">Priority</label>
                <select name="priority_id"
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="priority_id" required>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Create</button>
        </form>
    </div>
@endsection
