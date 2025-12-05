@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bienvenido, {{ Auth::user()->name }}</h4>
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title">Acciones disponibles</h5>

                    <div class="d-grid gap-3 mt-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-lg">
                            Catálogo de Usuarios
                        </a>

                        <a href="{{ route('inventario.index') }}" class="btn btn-secondary btn-lg">
                            Ver Inventario
                        </a>

                        <!-- NUEVO BOTÓN DE REPORTES -->
                        <a href="{{ route('reportes.semanal') }}" class="btn btn-success btn-lg">
                            Reporte Semanal de Movimientos
                        </a>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection