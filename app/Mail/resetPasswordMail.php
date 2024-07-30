<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class resetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $nama;
    private $email;
    /**
     * Create a new message instance.
     */
    public function __construct($token,$nama, $email)
    {
        $this->token = $token;
        $this->nama = $nama;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Reset Password')
            ->view('email.resetPassword')
            ->with('token', $this->token)
            ->with('nama', $this->nama)
            ->with('email', $this->email);
    }

    public function attachments(): array
    {
        return [];
    }
}
