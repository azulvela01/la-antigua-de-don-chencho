<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #d97706;
            --primary-hover: #b45309;
            --bg-gradient: linear-gradient(135deg, #fff8e1, #ffcc80);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(217, 119, 6, 0.25);
        }

        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(217, 119, 6, 0.3);
        }

        .captcha-img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 1rem;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .captcha-img.selected {
            border-color: var(--primary);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.3);
        }

        .captcha-label small {
            display: block;
            margin-top: 0.5rem;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .alert {
            border-radius: 50px;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }

        /* RESPONSIVE AJUSTES */
        @media (max-width: 480px) {
            .login-card { padding: 1.5rem; }
            .logo { width: 70px; height: 70px; }
            h1 { font-size: 1.8rem; }
            .btn-login { font-size: 1rem; }
            .captcha-img { height: 75px; }
        }

        @media (min-width: 768px) {
            .login-card { padding: 2.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        @if(session('error'))
            <div class="alert alert-danger text-center fw-bold p-3 mb-4 rounded" style="background:#f8d7da; color:#721c24;">
                {{ session('error') }}
            </div>
        @endif
        <div class="login-card">
            <!-- Logo y Título -->
            <div class="text-center mb-4">
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                    alt="Panadería" class="logo mx-auto">
                <h1 class="mt-3 fw-bold text-amber-900">Inicio de Sesión</h1>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label text-gray-700 fw-semibold">Correo Electrónico</label>
                    <input type="email" name="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autofocus>
                    @error('email')
                        @if(str_contains($message, 'countdown'))
                            {!! $message !!}
                        @else
                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                        @endif
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label class="form-label text-gray-700 fw-semibold">Contraseña</label>
                    <input type="password" name="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Recordarme + Olvidé -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember"
                                class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-gray-600" for="remember">Recordarme</label>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="text-primary text-decoration-none small fw-semibold">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- CAPTCHA -->
                <div class="mb-4">
                    <label class="form-label text-gray-700 fw-semibold">
                        Verifica: Selecciona <strong>{{ ucfirst($codigoCaptcha) }}</strong>
                    </label>
                    <div class="row g-2">
                        @foreach($imagenesAleatorias as $index => $item)
                            <div class="col-4">
                                <input type="radio" name="captcha_seleccion" value="{{ $item['animal'] }}"
                                        id="captcha-{{ $index }}" class="d-none" required>
                                <label for="captcha-{{ $index }}" class="captcha-label d-block text-center">
                                    <img src="{{ $item['url'] }}" class="captcha-img img-fluid"
                                        alt="{{ ucfirst($item['animal']) }}">
                                    <small>{{ ucfirst($item['animal']) }}</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('captcha')
                        <span class="text-danger small d-block mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-login w-100 fw-bold">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Registro -->
            <div class="text-center mt-4">
                <p class="text-gray-600 small">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript para CAPTCHA -->
    <script>
        document.querySelectorAll('.captcha-label').forEach(label => {
            label.addEventListener('click', function() {
                document.querySelectorAll('.captcha-img').forEach(img => {
                    img.classList.remove('selected');
                });
                this.querySelector('.captcha-img').classList.add('selected');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>