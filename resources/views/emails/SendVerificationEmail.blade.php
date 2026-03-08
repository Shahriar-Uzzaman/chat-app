@extends('layouts.email')

@section('title', 'Email Verification')

@section('content')
    <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
        <p style="margin-bottom: 16px;">Hello {{ $name }},</p>
        <p style="margin-bottom: 24px;">Your verification code is:</p>
        <div style="text-align: center; margin-bottom: 24px;">
            <span style="display: inline-block; background-color: #f3f4f6; font-size: 24px; font-weight: 700; padding: 16px 32px; border-radius: 4px; letter-spacing: 0.1em; border: 1px solid #e5e7eb;">{{ $otp }}</span>
        </div>
        <p style="font-size: 14px; color: #4b5563; margin-top: 24px;">This code will expire in 10 minutes.</p>
    </div>
@endsection
