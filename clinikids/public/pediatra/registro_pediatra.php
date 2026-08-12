<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Pediatra - Clinikids</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .card-registro { border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); border: none; }
        .btn-clinikids { background-color: #0dcaf0; color: white; font-weight: bold; }
        .btn-clinikids:hover { background-color: #0baccc; color: white; }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="text-center mb-4">
                    <i class="bi bi-stethoscope text-info" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold">Registro de Especialistas</h2>
                    <p class="text-muted">Únete al equipo médico de Clinikids</p>
                </div>

                <div class="card card-registro p-4">
                    <form action="./lib/procesar_registro_pediatra.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej. Dr. Jorge Sánchez" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" name="mail" class="form-control" placeholder="medico@clinikids.com" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cédula Profesional</label>
                                <input type="text" name="cedula" class="form-control" placeholder="Número de cédula" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Especialidad</label>
                                <input type="text" name="especialidad" class="form-control" placeholder="Ej. Neonatología" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Título o Comprobante de Acreditación (PDF/JPG)</label>
                            <input type="file" name="titulo_archivo" class="form-control" accept=".pdf, .jpg, .jpeg, .png" required>
                            <small class="text-muted">Documento necesario para la validación por el administrador.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Contraseña</label>
                            <input type="password" name="pass" class="form-control" placeholder="********" required>
                        </div>

                        <button type="submit" class="btn btn-clinikids w-100 p-2 shadow-sm">
                            Enviar Solicitud de Registro
                        </button>

                        <div class="text-center mt-4">
                            <p>¿Ya eres parte del sistema? <a href="login.php" class="text-info fw-bold text-decoration-none">Inicia sesión</a></p>
                        </div>
                    </form>
                </div>
                <div class="text-center mt-4">
                    <small class="text-muted">© 2026 Clinikids - Sistema de Gestión Pediátrica</small>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>