<?php
session_start();
// Seguridad: Solo tutores (tip_usu 2)
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 2){
    header('Location: ../login.php?error=' . urlencode('Inicia sesión como tutor'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Hijo - Clinikids</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>
<body>
    <?php include './menu.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus"></i> Registrar Nuevo Paciente</h4>
                    </div>
                    <div class="card-body">
                        <form action="../../lib/procesar_alta_paciente.php" method="post">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo del Menor</label>
                                <input type="text" class="form-control" name="nom_paciente" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nac" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Historial Médico / Alergias</label>
                                <textarea class="form-control" name="historial" rows="4" placeholder="Ej: Alérgico a la penicilina, asma, etc."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold">Guardar Información</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>