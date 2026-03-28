<?php

namespace App\Jobs;

use App\Mail\ForgorPasswordOTPEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordOTPEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $otp,
        public string $email,
        public string $name
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(
            new ForgorPasswordOTPEmail($this->otp, $this->name)
        );
    }
}
