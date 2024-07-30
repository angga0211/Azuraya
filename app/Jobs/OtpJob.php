<?php

namespace App\Jobs;

use App\Mail\OtpMail;
use App\Models\VerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $mail = new OtpMail($this->data['otp']);
        Mail::to($this->data['email'])->send($mail);
        VerificationCode::updateOrCreate(
            ['email' => $this->data['email']],
            ['kode' => $this->data['otp']]
        );
    }
}
