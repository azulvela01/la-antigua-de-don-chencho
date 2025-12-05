@extends('layouts.app')

@section('title', 'Catálogo de Usuarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Catálogo de Usuarios</h4>
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-light btn-sm">
                        Nuevo Usuario
                    </a>
                </div>

                <div class="card-body p-0">
                    <!-- Mensajes -->
                    @if(session('success'))
                        <div class="alert alert-success m-3 mb-0 rounded-0 border-0">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger m-3 mb-0 rounded-0 border-0">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- USUARIOS ACTIVOS -->
                    <h5 class="mt-4 mx-3 fw-bold text-success">
                        Usuarios Activos ({{ $usuariosActivos->count() }})
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Inventario</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usuariosActivos as $user)
                                    <tr>
                                        <td class="fw-semibold">{{ $user->email }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $user->esAdmin() ? 'bg-danger' : 'bg-secondary' }} px-3 py-2">
                                                {{ ucfirst($user->rol) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill {{ $user->puede_ver_inventario ? 'bg-info text-white' : 'bg-light text-dark' }} px-3 py-2">
                                                {{ $user->puede_ver_inventario ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                                <!-- EDITAR -->
                                                <a href="{{ route('admin.usuarios.edit', $user) }}"
                                                   class="btn btn-warning btn-sm">
                                                    Editar
                                                </a>

                                                @if($user->id !== auth()->id())
                                                    <!-- BAJA -->
                                                    @if($user->is_active && !$user->esAdmin())
                                                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('¿Dar de baja a {{ $user->email }}?')">
                                                                Baja
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- SUSPENDER / REACTIVAR -->
                                                    <form method="POST" action="{{ route('admin.usuarios.toggle', $user) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary btn-sm"
                                                                onclick="return confirm('¿{{ $user->is_active ? 'Suspender' : 'Reactivar' }} a {{ $user->email }}?')">
                                                            {{ $user->is_active ? 'Suspender' : 'Reactivar' }}
                                                        </button>
                                                    </form>

                                                    <!-- DAR PERMISO -->
                                                    @if(!$user->esAdmin() && !$user->puede_ver_inventario)
                                                        <form method="POST" action="{{ route('admin.usuarios.permiso', $user) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-info btn-sm text-white">
                                                                Dar Permiso
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning text-dark px-3 py-2">Tú</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            No hay usuarios activos.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- USUARIOS INACTIVOS -->
                    @if($usuariosInactivos->count() > 0)
                        <h5 class="mt-4 mx-3 fw-bold text-warning">
                            Usuarios Inactivos ({{ $usuariosInactivos->count() }})
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuariosInactivos as $user)
                                        <tr class="table-light">
                                            <td><del>{{ $user->email }}</del></td>
                                            <td>
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    {{ ucfirst($user->rol) }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.usuarios.activate', $user) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Reactivar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection