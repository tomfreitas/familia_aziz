<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AtualizarComunicacaoEnviada
{
    public function handle()
    {
        $hoje = now();

        // Usuários que passaram mais de 180 dias sem contribuir ou do cadastro
        $usuarios = User::where(function ($query) use ($hoje) {
            $query->whereDoesntHave('contributions', function ($subQuery) use ($hoje) {
                $subQuery->where('data_pgto', '>=', $hoje->subDays(180));
            })->orWhere(function ($subQuery) use ($hoje) {
                $subQuery->whereNull('comunicacao_enviada')
                         ->where('data_mantenedor', '<', $hoje->subDays(180));
            });
        })->get();

        // Atualiza o campo comunicacao_enviada
        foreach ($usuarios as $usuario) {
            $usuario->comunicacao_enviada = false;
            $usuario->save();
        }
    }
}

