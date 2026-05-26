<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificarEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $enlace;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $enlace)
    {
        $this->nombre = $nombre;
        $this->enlace = $enlace;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Activa tu cuenta - La Botica Natural')
                    ->view('emails.verificar-email');
    }
}
