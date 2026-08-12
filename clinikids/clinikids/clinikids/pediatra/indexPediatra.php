<?php
session_start();
// __DIR__ ya sabe en qué carpeta estás, solo dile cómo llegar a config
require_once __DIR__ . '/../config/db.php';

// Seguridad: Solo Pediatras activos
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
                <a class="nav-link btn btn-danger btn-sm text-white ms-3" href="../login.php">Salir</a>
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
                    // Consulta para traer las citas del doctor logueado
                    $sql = "SELECT c.id_cita, c.fecha_cita, c.estado_cita, p.nom_paciente, p.historial_medico, u.nom_usr AS nom_tutor
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
                        <td><?= date('d/m/Y H:i', strtotime($fila['fecha_cita'])) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($fila['nom_paciente']) ?></td>
                        <td><?= htmlspecialchars($fila['nom_tutor']) ?></td>
                        <td>
                            <span class="badge <?= ($fila['estado_cita']=='Pendiente') ? 'bg-warning' : 'bg-success' ?>">
                                <?= $fila['estado_cita'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalHistorial<?= $fila['id_cita'] ?>">
                                <i class="bi bi-file-earmark-medical"></i> Ver Historial
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalHistorial<?= $fila['id_cita'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Historial de <?= htmlspecialchars($fila['nom_paciente']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Antecedentes y Notas:</h6>
                                    <p class="p-3 bg-light rounded"><?= nl2br(htmlspecialchars($fila['historial_medico'])) ?></p>
                                </div>
                            </div>
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
            $('#tablaAgenda').DataTable();
        });
    </script>
</body>
</html>