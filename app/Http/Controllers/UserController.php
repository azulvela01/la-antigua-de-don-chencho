<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // LISTA DE USUARIOS
    public function index()
    {
        $usuariosActivos = User::where('is_active', true)->get();
        $usuariosInactivos = User::where('is_active', false)->get();
        $adminCount = User::where('rol', 'administrador')->count();

        return view('admin.usuarios.index', compact(
            'usuariosActivos',
            'usuariosInactivos',
            'adminCount'
        ));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $adminCount = User::where('rol', 'administrador')->count();
        return view('admin.usuarios.create', compact('adminCount'));
    }

    // GUARDAR NUEVO USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'regex:/^(?!.*(\d)\1{1,})(?!.*[a-zA-Z]{2,})/'
            ],
            'rol' => 'required|in:administrador,usuario',
        ], [
            'password.regex' => 'La contraseña no puede tener números repetidos (11, 22) ni letras consecutivas (ab, XY).',
        ]);

        $adminCount = User::where('rol', 'administrador')->count();
        if ($request->rol === 'administrador' && $adminCount >= 3) {
            return back()->withErrors(['rol' => 'Máximo 3 administradores permitidos.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'puede_ver_inventario' => $request->boolean('puede_ver_inventario', false),
            'is_active' => true,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // FORMULARIO EDITAR
    public function edit(User $user)
    {
        $adminCount = User::where('rol', 'administrador')->count();
        return view('admin.usuarios.edit', compact('user', 'adminCount'));
    }

    // ACTUALIZAR USUARIO
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rol' => 'required|in:administrador,usuario',
        ]);

        // Límite de 3 administradores
        $adminCount = User::where('rol', 'administrador')->count();
        $cambiandoARolAdmin = $request->rol === 'administrador' && $user->rol !== 'administrador';

        if ($cambiandoARolAdmin && $adminCount >= 3) {
            return back()->withErrors(['rol' => 'No se puede asignar más de 3 administradores.']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'puede_ver_inventario' => $request->boolean('puede_ver_inventario', $user->puede_ver_inventario),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // DAR DE BAJA (ELIMINAR FÍSICAMENTE)
    public function destroy(User $user)
    {
        if ($user->id === auth()->id() || $user->esAdmin()) {
            return back()->withErrors(['error' => 'No se puede eliminar este usuario.']);
        }

        $user->delete(); // Borrado físico
        return back()->with('success', 'Usuario eliminado permanentemente.');
    }

    // REACTIVAR
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);
        return back()->with('success', 'Usuario reactivado.');
    }

    // SUSPENDER / REACTIVAR
    public function toggleSuspend(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes suspenderte a ti mismo.']);
        }

        $user->update(['is_active' => !$user->is_active]);
        $estado = $user->is_active ? 'reactivado' : 'suspendido';
        return back()->with('success', "Usuario {$estado}.");
    }

    // DAR PERMISO DE INVENTARIO
    public function otorgarPermiso(User $user)
    {
        if ($user->esAdmin()) {
            return back();
        }

        $user->update(['puede_ver_inventario' => true]);
        return back()->with('success', 'Permiso de inventario otorgado.');
    }
}