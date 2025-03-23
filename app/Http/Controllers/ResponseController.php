<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
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

    /**
     * @OA\Get(
     *     path="/api/responses/{ticket_id}",
     *     summary="Get a list of all responses for a ticket",
     *     description="Retrieve all responses for a given ticket",
     *     operationId="getResponsesForTicket",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of responses",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Response"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
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
    public function update(UpdateResponseRequest $request, string $id)
    {
        $validated = $request->validated();

        $updatedResponse = $this->responseService->updateResponse($id, [
            'response' => $validated['response']
        ]);

        return response()->json($updatedResponse);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->responseService->deleteResponse($id);
        return response()->json(['message' => 'Response deleted successfully']);
    }
}
