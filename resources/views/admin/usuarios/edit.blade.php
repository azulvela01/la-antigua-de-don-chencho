@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0 fw-bold">Editar Usuario: {{ $user->name }}</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.usuarios.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rol</label>
                            <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>
                                <option value="usuario" {{ $user->rol === 'usuario' ? 'selected' : '' }}>Usuario</option>
                                <option value="administrador" {{ $user->rol === 'administrador' ? 'selected' : '' }}
                                        {{ $adminCount >= 3 && $user->rol !== 'administrador' ? 'disabled' : '' }}>
                                    Administrador ({{ $adminCount }}/3)
                                </option>
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Inventario -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="puede_ver_inventario" class="form-check-input" value="1"
                                       {{ $user->puede_ver_inventario ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Puede ver inventario</label>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection