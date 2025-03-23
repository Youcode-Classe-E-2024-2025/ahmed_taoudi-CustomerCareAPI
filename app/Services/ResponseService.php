<?php

namespace App\Services;

use App\Models\Response;

class ResponseService
{
    public function createResponse(array $data)
    {
        return Response::create($data);
    }

    public function updateResponse(string $id, array $data)
    {
        $response = Response::findOrFail($id);
        $response->update($data);
        return $response;
    }

    public function deleteResponse(string $id)
    {
        $response = Response::findOrFail($id);
        $response->delete();
        return $response;
    }

    public function getResponsesForTicket(string $ticketId)
    {
        return Response::where('ticket_id', $ticketId)->get();
    }

    public function getResponseById(string $id)
    {
        return Response::findOrFail($id);
    }
}
