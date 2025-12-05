<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // VALIDACIÓN: Checkbox de privacidad obligatorio
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'rol' => ['required', 'in:administrador,usuario'],
            'privacy_accepted' => ['required', 'accepted'], // OBLIGATORIO
        ]);

        // LÍMITE DE 3 ADMINISTRADORES
        if ($request->rol === 'administrador') {
            $adminCount = User::where('rol', 'administrador')->count();
            if ($adminCount >= 3) {
                return back()->withErrors([
                    'rol' => 'No se pueden crear más administradores. Límite de 3 alcanzado.'
                ])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Mensaje de bienvenida
        $adminCount = User::where('rol', 'administrador')->count();
        if ($request->rol === 'administrador' && $adminCount === 1) {
            return redirect('/home')->with('bienvenido', "¡Bienvenido, {$user->name}! Eres el primer administrador.");
        }

        return redirect('/home')->with('bienvenido', "¡Bienvenido, {$user->name}! Rol: " . ucfirst($user->rol));
    }
}