<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $priorityFilter = $request->input('priority');
        $statuses = Status::all();
        $priorities = Priority::all();
        $query = Ticket::query();

        if (Auth::user()->role->name === 'admin' || Auth::user()->role->name === 'technician') {
            $query->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
                ->when(
                    $statusFilter,
                    function ($query, $statusFilter) {
                        if ($statusFilter === 'notClosed') {
                            $query->whereIn('status_id', [1, 2]);
                        } else {
                            $query->where('status_id', $statusFilter);
                        }
                    }
                )
                ->when($priorityFilter, function ($query, $priorityFilter) {
                    return $query->where('priority_id', $priorityFilter);
                });
        } else {
            $query->where('requester_id', auth()->user()->id)
                ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->when($statusFilter, function ($query, $statusFilter) {
                    return $query->where('status_id', $statusFilter);
                })
                ->when($priorityFilter, function ($query, $priorityFilter) {
                    return $query->where('priority_id', $priorityFilter);
                });
        }

        $tickets = $query->orderByDesc('created_at')->paginate(10);

        return view('tickets.index', compact('tickets', 'statuses', 'priorities'));
    }


    public function create()
    {
        $this->authorize('create', Ticket::class);
        $statuses = Status::all();
        $priorities = Priority::all();
        return view('tickets.create', compact('statuses', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Ticket::class);

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            // 'status_id' => 'required|exists:statuses,id',
            'priority_id' => 'required|exists:priorities,id',
            'closed_at' => 'nullable|date',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'requester_id' => Auth::user()->id,
            'assignee_id' => null,
            'priority_id' => $request->priority_id,
            'status_id' => Status::where('name', '=', 'open')->first()->id, //default status (open)
            'closed_at' => $request->closed_at,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('view', $ticket);

        $users = [];
        $statuses = Status::all();
        if (Auth::user()->role->name === 'admin') {
            $users = User::where('role_id', 2)->get();
        }

        $ticket->load('comments');

        return view('tickets.show', compact('ticket', 'users', 'statuses'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('update', $ticket);
        $statuses = Status::all();
        $priorities = Priority::all();
        $users = User::where('role_id', 2)->orWhere('role_id', 1)->get();
        return view('tickets.edit', compact('ticket', 'statuses', 'priorities', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('update', $ticket);

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority_id' => 'required|exists:priorities,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        if ($ticket->status_id !== 3 && $request->status_id == 3) {
            $closedAt = Carbon::now();
        }

        if ($ticket->status_id === 3 && $request->status_id !== 3) {
            $closedAt = null;
        }

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'assignee_id' => $request->assignee_id ?? Auth::user()->id,
            'priority_id' => $request->priority_id,
            'status_id' => $request->status_id,
            'closed_at' => $closedAt,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('delete', $ticket);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function assignToMe(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('assign', $ticket);

        $ticket->assignee_id = Auth::user()->id;
        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket assigned successfully.');
    }

    public function assignToOther(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('assignToOther', $ticket);

        $request->validate([
            'assignee_id' => 'required|exists:users,id',
        ]);

        $ticket->assignee_id = $request->assignee_id;
        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket assigned successfully.');
    }
}
