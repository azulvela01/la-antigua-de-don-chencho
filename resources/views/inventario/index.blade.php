@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestión de Inventario - Panadería La Antigua</h4>
                </div>

                <!-- ALERTA FIJA DE STOCK BAJO (SIN MODAL, SIEMPRE VISIBLE) -->
                @if(Auth::user()->esAdmin() && $productos->where('stock', '<=', 10)->count() > 0)
                    <div class="alert alert-danger m-4 text-center" role="alert">
                        <h4 class="alert-heading">¡ALERTA DE STOCK CRÍTICO!</h4>
                        <p>Los siguientes productos tienen stock bajo:</p>
                        <ul class="list-unstyled mb-0">
                            @foreach($productos->where('stock', '<=', 10) as $p)
                                <li><strong>{{ $p->nombre }}</strong> → Solo quedan <strong>{{ $p->stock }}</strong> unidades</li>
                            @endforeach
                        </ul>
                        <hr>
                        <p class="mb-0"><strong>Se ha enviado notificación por correo a todos los administradores.</strong></p>
                    </div>
                @endif

                <!-- Formulario de Entrada -->
                <br>
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5>Registrar Entrada de Materia Prima</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('inventario.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" min="1">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="number" step="0.01" name="precio_compra" class="form-control" placeholder="Precio compra (opcional)">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success w-100">Registrar Entrada</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla de Inventario -->
                <h5>Inventario Actual</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Precio Compra</th>
                                <th>Estado</th>
                                <th>Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $producto)
                            <tr @if($producto->stock <= 10) class="table-danger" @endif>
                                <td><strong>{{ $producto->nombre }}</strong></td>
                                <td>{{ $producto->stock }} unidades</td>
                                <td>${{ number_format($producto->precio_compra, 2) }}</td>
                                <td>
                                    @if($producto->stock <= 10)
                                        <span class="badge bg-danger">Bajo</span>
                                    @else
                                        <span class="badge bg-success">Normal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->stock > 0)
                                    <form method="POST" action="{{ route('inventario.salida', $producto) }}" class="d-inline">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <input type="number" name="cantidad" class="form-control" min="1" max="{{ $producto->stock }}" value="1" required>
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Salida</button>
                                        </div>
                                    </form>
                                    @else
                                        <span class="text-muted">Agotado</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay productos registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection