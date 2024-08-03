<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{id}/assign-to-me', [TicketController::class, 'assignToMe'])->name('tickets.assignToMe');
    Route::post('/tickets/{id}/assign-to-other', [TicketController::class, 'assignToOther'])->name('tickets.assignToOther');
    Route::put('/tickets/{id}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

    Route::post('/tickets/{ticketId}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/tickets/{ticketId}/comment/{commentId}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/tickets/{ticketId}/comment/{commentId}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/tickets/{ticketId}/comment/{commentId}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/data', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__ . '/auth.php';
