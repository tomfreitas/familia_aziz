<?php

// app/Http/Middleware/RemoveTokenFromUrl.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveTokenFromUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Remove o parâmetro _token da query string, se existir
        $url = $request->fullUrl();
        $urlWithoutToken = preg_replace('/([&|\?]_token=)[^&]+(&|$)/', '$3', $url);

        // Atualiza a URL no objeto de requisição
        $request->server->set('REQUEST_URI', parse_url($urlWithoutToken, PHP_URL_PATH));

        return $next($request);
    }
}

