<?php

namespace App\Mail;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockBajoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡ALERTA! Stock Bajo - Panadería La Antigua',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stock-bajo',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}