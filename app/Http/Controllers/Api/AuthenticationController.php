<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\authentication\LoginRequest;
use App\Http\Requests\authentication\RegisterRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(public AuthenticationService $authService)
    {}

    public function login(LoginRequest $request)
    {
        return $this->success($this->authService->login($request->validated()), "You have successfully logged in");
    }

    public function register(RegisterRequest $request)
    {
        return $this->success($this->authService->register($request->validated()), "You have successfully registered");
    }

    public function verifyEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        return $this->success($this->authService->verifyEmail($data), "Your email has been successfully verified");
    }
}
