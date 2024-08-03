@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Ticket Details</h1>
        <x-ticket-details :ticket="$ticket" :users="$users" :statuses="$statuses" />

        <x-comment-section :ticket="$ticket" />
    </div>
@endsection
