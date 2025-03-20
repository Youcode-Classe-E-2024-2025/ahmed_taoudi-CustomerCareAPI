<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->authService->register($request);
        return response()->json(['user' => $user], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $result = $this->authService->login($request);
        return response()->json($result);
    }

    public function logout()
    {
        $this->authService->logout(Auth::user());
        return response()->json(['message' => 'Logout successful']);
    }
}
