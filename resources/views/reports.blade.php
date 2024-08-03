@extends('layouts.app')

@section('content')
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Ticket Status Overview</h1>

        <!-- Use the PieChart component -->
        <x-pie-chart :data="$ticketStatusData" id="ticketStatusChart" />
        <x-bar-chart :data="$ticketPriorityData" id="ticketPriorityChart" />
        <x-line-chart :data="$timeData" id="timeChart" />
        <x-top-technicians :topTechnicians="$topTechnicians" />
    </div>
@endsection
