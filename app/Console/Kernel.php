<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('notify:birthdays');
        $schedule->command('send:payment-reminders');
        $schedule->command('send:birthday-emails');
        $schedule->job(new AtualizarComunicacaoEnviada())->daily();
        $schedule->command('send:nao-contribui-45');
    }



    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
