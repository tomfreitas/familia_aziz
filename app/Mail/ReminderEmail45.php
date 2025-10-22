<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail45 extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Um lembrete com carinho sobre sua contribuição')
            ->view('emails.reminder-email-45') // Blade para o conteúdo do e-mail
            ->with([
                'nome' => $this->usuario->nome,
                'data_mantenedor' => $this->usuario->data_mantenedor,
            ]);
    }
}
