<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class notifPesananMail extends Mailable
{
    use Queueable, SerializesModels;

    private $status;
    private $invoice;
    private $nama;
    private $metode;
    private $waktuPesan;
    private $alamat;
    private $level;

    public function __construct($status, $invoice, $nama, $metode, $waktuPesan, $alamat, $level)
    {
        $this->status = $status;
        $this->invoice = $invoice;
        $this->nama = $nama;
        $this->metode = $metode;
        $this->waktuPesan = $waktuPesan;
        $this->alamat = $alamat;
        $this->level = $level;
    }
    public function build()
    {
        return $this->subject('Pesanan '.$this->status)
            ->view('email.newOrder')
            ->with('status', $this->status)
            ->with('invoice', $this->invoice)
            ->with('nama', $this->nama)
            ->with('metode', $this->metode)
            ->with('waktuPesan', $this->waktuPesan)
            ->with('alamat', $this->alamat)
            ->with('level', $this->level);
    }
}
