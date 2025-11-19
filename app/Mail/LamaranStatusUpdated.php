<?php

namespace App\Mail;

use App\Models\Aplikasi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LamaranStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Aplikasi $aplikasi;

    /**
     * Create a new message instance.
     */
    public function __construct(Aplikasi $aplikasi)
    {
        $this->aplikasi = $aplikasi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Lamaran Anda Telah Diperbarui')
                    ->view('emails.lamaran.status-updated')
                    ->with(['aplikasi' => $this->aplikasi]);
    }
}
