<?php

namespace App\Mail;

use App\Models\Oficio;
use App\Models\Viajero;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ViajeroFinalizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $viajero;
    public $oficio;

    /**
     * Create a new message instance.
     */
    public function __construct(Viajero $viajero, Oficio $oficio)
    {
        $this->viajero = $viajero;
        $this->oficio = $oficio;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Los resultados en un viajero han sido actualizados: #' .$this->viajero->folio . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.viajero_finalizado',
        );
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
