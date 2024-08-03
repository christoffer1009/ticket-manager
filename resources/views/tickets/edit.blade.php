@extends('layouts.app')

@php
    $isAdmin = auth()->user()->role->name === 'admin';
    $isTechnician = auth()->user()->role->name === 'technician';
@endphp

@section('content')
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Edit Ticket</h1>

        <div class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">
            @if ($errors->any())
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="title">
                        Title
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="description">
                        Description
                    </label>
                    <textarea name="description" id="description"
                        class="w-full h-32 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                        required>{{ old('description', $ticket->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="status_id">
                        Status
                    </label>
                    <select name="status_id" id="status_id"
                        class="block w-full px-2 py-1 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none sm:w-1/4 md:w-1/4 hover:border-gray-500 focus:outline-none focus:shadow-outline">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ $status->id == old('status_id', $ticket->status_id) ? 'selected' : '' }}>
                                {{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="status_id">
                        Priority
                    </label>
                    <select name="priority_id" id="priority_id"
                        class="block w-full px-2 py-1 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none sm:w-1/4 md:w-1/4 hover:border-gray-500 focus:outline-none focus:shadow-outline">
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->id }}"
                                {{ $priority->id == old('priority_id', $ticket->priority_id) ? 'selected' : '' }}>
                                {{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($isAdmin)
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="assignee_id">
                            Assignee
                        </label>
                        <select name="assignee_id"
                            class="block w-full px-2 py-1 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none sm:w-1/4 md:w-1/4 hover:border-gray-500 focus:outline-none focus:shadow-outline">
                            <option value="">None</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $ticket->assignee_id === $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Update Ticket
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="inline-block text-sm font-bold text-blue-500 align-baseline hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
