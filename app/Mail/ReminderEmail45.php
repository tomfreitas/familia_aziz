<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderEmail45 extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Lembrete: Contribua com nossa ONG!')
            ->view('emails.reminder-email-45') // Blade para o conteúdo do e-mail
            ->with([
                'nome' => $this->usuario->nome,
                'data_mantenedor' => $this->usuario->data_mantenedor,
            ]);
    }
}
