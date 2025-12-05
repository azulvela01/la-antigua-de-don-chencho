<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panadería La Antigua')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fdf6e3; }
        .navbar { background-color: #fef3c7; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn-inventario { background-color: #f59e0b; color: white; }
        .btn-inventario:hover { background-color: #d97706; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-amber-900" href="{{ route('home') }}">
                Panadería La Antigua
            </a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <span class="text-sm text-gray-700 me-3">
                        {{ Auth::user()->name }} 
                        <span class="badge bg-{{ Auth::user()->esAdmin() ? 'danger' : 'secondary' }} text-xs">
                            {{ ucfirst(Auth::user()->rol) }}
                        </span>
                    </span>

                    @if(Auth::user()->esAdmin())
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-outline-danger">
                            Usuarios
                        </a>
                    @endif

                    @if(Auth::user()->puede_ver_inventario)
                        <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-inventario">
                            Inventario
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Iniciar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Mensajes -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Contenido -->
    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>