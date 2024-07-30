<?php

namespace App\Jobs;

use App\Mail\resetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class resetPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $token;
    private $nama;
    private $email;
    /**
     * Create a new job instance.
     */
    public function __construct($token,$nama, $email)
    {
        $this->token = $token;
        $this->nama = $nama;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new resetPasswordMail($this->token,$this->nama ,$this->email);
        Mail::to($this->email)->queue($mail);
    }
}
