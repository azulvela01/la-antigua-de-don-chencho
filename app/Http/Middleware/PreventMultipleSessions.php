<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventMultipleSessions
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // CIERRE POR INACTIVIDAD (2 minutos)
            if ($user->last_activity && now()->diffInSeconds($user->last_activity) > 120) {
                Auth::logout();
                return redirect('/login')->with('error', 'Sesión cerrada por inactividad (2 minutos)');
            }

            // CIERRE SI EL TOKEN CAMBIÓ (otro navegador)
            $tokenActual = $request->session()->get('session_token');
            if ($user->session_token && $user->session_token !== $tokenActual) {
                Auth::logout();
                return redirect('/login')->with('error', 'Has iniciado sesión en otro navegador. Esta sesión ha sido cerrada.');
            }

            // ACTUALIZA EN CADA PETICIÓN
            $user->forceFill([
                'session_token' => $tokenActual,
                'last_activity' => now(),
            ])->save();
        }

        return $next($request);
    }
}