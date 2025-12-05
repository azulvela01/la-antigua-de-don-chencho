<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Validation\ValidationException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinutes(3, 3) // 3 intentos cada 3 minutos
                ->by($request->ip() . '|' . strtolower($request->input('email')))
                ->response(function () {
                    throw ValidationException::withMessages([
                        'email' => 'Demasiados intentos. Inténtalo de nuevo en 3 minutos.',
                    ]);
                });
        });
    }
}