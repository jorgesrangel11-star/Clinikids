<?php
session_start();
// Aquí podrías incluir tu conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Pediatra - Clinikids</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-container { margin-top: 3%; margin-bottom: 3%; }
        .card-register { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-clinikids { background-color: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="text-center mb-4">
                    <i class="bi bi-stethoscope text-info" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold mt-2">Registro de Médico Pediatra</h2>
                    <p class="text-muted">Únete a la red de Clinikids</p>
                </div>

                <div class="card card-register p-4">
                    <form action="../lib/procesar_registro_pediatra.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej. Dr. Juan Pérez" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cédula Profesional</label>
                                <input type="text" class="form-control" name="cedula" placeholder="12345678" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Especialidad</label>
                            <input type="text" class="form-control" name="especialidad" placeholder="Ej. Neonatología" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" name="mail" placeholder="correo@clinikids.com" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Contraseña</label>
                                <input type="password" class="form-control" name="pass" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="confirm_pass" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-clinikids w-100 fw-bold mb-3">
                            Finalizar Registro
                        </button>

                        <div class="text-center">
                            <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>