@extends('layouts.app')

@section('content')
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

        <x-tickets-table :tickets="$tickets" />
    </div>

    <!-- Paginação -->
    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
@endsection
