<?php
session_start();
$mensaje = isset($_GET['error']) ? $_GET['error'] : '';
$exito = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clinikids</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { margin-top: 5%; }
        .card-login { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-clinikids { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-heart-pulse-fill text-primary" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold mt-2">Clinikids</h2>
                    <p class="text-muted">Gestión de Servicios Pediátricos</p>
                </div>

                <div class="card card-login p-4">
                    <form action="../lib/procesar_login.php" method="post">
                        <?php if($mensaje): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php echo htmlspecialchars($mensaje); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if($exito): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?php echo htmlspecialchars($exito); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="mail" placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="pass" placeholder="********" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-clinikids w-100 fw-bold mb-3">
                            Entrar al Sistema
                        </button>

                        <hr>

                        <div class="text-center mt-3">
                            <p class="mb-1">¿No tienes cuenta? Regístrate como:</p>
                            <div class="d-grid gap-2">
                                <a href="registro_tutor.php" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-person-heart"></i> Tutor/Padre
                                </a>
                                <a href="registro_pediatra.php" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-stethoscope"></i> Médico Pediatra
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="text-center mt-4">
                    <small class="text-muted">© 2026 Clinikids</small>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>