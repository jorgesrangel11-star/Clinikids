<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 3){
    header('Location: ../login.php?error=' . urlencode('Acceso solo para médicos'));
    exit;
}

$id_doc = $_SESSION['id_usr'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Médico - Clinikids</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/datatables.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-stethoscope"></i> Clinikids Médico</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-white">Dr. <?= htmlspecialchars($_SESSION['nom_usr']) ?></span>
                <a class="nav-link btn btn-danger btn-sm text-white ms-3" href="logout.php">Salir</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Mi Agenda de Consultas</h2>
        
        <div class="card shadow border-0 p-4">
            <table id="tablaAgenda" class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha/Hora</th>
                        <th>Paciente</th>
                        <th>Tutor (Padre)</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta adaptada a tus tablas actuales
                    $sql = "SELECT c.id_cita, c.fecha_cita, c.hora_cita, c.estatus, p.nombre AS nom_paciente, p.id_paciente, u.nom_usr AS nom_tutor
                            FROM citas c
                            JOIN pacientes p ON c.id_paciente = p.id_paciente
                            JOIN usuarios u ON p.id_tutor = u.id_usr
                            WHERE c.id_pediatra = ?
                            ORDER BY c.fecha_cita DESC";
                    
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $id_doc);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);

                    while($fila = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($fila['fecha_cita'])) ?> <?= $fila['hora_cita'] ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($fila['nom_paciente']) ?></td>
                        <td><?= htmlspecialchars($fila['nom_tutor']) ?></td>
                        <td>
                            <span class="badge <?= ($fila['estatus']=='Pendiente') ? 'bg-warning text-dark' : 'bg-success' ?>">
                                <?= $fila['estatus'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="consultar_paciente.php?id=<?= $fila['id_paciente'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-person-search"></i> Ver Info
                                </a>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAtender<?= $fila['id_cita'] ?>">
                                    <i class="bi bi-file-earmark-plus"></i> Atender
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalAtender<?= $fila['id_cita'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="guardar_reporte.php" method="POST" class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">Atención: <?= htmlspecialchars($fila['nom_paciente']) ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_cita" value="<?= $fila['id_cita'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diagnóstico Clínico</label>
                                        <textarea name="diagnostico" class="form-control" rows="4" required placeholder="Escriba el diagnóstico..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Recomendaciones y Tratamiento</label>
                                        <textarea name="recomendaciones" class="form-control" rows="3" placeholder="Medicamentos, dosis, etc."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success">Guardar Reporte y Finalizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaAgenda').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" }
            });
        });
    </script>
</body>
</html>