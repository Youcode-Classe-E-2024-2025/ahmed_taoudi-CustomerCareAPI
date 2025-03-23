<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="CustomerCareAPI",
 *     version="1.0",
 *     description="API for managing customer service tickets, assigning them to agents, tracking their status, and logging all activities."
 * )
 * 
 * @OA\Schema(
 *     schema="Ticket",
 *     type="object",
 *     required={"id", "user_id", "title", "description", "status", "created_at", "updated_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the ticket",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user who created the ticket",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the ticket",
 *         example="Login Issue"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Detailed description of the issue",
 *         example="Unable to log in with correct credentials"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Current status of the ticket",
 *         example="open"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the ticket was created",
 *         example="2025-03-21T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the ticket was last updated",
 *         example="2025-03-21T12:30:00Z"
 *     )
 * )
 *  @OA\Schema(
 *     schema="Response",
 *     type="object",
 *     required={"id", "ticket_id", "user_id", "response", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="ticket_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=5),
 *     @OA\Property(property="response", type="string", example="This is a response to the ticket."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-23T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-23T12:34:56Z")
 * )

 */

class swagger {}
