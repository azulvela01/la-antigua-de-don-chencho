<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #fff8e1, #ffcc80); }
        .card { border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-register { background-color: #ea580c; border: none; }
        .btn-register:hover { background-color: #c2410c; }
        .logo { width: 80px; height: 80px; }
        .modal-header { background-color: #8B4513; color: white; }
        .modal-title { font-weight: 600; }
        .privacy-link { color: #ea580c; text-decoration: underline; font-weight: 500; }
        .privacy-link:hover { color: #c2410c; }
        .form-check-input:checked { background-color: #ea580c; border-color: #ea580c; }
        .admin-disabled { color: #6c757d; font-style: italic; }
        .modal-body { line-height: 1.7; }
        .highlight { background-color: #fff3cd; padding: 2px 6px; border-radius: 4px; font-weight: 600; }
        .section-title { color: #8B4513; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.5rem; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" 
                alt="Logo" class="logo rounded-full mx-auto shadow-lg">
            <h1 class="mt-4 text-3xl font-bold text-amber-900">Crear Cuenta</h1>
        </div>

        <div class="card bg-white p-5">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-gray-700">Nombre</label>
                        <input type="text" name="name" class="form-control rounded-pill" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-gray-700">Correo</label>
                        <input type="email" name="email" class="form-control rounded-pill" value="{{ old('email') }}" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-gray-700">Contraseña</label>
                        <input type="password" name="password" class="form-control rounded-pill" required>
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-gray-700">Confirmar</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-gray-700">Rol</label>
                        <select name="rol" class="form-select rounded-pill" required>
                            <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                            <option value="administrador" disabled>Administrador (No disponible)</option>
                        </select>
                        <small class="text-muted admin-disabled">
                            Ya existen 3 administradores. Límite alcanzado.
                        </small>
                        @error('rol') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- CHECKBOX OBLIGATORIO -->
                <div class="mt-4 p-3 bg-light border rounded">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="privacy_accepted" id="privacyCheck" value="1" required>
                        <label class="form-check-label" for="privacyCheck">
                            He leído y acepto los 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalSimplificado" class="privacy-link">
                                Aviso de Privacidad Simplificado
                            </a> y 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalIntegral" class="privacy-link">
                                Aviso de Privacidad Integral
                            </a>
                        </label>
                    </div>
                    @error('privacy_accepted') 
                        <span class="text-danger small d-block mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <button type="submit" class="btn btn-register w-100 text-white py-3 rounded-pill fw-bold mt-4">
                    Crear Cuenta
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-gray-600">¿Ya tienes cuenta? 
                    <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-800 text-decoration-none">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- MODAL SIMPLIFICADO -->
    <div class="modal fade" id="modalSimplificado" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">AVISO DE PRIVACIDAD SIMPLIFICADO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="section-title">I. Denominación del responsable.</p>
                    <p>Panadería La Antigua de Don Chencho, en lo sucesivo Panadería, con domicilio en <strong>Galeana Sur 420, Obraje, Aguascalientes, C.P. 20000, México</strong>.</p>

                    <p class="section-title">II. Finalidad del tratamiento para los cuales se obtiene los datos personales.</p>
                    <p>Los datos personales que recabamos podrán ser utilizados para las siguientes finalidades concernientes con la relación jurídica y/o la prestación de servicios y trámites:</p>
                    <ul>
                        <li>Gestión de usuarios y roles para acceso al sistema de inventario.</li>
                        <li>Registro de entradas y salidas de materias primas.</li>
                        <li>Generación de alertas de stock bajo.</li>
                        <li>Recuperación de contraseña y autenticación segura.</li>
                        <li>Auditoría de acciones en el sistema.</li>
                        <li>Generación de reportes de uso y estadísticas internas.</li>
                        <li>Mejora continua del sistema de gestión de inventario.</li>
                        <li>Comunicación de actualizaciones del sistema.</li>
                        <li>Respaldo de datos para recuperación en caso de fallos.</li>
                        <li>Cumplimiento de obligaciones legales y regulatorias.</li>
                    </ul>

                    <p class="section-title">III. Transferencia de datos personales.</p>
                    <p>Se informa que <strong>no se realizarán transferencias de datos personales</strong>, salvo aquellas que sean necesarias para atender requerimientos de información de una autoridad competente, que estén debidamente fundados y motivados.</p>

                    <p class="section-title">IV. Mecanismos y medios disponibles para que el titular pueda manifestar su negativa.</p>
                    <p>Usted podrá manifestar su negativa al tratamiento de sus datos personales directamente ante la Panadería, la cual se encuentra ubicada en <strong>Galeana Sur 420, Obraje, Aguascalientes, C.P. 20000</strong>, o bien por medio del correo electrónico <strong>panaderialaantiguadedonchencho@gmail.com</strong>. Si usted <strong>no manifiesta su oposición o negativa</strong> para el uso y/o tratamiento de su información personal, se entenderá que se ha otorgado consentimiento para ello.</p>

                    <p class="section-title">V. Sitio para consultar el Aviso de Privacidad Integral.</p>
                    <p>Para mayor conocimiento de los medios y procedimientos disponibles para ejercer los derechos ARCO, se encuentra disponible nuestro Aviso de Privacidad Integral en el sistema, así como en las oficinas de la Panadería.</p>

                    <p class="section-title">VI. Alojamiento de datos de inicio de sesión.</p>
                    <p><span class="highlight">Los datos de inicio de sesión (correo electrónico y contraseña encriptada con bcrypt) se almacenan en una base de datos MySQL alojada en servidor local seguro con cifrado SSL/TLS, respaldos diarios y acceso restringido.</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL INTEGRAL -->
    <div class="modal fade" id="modalIntegral" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">AVISO DE PRIVACIDAD INTEGRAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="section-title">I. Denominación y domicilio del responsable.</p>
                    <p>Panadería La Antigua de Don Chencho, en lo sucesivo Panadería, la cual se encuentra ubicada en <strong>Galeana Sur 420, Obraje, Aguascalientes, C.P. 20000, México</strong>, o bien por medio del correo electrónico <strong>panaderialaantiguadedonchencho@gmail.com</strong>, es responsable del tratamiento de los datos personales que nos proporcione, los cuales serán protegidos conforme a lo dispuesto por la <strong>Ley Federal de Protección de Datos Personales en Posesión de Particulares (LFPDPPP)</strong>, y demás normatividad que resulte aplicable.</p>

                    <p class="section-title">II. Finalidades del tratamiento para los cuales se obtiene los datos personales.</p>
                    <p>Los datos personales que recabamos podrán ser utilizados para las siguientes finalidades concernientes con la relación jurídica y/o la prestación de servicios y trámites:</p>
                    <ul>
                        <li>Asesoría para el ejercicio del derecho de acceso a la información y protección de datos personales.</li>
                        <li>Trámite de las Solicitudes de Acceso a la información y de protección de datos personales.</li>
                        <li>Trámite del Recurso de Revisión.</li>
                        <li>Trámite del procedimiento de denuncias por incumplimiento de las obligaciones de transparencia por parte de los sujetos obligados.</li>
                        <li>Gestión de inventario, usuarios, autenticación, alertas, reportes y auditoría.</li>
                        <li>Generación de reportes de uso y estadísticas internas.</li>
                        <li>Mejora continua del sistema de gestión de inventario.</li>
                        <li>Comunicación de actualizaciones del sistema.</li>
                        <li>Respaldo de datos para recuperación en caso de fallos.</li>
                        <li>Prevención de fraudes y cumplimiento de obligaciones legales.</li>
                    </ul>

                    <p class="section-title">III. Datos personales sometidos a tratamiento.</p>
                    <p>Para las finalidades arriba mencionadas, se solicitarán los siguientes datos personales: <strong>nombre completo, correo electrónico, contraseña (encriptada con algoritmo bcrypt), rol en el sistema</strong>. Se informa que <strong>no se recabarán datos personales sensibles</strong> (origen racial o étnico, ideología, creencias, orientación sexual, estado de salud, etc.).</p>

                    <p class="section-title">IV. Transferencias de datos personales.</p>
                    <p>La Panadería se compromete a velar porque se cumplan todos los principios enmarcados en la LFPDPPP, sobre la protección y en torno a la transmisión de sus datos personales. De igual forma, manifiesta su compromiso para que se respete en todo momento el presente Aviso de Privacidad. <strong>Se informa que no se realizarán transferencias de datos personales</strong>, salvo aquellas que sean necesarias para atender requerimientos de información de una autoridad competente, que estén debidamente fundados y motivados.</p>

                    <p class="section-title">V. Fundamento Legal.</p>
                    <p>De conformidad con lo dispuesto en la <strong>Ley Federal de Protección de Datos Personales en Posesión de Particulares (LFPDPPP)</strong>, publicada en el DOF el 05 de julio de 2010, con última reforma el 2023, su Reglamento y los Lineamientos del Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales (INAI).</p>

                    <p class="section-title">VI. Derechos ARCO y mecanismos para su ejercicio.</p>
                    <p>Usted tiene derecho a acceder, rectificar, cancelar u oponerse al tratamiento de sus datos personales (Derechos ARCO). Para ejercer estos derechos, envíe solicitud al correo <strong>panaderialaantiguadedonchencho@gmail.com</strong> con: nombre, domicilio, descripción clara de la solicitud, y documentos que acrediten su identidad. La respuesta se dará en un plazo máximo de <strong>20 días hábiles</strong>.</p>

                    <p class="section-title">VII. Revocación del consentimiento.</p>
                    <p>Usted puede revocar su consentimiento para el tratamiento de sus datos personales en cualquier momento, enviando solicitud al correo <strong>panaderialaantiguadedonchencho@gmail.com</strong>. Sin embargo, si la revocación afecta obligaciones legales, podría no ser posible.</p>

                    <p class="section-title">VIII. Cambios al aviso de privacidad.</p>
                    <p>Cualquier modificación a este aviso se notificará a través del sitio web o por correo electrónico, con <strong>15 días de anticipación</strong>.</p>

                    <p class="section-title">IX. Alojamiento y seguridad de datos de inicio de sesión.</p>
                    <p><span class="highlight">
                    Los datos de inicio de sesión (correo electrónico y contraseña encriptada con bcrypt) se almacenan en una base de datos MySQL alojada en servidor local seguro con:<br>
                    • Cifrado SSL/TLS en tránsito.<br>
                    • Contraseñas hasheadas con algoritmo bcrypt.<br>
                    • Respaldos diarios automatizados.<br>
                    • Acceso restringido por IP y autenticación multifactor.<br>
                    • Logs de acceso auditables.<br>
                    • Política de retención: 5 años o hasta solicitud de eliminación.<br>
                    • Medidas técnicas, administrativas y físicas conforme al Art. 19 de la LFPDPPP.
                    </span></p>

                    <p class="section-title">X. Medidas de seguridad.</p>
                    <p>Se aplican medidas técnicas, administrativas y físicas conforme al Artículo 19 de la LFPDPPP para proteger sus datos contra acceso no autorizado, pérdida o alteración.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>