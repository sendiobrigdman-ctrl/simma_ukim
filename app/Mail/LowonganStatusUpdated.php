<?php

namespace App\Mail;

use App\Models\Lowongan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowonganStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Lowongan $lowongan;
    public string $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Lowongan $lowongan, string $status)
    {
        $this->lowongan = $lowongan;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pembaharuan Status Lowongan: ' . $this->lowongan->title)
                    ->markdown('emails.lowongan.status-updated', [
                        'lowongan' => $this->lowongan,
                        'status' => $this->status,
                    ]);
    }
}
