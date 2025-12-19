<?php

namespace App\Http\Controllers;

use App\Jobs\SendChristmasEmailJob;
use App\Models\User;
use Illuminate\Http\Request;

class ChristmasEmailController extends Controller
{
    /**
     * Dispara e-mails de Natal para todos os usuários da base.
     * Envia 5 e-mails por minuto para evitar problemas com rate limiting.
     */
    public function send()
    {
        $users = User::whereNotNull('email')
                     ->where('email', '!=', '')
                     ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum usuário encontrado na base.'
            ], 404);
        }

        $totalUsers = $users->count();
        $emailsPerMinute = 5;
        $delayInSeconds = 60; // 1 minuto

        foreach ($users as $index => $user) {
            // Calcula o delay baseado no índice
            // A cada 5 e-mails, adiciona 1 minuto de delay
            $batchNumber = floor($index / $emailsPerMinute);
            $delay = $batchNumber * $delayInSeconds;

            SendChristmasEmailJob::dispatch($user)
                ->delay(now()->addSeconds($delay));
        }

        // Calcula o tempo estimado para enviar todos os e-mails
        $totalBatches = ceil($totalUsers / $emailsPerMinute);
        $estimatedMinutes = $totalBatches - 1; // Primeira batch não tem delay

        return response()->json([
            'success' => true,
            'message' => "Envio de e-mails de Natal iniciado!",
            'total_usuarios' => $totalUsers,
            'emails_por_minuto' => $emailsPerMinute,
            'tempo_estimado' => $estimatedMinutes > 0
                ? "{$estimatedMinutes} minuto(s)"
                : "Menos de 1 minuto",
            'total_batches' => $totalBatches
        ]);
    }

    /**
     * Exibe uma página de confirmação antes de enviar os e-mails.
     */
    public function index()
    {
        $totalUsers = User::whereNotNull('email')
                          ->where('email', '!=', '')
                          ->count();

        return view('emails.christmas-confirm', compact('totalUsers'));
    }
}
