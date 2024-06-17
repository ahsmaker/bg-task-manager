<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $registerResult = $this->authService->register($request->validated());

        return response()->json($registerResult, 201);
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function login(LoginRequest $request)
    {
        $loginResult = $this->authService->login($request->validated());

        return response()->json($loginResult);
    }
}
