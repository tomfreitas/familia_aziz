<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPasswordNotification
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable); // Obtém a URL para o reset de senha

        // Aqui você pode customizar o layout do e-mail
        return (new MailMessage)
            ->subject('Redefina sua senha')
            ->line('Recebemos uma solicitação para redefinir sua senha. Para continuar, clique no botão abaixo.')
            ->action('Resetar Senha', $url)
            ->line('Este link de reset de senha irá expirar em 60 minutos.')
            ->line('Se você não solicitou o reset, por favor, ignore este e-mail.')
            // Aqui você pode também adicionar a view personalizada
            ->view('emails.mail_reset_password', ['url' => $url]); // Usando Markdown ou Blade para o layout customizado
    }
}
