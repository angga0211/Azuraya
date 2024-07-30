<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newProdukMail extends Mailable
{
    use Queueable, SerializesModels;
    private $nama;
    private $produk;
    private $harga;
    /**
     * Create a new message instance.
     */
    public function __construct($nama, $produk, $harga)
    {
       $this->nama = $nama;
       $this->produk = $produk;
       $this->harga = $harga;
    } 

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Produk',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.newProduk',
        );
    }
    public function build()
    {
         return $this->subject('New Produk')
            ->view('email.newProduk')
            ->with('nama', $this->nama)
            ->with('namaProduk', $this->produk)
            ->with('harga', $this->harga);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
