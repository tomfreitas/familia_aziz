<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAgradecimento extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Obrigado pela sua contribuição!')
                    ->view('emails.agradecimento')
                    ->with([
                        'usuario' => $this->usuario,
                    ]);
    }
}
