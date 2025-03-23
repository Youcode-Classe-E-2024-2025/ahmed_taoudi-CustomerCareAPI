<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResponseRequest;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $ticketId)
    {
        $responses = $this->responseService->getResponsesForTicket($ticketId);
        return response()->json($responses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResponseRequest $request)
    {
        $validated = $request->validated();

        $response = $this->responseService->createResponse([
            'ticket_id' => $validated['ticket_id'],
            'user_id' => Auth::id(),
            'response' => $validated['response']
        ]);

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->responseService->getResponseById($id);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
