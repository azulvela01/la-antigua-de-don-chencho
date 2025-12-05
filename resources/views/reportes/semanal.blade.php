@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Reporte Semanal de Movimientos</h1>
    <p class="mb-4">Del {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}</p>

    <div class="card">
        <div class="card-body">
            @if($movimientos->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $m)
                        <tr>
                            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $m->producto->nombre }}</td>
                            <td><strong>{{ $m->tipo == 'entrada' ? 'ENTRADA' : 'SALIDA' }}</strong></td>
                            <td>{{ $m->cantidad }}</td>
                            <td>{{ $m->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No hay movimientos esta semana.</p>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection