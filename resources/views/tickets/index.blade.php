@extends('layouts.app')

@section('content')
    <div x-data="{ showAlert: @json(session('success') !== null) }" @if (session('success')) x-init="setTimeout(() => showAlert = false, 3000)" @endif>

        <div class="container p-4 mx-auto">
            <h1 class="mb-4 text-2xl font-bold">Tickets</h1>

            <div class="flex justify-start mb-4">
                <a href="{{ route('tickets.create') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2  focus:outline-none">
                    Create Ticket
                </a>
            </div>

            <div class="mb-4">
                <x-filter :searchTerm="request('search')" :statuses="$statuses" :selectedStatus="request('status')" :priorities="$priorities" :selectedPriority="request('priority')" />

            </div>



            <div x-show="showAlert" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>



            <!-- Tabela de Tickets -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Title
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Priority
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Requester</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Assignee</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td
                                    class="px-6 py-4 text-sm font-medium text-left text-gray-900 break-words whitespace-normal">
                                    {{ $ticket->title }}</td>
                                <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                                    <x-status-badge :status="$ticket->status" />
                                </td>
                                <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                                    <x-priority-badge :priority="$ticket->priority" />
                                </td>
                                <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                                    {{ $ticket->requester->name }}</td>
                                <td class="px-6 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                                    {{ $ticket->assignee ? $ticket->assignee->name : 'None' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-left whitespace-nowrap">
                                    <a href="{{ route('tickets.show', $ticket->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">View</a>
                                    @if (auth()->user()->role->name === 'admin')
                                        <a href="{{ route('tickets.edit', $ticket->id) }}"
                                            class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação -->
        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection
