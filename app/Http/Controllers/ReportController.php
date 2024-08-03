<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {


        $statusCounts = Ticket::groupBy('status_id')
            ->selectRaw('status_id, count(*) as count')
            ->get()
            ->keyBy('status_id')
            ->map(function ($item) {
                return $item->count;
            });

        $priorityCounts = Ticket::groupBy('priority_id')
            ->selectRaw('priority_id, count(*) as count')
            ->get()
            ->keyBy('priority_id')
            ->map(function ($item) {
                return $item->count;
            });


        $totalTickets = $statusCounts->sum();


        // Obter todos os statuses
        $statuses = Status::all();

        $priorities = Priority::all();

        // Preparar dados para o gráfico
        $ticketStatusData = [
            'labels' => $statuses->map(function ($status) {
                return $status->name;
            })->toArray(),
            'values' => $statuses->map(function ($status) use ($statusCounts) {
                return $statusCounts->get($status->id, 0);
            })->toArray()
        ];


        $ticketPriorityData = [
            'labels' => $priorities->map(function ($priority) {
                return $priority->name;
            })->toArray(),
            'values' => $priorities->map(function ($priority) use ($priorityCounts) {
                return $priorityCounts->get($priority->id, 0);
            })->toArray()
        ];

        $startDate = Carbon::now()->subMonth(); // Get data for the past month
        $endDate = Carbon::now();

        $timeData = [
            'labels' => [],
            'created' => [],
            'closed' => []
        ];

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $timeData['labels'][] = $date->format('Y-m-d');
            $timeData['created'][] = Ticket::whereDate('created_at', $date)->count();
            $timeData['closed'][] = Ticket::whereDate('closed_at', $date)->count();
        }


        // Get a list of the technicians who have answered the most tickets
        $topTechnicians = Ticket::whereNotNull('closed_at')
            ->select('assignee_id')
            ->groupBy('assignee_id')
            ->orderByRaw('count(*) desc')
            ->withCount('assignee')
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'name' => $ticket->assignee->name,
                    'total' => $ticket->assignee_count
                ];
            });

        return view('reports', compact('ticketStatusData', 'ticketPriorityData', 'totalTickets', 'timeData', 'topTechnicians'));
    }
}
