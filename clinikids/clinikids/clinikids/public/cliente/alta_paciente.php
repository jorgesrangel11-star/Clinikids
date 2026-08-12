<?php
include_once "../../config/db.php";
include_once "./menu.php";

// Protección de sesión
if (!isset($_SESSION['id_usr'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Hijo - Clinikids</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Registrar Nuevo Paciente</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="../../lib/procesar_alta_paciente.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo del Niño/a</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Género</label>
                                <select name="genero" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notas o Alergias (Opcional)</label>
                                <textarea name="notas" class="form-control" rows="3" placeholder="Ej. Alérgico a la penicilina..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Guardar Perfil Infantil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>