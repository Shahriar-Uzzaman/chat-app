@extends('layouts.email')

@section('title', 'Password Reset OTP')

@section('content')
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #333 text-align: center;">Reset Your Password</h2>
        <p style="color: #555; font-size: 16px;">
            Hello {{ $name ?? 'User' }},
        </p>
        <p style="color: #555; font-size: 16px;">
            We received a request to reset your password. Use the OTP code below to complete the process.
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; padding: 15px 25px; font-size: 24px; font-weight: bold; color: #fff; background-color: #007bff; border-radius: 5px; letter-spacing: 5px;">
                {{ $otp }}
            </span>
        </div>
        <p style="color: #555; font-size: 16px;">
            If you did not request a password reset, you can safely ignore this email. Your password will remain unchanged.
        </p>
        <p style="color: #555; font-size: 16px;">
            Regards,<br>
            {{ config('app.name') }} Team
        </p>
    </div>
@endsection
