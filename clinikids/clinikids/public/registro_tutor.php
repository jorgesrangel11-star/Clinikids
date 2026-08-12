<?php
session_start();
$mensaje = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Tutor - Clinikids</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-reg { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        body { background-color: #f0f2f5; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold">Crear Cuenta de Tutor</h2>
                    <p class="text-muted">Regístrate para gestionar las citas de tus hijos</p>
                </div>

                <div class="card card-reg p-4">
                    <form action="../lib/procesar_registro_tutor.php" method="post">
                        
                        <?php if($mensaje): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= htmlspecialchars($mensaje) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Juan Pérez" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Correo Electrónico</label>
                            <input type="email" class="form-control" name="mail" placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Contraseña</label>
                                <input type="password" class="form-control" name="pass" placeholder="********" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="pass2" placeholder="********" required>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-box" type="checkbox" required>
                            <label class="form-check-label small text-muted">
                                [cite_start]Acepto que soy el responsable legal de los menores registrados[cite: 17].
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">Finalizar Registro</button>
                        <a href="login.php" class="btn btn-link w-100 mt-2 text-decoration-none small">¿Ya tienes cuenta? Inicia sesión</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>