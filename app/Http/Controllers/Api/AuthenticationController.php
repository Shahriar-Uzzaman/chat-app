<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\authentication\ForgotPasswordRequest;
use App\Http\Requests\authentication\LoginRequest;
use App\Http\Requests\authentication\RegisterRequest;
use App\Http\Requests\authentication\ResetPasswordRequest;
use App\Http\Requests\authentication\VerifyEmailRequest;
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

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return $this->success($this->authService->verifyEmail($request->validated()), "Your email has been successfully verified");
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->success($this->authService->forgotPassword($request->validated()), "Password reset link has been sent to your email");
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->success($this->authService->resetPassword($request->validated()), "Your password has been successfully reset");
    }
}
