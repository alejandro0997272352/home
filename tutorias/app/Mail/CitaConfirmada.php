<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CitaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $cita) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cita de Tutoría Confirmada',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cita-confirmada',
        );
    }
}
