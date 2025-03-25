<?php

namespace App\Console\Commands;

use App\Mail\BirthdayEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmails extends Command
{
    protected $signature = 'send:birthday-emails';
    protected $description = 'Envia e-mails de aniversário para os usuários que fazem aniversário hoje';

    public function handle()
    {

        /* Mail::to('wellington@shalomdigital.com.br')->send(new BirthdayEmail(User::first()));
        $this->info('Teste de envio de e-mail de aniversário.'); */

        $users = User::whereRaw('DATE_FORMAT(aniversário, "%m-%d") = ?', [now()->format('m-d')])->get();

        if ($users->isEmpty()) {
            $this->info('Nenhum usuário encontrado com aniversário hoje.');
            return 0;
        }

        foreach ($users as $user) {
            $this->info("Enviando para: {$user->nome} ({$user->email})");
            Mail::to($user->email)->send(new BirthdayEmail($user));
            $this->info("E-mail de aniversário enviado para: {$user->nome}");
        }

    }
}
