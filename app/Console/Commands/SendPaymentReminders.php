<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Contribution;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminders extends Command
{
    protected $signature = 'send:payment-reminders';
    protected $description = 'Envia e-mails de lembrete para contribuições agendadas para amanhã';

    public function handle()
    {

        /* Mail::to('wellington@shalomdigital.com.br')->send(new BirthdayEmail(User::first()));
        $this->info('Teste de envio de e-mail de aniversário.'); */

        $tomorrow = now()->addDay();
        $users = User::where('melhor_dia', $tomorrow->day)
                     //->whereMonth('melhor_dia_oferta', $tomorrow->month)
                      ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ReminderEmail($user));
            $this->info("E-mail de lembrete enviado para: {$user->nome}");
        }

        return 0;
    }
}
