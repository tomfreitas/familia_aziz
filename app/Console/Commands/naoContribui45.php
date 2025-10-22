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
        $today = Carbon::now()->startOfDay();

        $usuarios = User::with(['contributions'])->get();

        foreach ($usuarios as $usuario) {
            $ultimaContribuicao = $usuario->contributions->max('data_pgto');
            $dataBase = $ultimaContribuicao ?? $usuario->data_mantenedor;

            // Se não tiver base, pula
            if (!$dataBase) continue;

            $diasSemContribuir = Carbon::parse($dataBase)->diffInDays($today);

            // Envia somente se completou 45 dias
            if ($diasSemContribuir >= 45) {

                // Evita reenvio se já foi enviado hoje
                if ($usuario->comunicacao_enviada == 1 &&
                    Carbon::parse($usuario->comunicacao_enviada_em)->isSameDay($today)) {
                    continue; // já foi enviado hoje
                }

                try {
                    Mail::to($usuario->email)->send(new \App\Mail\ReminderEmail45($usuario));

                    // Atualiza campos no banco
                    $usuario->update([
                        'comunicacao_enviada' => 1,
                        'comunicacao_enviada_em' => Carbon::now(),
                    ]);

                    $this->info("E-mail enviado para: {$usuario->email}");
                } catch (\Exception $e) {
                    $this->error("Erro ao enviar para {$usuario->email}: " . $e->getMessage());
                }
            }
        }

        $this->info('Processo concluído!');
    }
}
