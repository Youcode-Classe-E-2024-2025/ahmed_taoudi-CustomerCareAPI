<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketService
{
    /**
     * Get a list of tickets with pagination.
     */
    public function getTickets(?string $status = null)
    {
        // return Ticket::with('user')->paginate(6);
        $query = Ticket::with('user');
        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate(6);
    }

    /**
     * Create a new ticket.
     *
     * @param array $data
     * @return Ticket
     */
    public function createTicket(array $data)
    {
        return Ticket::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'open',
        ]);
    }

    /**
     * Get a specific ticket by its ID.
     *
     * @param string $id
     * @return Ticket
     */
    public function getTicketById(string $id)
    {
        return Ticket::with('responses.user', 'user')->findOrFail($id);
    }

    /**
     * Update a ticket's information.
     *
     * @param string $id
     * @param array $data
     * @return Ticket
     */
    public function updateTicket(string $id, array $data)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update($data);
        
        return $ticket;
    }

    /**
     * Delete a ticket.
     *
     * @param string $id
     * @return bool
     */
    public function deleteTicket(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        return $ticket->delete();
    }
}
