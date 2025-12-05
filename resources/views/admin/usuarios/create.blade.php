@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0 fw-bold">Crear Nuevo Usuario</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.usuarios.store') }}">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contraseña</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rol</label>
                            <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>
                                <option value="usuario">Usuario</option>
                                <option value="administrador"
                                        {{ $adminCount >= 3 ? 'disabled' : '' }}>
                                    Administrador ({{ $adminCount }}/3)
                                </option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Puede ver inventario -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="puede_ver_inventario" id="puede_ver_inventario"
                                       class="form-check-input" value="1">
                                <label class="form-check-label fw-semibold" for="puede_ver_inventario">
                                    Puede ver el inventario
                                </label>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection