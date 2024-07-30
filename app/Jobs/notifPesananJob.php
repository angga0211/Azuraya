<?php

namespace App\Jobs;

use App\Mail\notifPesananMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class notifPesananJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $status;
    private $nama;
    private $metode;
    private $invoice;
    private $waktuPesan;
    private $alamat;
    private $email;
    private $level;
    
    public function __construct($status, $nama, $metode, $invoice, $waktuPesan, $alamat, $email, $level)
    {
        $this->status = $status;
        $this->nama = $nama;
        $this->metode = $metode;
        $this->invoice = $invoice;
        $this->waktuPesan = $waktuPesan;
        $this->alamat = $alamat;
        $this->email = $email;
        $this->level = $level;
    }

    public function handle(): void
    {
        $mail = new notifPesananMail($this->status, $this->invoice, $this->nama, $this->metode, $this->waktuPesan, $this->alamat, $this->level);
        Mail::to($this->email)->send($mail);
    }
}
