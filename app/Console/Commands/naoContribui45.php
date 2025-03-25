<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class naoContribui45 extends Command
{
    protected $signature = 'send:nao-contribui-45';
    protected $description = 'Envia e-mails automáticos para usuários que não contribuíram nos últimos 45 dias ou desde o cadastro.';

    public function handle()
    {
        $today = Carbon::now();

        $usuarios = User::with(['contributions'])->get();

        foreach ($usuarios as $usuario) {
            $ultimaContribuicao = $usuario->contributions->max('data_pgto');
            $dataBase = $ultimaContribuicao ?? $usuario->data_mantenedor;

            if ($dataBase && Carbon::parse($dataBase)->addDays(45)->isSameDay($today)) {
                // Enviar e-mail
                Mail::to($usuario->email)->send(new \App\Mail\ReminderEmail45($usuario));

                $this->info("E-mail enviado para: {$usuario->email}");
            }
        }
    }
}

