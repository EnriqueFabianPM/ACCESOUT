<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstudianteQR extends Mailable
{
    use Queueable, SerializesModels;

    public $qrImagePath;

    /**
     * Create a new message instance.
     *
     * @param string $qrImagePath The path to the QR code image
     * @return void
     */
    public function __construct($qrImagePath)
    {
        $this->qrImagePath = $qrImagePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.EstudianteQR')
                    ->subject('¡Tu Código QR para la Visita!')
                    ->attach(public_path($this->qrImagePath), [
                        'as' => 'qr_code.jpg',
                        'mime' => 'image/jpeg',
                    ])
                    ->with('qrImagePath', $this->qrImagePath);
    }
}

