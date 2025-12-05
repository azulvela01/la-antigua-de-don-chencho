<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Mostrar formulario de login con CAPTCHA de imágenes
    public function showLoginForm(Request $request)
    {
        $opciones = ['pajaro', 'perro', 'gato'];
        $codigoCaptcha = $opciones[array_rand($opciones)];
        $request->session()->put('captcha_code', $codigoCaptcha);

        $imagenes = [
            'pajaro' => 'https://images.unsplash.com/photo-1646195268080-fd8392f92b07?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8cCVDMyVBMWphcm8lMjBhenVsfGVufDB8fDB8fHww&fm=jpg&q=60&w=3000',
            'perro'  => 'https://cdn.shopify.com/s/files/1/0574/2939/3591/files/raza-husky-siberiano_600x600.jpg?v=1681814189',
            'gato'   => 'https://content.elmueble.com/medio/2022/06/07/gato-erik-jan-leusink-ibpxglgjimi-unsplash_21d35523_1280x853.jpg',
        ];

        $imagenesAleatorias = [];
        $posicionCorrecta = rand(0, 2);
        $imagenesAleatorias[$posicionCorrecta] = [
            'animal' => $codigoCaptcha,
            'url' => $imagenes[$codigoCaptcha]
        ];

        $keysRestantes = array_values(array_diff($opciones, [$codigoCaptcha]));
        $j = 0;
        for ($i = 0; $i < 3; $i++) {
            if ($i === $posicionCorrecta) continue;
            $animal = $keysRestantes[$j++];
            $imagenesAleatorias[$i] = [
                'animal' => $animal,
                'url' => $imagenes[$animal]
            ];
        }
        ksort($imagenesAleatorias);

        return view('auth.login', compact('imagenesAleatorias', 'codigoCaptcha'));
    }

    // Procesar login con CAPTCHA + Throttling + Sesión única
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha_seleccion' => 'required',
        ]);

        // Validar CAPTCHA
        if ($request->input('captcha_seleccion') !== $request->session()->get('captcha_code')) {
            $opciones = ['pajaro', 'perro', 'gato'];
            $request->session()->put('captcha_code', $opciones[array_rand($opciones)]);
            return back()->withErrors(['captcha' => 'Selecciona la imagen correcta.'])->withInput();
        }

        // Throttling (máx 3 intentos cada 3 minutos)
        $key = 'login|' . $request->ip() . '|' . strtolower($request->email);
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => view('auth.partials.throttle-countdown', ['seconds' => $seconds])->render()
            ])->withInput();
        }

        // Intentar login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user = Auth::user();
            $nuevoToken = \Illuminate\Support\Str::random(60);

            // Guardar token único y última actividad
            $user->forceFill([
                'session_token' => $nuevoToken,
                'last_activity' => now(),
            ])->save();

            // Guardar token en la sesión actual
            $request->session()->put('session_token', $nuevoToken);

            return redirect()->intended('/home');
        }

        RateLimiter::hit($key, 180);
        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput();
    }

    // Cerrar sesión limpiando todo
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->forceFill([
                'session_token' => null,
                'last_activity' => null,
            ])->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Has cerrado sesión correctamente');
    }
}