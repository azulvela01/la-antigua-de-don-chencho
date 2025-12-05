<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería La Antigua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #fff8e1, #ffcc80); }
        .btn-login { @apply bg-white text-amber-800 border-2 border-amber-800 hover:bg-amber-50; }
        .btn-register { @apply bg-orange-600 text-white hover:bg-orange-700; }
    </style>
</head>
<body class="min-h-screen flex items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center g-5">
            <div class="col-md-6 text-center text-md-start">
                <h1 class="display-3 fw-bold text-amber-900">
                    La Antigua de <span class="text-orange-600">Don Chencho</span>
                </h1>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-md-start mt-4">
                    <a href="{{ route('login') }}" class="btn btn-login px-5 py-3 rounded-pill">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-register px-5 py-3 rounded-pill">Registrarse</a>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                    class="img-fluid rounded-3 shadow-lg" style="max-height: 400px;">
            </div>
        </div>
        <div class="text-center mt-5 text-muted small">
            © {{ date('Y') }} Todos los derechos reservados.
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>