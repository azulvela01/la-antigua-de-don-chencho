<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Verifica que el usuario sea administrador y esté activo.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Debes iniciar sesión.');
        }

        $user = Auth::user();

        if (!$user->esAdmin()) {
            return redirect('/home')->with('error', 'Acceso denegado. Solo administradores.');
        }

        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'Tu cuenta está suspendida. Contacta al administrador.');
        }

        return $next($request);
    }
}