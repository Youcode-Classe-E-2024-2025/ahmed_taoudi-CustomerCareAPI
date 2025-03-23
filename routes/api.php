<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//  Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




Route::apiResource('tickets',TicketController::class)->middleware('auth:sanctum');

Route::resource('responses', ResponseController::class)->except('index')->middleware('auth:sanctum');
Route::get('responses/ticket/{ticket_id}',[ResponseController::class ,'index'])->middleware('auth:sanctum');
