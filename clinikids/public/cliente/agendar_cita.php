<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Seguridad: Solo tutores
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 2){
    header('Location: ../login.php?error=' . urlencode('Inicia sesión como tutor'));
    exit;
}

$id_tutor = $_SESSION['id_usr'];

// 1. Obtener los hijos del tutor para el select
$sql_pacientes = "SELECT id_paciente, nom_paciente FROM pacientes WHERE id_tutor = ?";
$stmt_p = mysqli_prepare($conn, $sql_pacientes);
mysqli_stmt_bind_param($stmt_p, "i", $id_tutor);
mysqli_stmt_execute($stmt_p);
$res_pacientes = mysqli_stmt_get_result($stmt_p);

// 2. Obtener pediatras activos (estatus 1) para el select
$sql_docs = "SELECT id_usr, nom_usr FROM usuarios WHERE tip_usu = 3 AND estatus = 1";
$res_docs = mysqli_query($conn, $sql_docs);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita - Clinikids</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>
<body>
    <?php include './menu.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0"><i class="bi bi-calendar-check"></i> Programar Cita Médica</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="../../lib/procesar_cita.php" method="post">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">¿Para quién es la cita? (Paciente)</label>
                                <select class="form-select" name="id_paciente" required>
                                    <option value="">Selecciona a tu hijo/a</option>
                                    <?php while($p = mysqli_fetch_assoc($res_pacientes)): ?>
                                        <option value="<?= $p['id_paciente'] ?>"><?= htmlspecialchars($p['nom_paciente']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Selecciona al Pediatra</label>
                                <select class="form-select" name="id_pediatra" required>
                                    <option value="">Buscar médico disponible</option>
                                    <?php while($d = mysqli_fetch_assoc($res_docs)): ?>
                                        <option value="<?= $d['id_usr'] ?>">Dr. <?= htmlspecialchars($d['nom_usr']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small">Fecha y Hora de la Consulta</label>
                                    <input type="datetime-local" class="form-control" name="fecha_cita" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Motivo de la consulta (Opcional)</label>
                                <textarea class="form-control" name="motivo" rows="2" placeholder="Ej: Revisión de rutina, fiebre, vacuna..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">Confirmar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>