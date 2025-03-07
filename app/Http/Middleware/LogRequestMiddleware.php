<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Récupérer l'adresse IP de l'utilisateur
        $ip = $request->ip();
        $method = $request->method();
        $url = $request->fullUrl();

        // Journaliser les informations
        Log::info("Requête entrante : [$method] $url - IP: $ip");

        return $next($request);
    }
}
