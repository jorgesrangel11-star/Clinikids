<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Seguridad: Solo tutores 
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 2){
    header('Location: ../login.php?error=' . urlencode('Inicia sesión como tutor'));
    exit;
}

$id_tutor = $_SESSION['id_usr'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Citas - Clinikids</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/datatables.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>
<body>
    <?php include './menu.php'; ?>

    <div class="container my-5">
        <h2 class="mb-4"><i class="bi bi-calendar3"></i> Agenda de Citas</h2>
        
        <div class="card shadow p-4">
            <table id="tablaCitas" class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Paciente (Hijo)</th>
                        <th>Pediatra</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta con JOINs para traer nombres en lugar de puros IDs
                    $sql = "SELECT p.nom_paciente, u.nom_usr AS nom_doctor, c.fecha_cita, c.estado_cita, c.observaciones 
                            FROM citas c
                            JOIN pacientes p ON c.id_paciente = p.id_paciente
                            JOIN usuarios u ON c.id_pediatra = u.id_usr
                            WHERE p.id_tutor = ? 
                            ORDER BY c.fecha_cita ASC";
                    
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $id_tutor);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);

                    while($cita = mysqli_fetch_assoc($res)){
                        // Lógica de colores para el estado
                        $badge = ($cita['estado_cita'] == 'Pendiente') ? 'bg-warning' : 'bg-success';
                    ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($cita['nom_paciente']) ?></td>
                        <td>Dr. <?= htmlspecialchars($cita['nom_doctor']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($cita['fecha_cita'])) ?></td>
                        <td><span class="badge <?= $badge ?>"><?= $cita['estado_cita'] ?></span></td>
                        <td><small><?= htmlspecialchars($cita['observaciones']) ?></small></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="mt-3">
                <a href="agendar_cita.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Agendar Nueva Cita</a>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaCitas').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" }
            });
        });
    </script>
</body>
</html>