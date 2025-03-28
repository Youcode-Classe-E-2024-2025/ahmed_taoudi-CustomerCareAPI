<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Services\ActivityLogService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    protected $responseService;
    protected $activityLogService;

    public function __construct(ResponseService $responseService,ActivityLogService $activityLogService)
    {
        $this->responseService = $responseService;
        $this->activityLogService = $activityLogService;
    }

    /**
     * Display a listing of the resource.
     */
/**
     * @OA\Get(
     *     path="/api/responses/ticket/{ticket_id}",
     *     summary="Get a list of all responses for a ticket",
     *     description="Retrieve all responses for a given ticket by its ID",
     *     operationId="getResponsesForTicket",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="ticket_id",
     *         in="path",
     *         required=true,
     *         description="The ID of the ticket for which responses are being retrieved",
     *         @OA\Schema(
     *             type="string",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of responses for the specified ticket",
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

    /**
     * @OA\Post(
     *     path="/api/responses",
     *     summary="Create a new response",
     *     description="Creates a new response for a ticket",
     *     operationId="createResponse",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ticket_id", "response"},
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="response", type="string", example="This is the response.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Response created successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Response"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StoreResponseRequest $request)
    {
        $validated = $request->validated();

        $response = $this->responseService->createResponse([
            'ticket_id' => $validated['ticket_id'],
            'user_id' => Auth::id(),
            'response' => $validated['response']
        ]);

        $this->activityLogService->log(
            'created',
            'Response created',
            'Response',
            $response->id
        );

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/responses/{id}",
     *     summary="Get a specific response by ID",
     *     description="Retrieve a specific response using its ID",
     *     operationId="getResponseById",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the response",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Response details",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Response"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Response not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function show(string $id)
    {
        $response = $this->responseService->getResponseById($id);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/responses/{id}",
     *     summary="Update an existing response",
     *     description="Updates a specific response by its ID",
     *     operationId="updateResponse",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the response",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"response"},
     *             @OA\Property(property="response", type="string", example="Updated response.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Response updated successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Response"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Response not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(UpdateResponseRequest $request, string $id)
    {
        $response = $this->responseService->getResponseById($id);

        if ($response->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validated();

        $updatedResponse = $this->responseService->updateResponse($id, [
            'response' => $validated['response']
        ]);

        $this->activityLogService->log(
            'updated',
            'Response updated',
            'Response',
            $updatedResponse->id
        );

        return response()->json($updatedResponse);
    }


    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/responses/{id}",
     *     summary="Delete a specific response",
     *     description="Deletes a response by its ID",
     *     operationId="deleteResponse",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the response to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Response deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Response deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Response not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $response = $this->responseService->getResponseById($id);

        if ($response->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->responseService->deleteResponse($id);
        
        $this->activityLogService->log(
            'deleted',
            'Response deleted',
            'Response',
            $id
        );
        
        return response()->json(['message' => 'Response deleted successfully']);
    }
}
