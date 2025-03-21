<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\ActivityLogService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected $ticketService;
    protected $activityLogService;

    public function __construct(TicketService $ticketService, ActivityLogService $activityLogService)
    {
        $this->ticketService = $ticketService;
        $this->activityLogService = $activityLogService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = $this->ticketService->getTickets();

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();

        $ticket = $this->ticketService->createTicket([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'] ?? 'open',
        ]);

        $this->activityLogService->log(
            'created',
            'Ticket created',
            'Ticket',
            $ticket->id
        );

        return response()->json($ticket, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        return response()->json($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, string $id)
    {
        $validated = $request->validated();

        $ticket = $this->ticketService->getTicketById($id);

        if ($ticket->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $updatedTicket = $this->ticketService->updateTicket($id, $validated);

        $this->activityLogService->log(
            'updated',
            'Ticket updated',
            'Ticket',
            $ticket->id
        );
        return response()->json($updatedTicket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = $this->ticketService->getTicketById($id);

        if ($ticket->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->ticketService->deleteTicket($id);

        $this->activityLogService->log(
            'deleted',
            'Ticket deleted',
            'Ticket',
            $ticket->id
        );

        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
