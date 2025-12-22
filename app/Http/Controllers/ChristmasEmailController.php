<?php

namespace App\Http\Controllers;

use App\Mail\ChristmasEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ChristmasEmailController extends Controller
{
    /**
     * Dispara e-mails de Natal para todos os usuários da base.
     * Envia todos de uma vez.
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

        $enviados = 0;
        $erros = [];

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new ChristmasEmail($user));
                Log::info("E-mail de Natal enviado para: {$user->nome} ({$user->email})");
                $enviados++;
            } catch (\Exception $e) {
                Log::error("Erro ao enviar e-mail de Natal para {$user->email}: " . $e->getMessage());
                $erros[] = $user->email;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Envio de e-mails de Natal concluído!",
            'total_usuarios' => $users->count(),
            'enviados' => $enviados,
            'erros' => count($erros),
            'emails_com_erro' => $erros
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
