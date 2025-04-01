<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importando Auth corretamente
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!Auth::check()) {
            return route('login.index'); // Não use redirect() aqui
        }

        return null; // O Laravel já faz o redirecionamento automaticamente
    }
}
