<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $this->authorize('create', $ticket);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'author_id' => Auth::user()->id,
            'ticket_id' => $ticket->id,
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Comment created successfully.');
    }

    public function edit(string $ticketId, string $commentId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $comment = Comment::findOrFail($commentId);
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment', 'ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ticketId, string $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('tickets.show', $comment->ticket_id)->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticketId, string $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->route('tickets.show', $comment->ticket_id)->with('success', 'Comment deleted successfully.');
    }
}
