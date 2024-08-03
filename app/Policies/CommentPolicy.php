<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;

class CommentPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $ticket->requester->id === $user->id || $user->role->name === 'admin' || $user->role->name === 'technician';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Ticket $ticket): bool
    {
        return $ticket->requester->id === $user->id || $user->role->name === 'admin' || $user->role->name === 'technician';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->role->name === 'admin';
    }
}
