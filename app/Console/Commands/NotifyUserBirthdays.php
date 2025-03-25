<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class NotifyUserBirthdays extends Command
{
    protected $signature = 'notify:birthdays';
    protected $description = 'Gera notificações para aniversários dos usuários';

    public function handle()
    {

        $today = Carbon::today();

        // Buscando usuários cujo aniversário é hoje
        $users = User::whereMonth('aniversário', $today->month)
                     ->whereDay('aniversário', $today->day)
                     ->get();

        foreach ($users as $user) {
            Notification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tipo' => 'aniversário',
                    'mensagem' => "Hoje é o aniversário de <a class='text-yellow' href='/users/{$user->id}'>$user->nome!</a> 🎉",
                ],
                ['status' => 'não enviada']
            );
        }

        $this->info('Notificações de aniversários geradas com sucesso!');
    }
}



