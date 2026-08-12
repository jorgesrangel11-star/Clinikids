<?php
session_start();
// Seguridad: Solo el Admin entra aquí
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 1){
    header('Location: ../login.php?error=' . urlencode('Acceso denegado'));
    exit;
}
require_once __DIR__ . '/../../config/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Pediatras - Admin</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/datatables.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>
<body class="d-flex">
    <?php require_once __DIR__ . '/menu.php'; ?>

    <div class="p-4 w-100">
        <h2 class="mb-4">Validación de Nuevos Pediatras</h2>
        
        <div class="card shadow p-3">
            <table id="tablaPediatras" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Especialidad</th>
                        <th>Documento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Buscamos usuarios tipo 3 (Pediatra) con estatus 0 (Pendiente)
                    $sql = "SELECT u.id_usr, u.nom_usr, d.cedula_profesional, d.especialidad, d.archivo_acreditacion 
                            FROM usuarios u 
                            JOIN datos_pediatras d ON u.id_usr = d.id_pediatra 
                            WHERE u.tip_usu = 3 AND u.estatus = 0";
                    $res = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nom_usr']) ?></td>
                        <td><?= htmlspecialchars($row['cedula_profesional']) ?></td>
                        <td><?= htmlspecialchars($row['especialidad']) ?></td>
                        <td>
                            <a href="../../uploads/<?= $row['archivo_acreditacion'] ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-file-earmark-pdf"></i> Ver Título
                            </a>
                        </td>
                        <td>
                            <a href="aprobar_doctor.php?id=<?= $row['id_usr'] ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg"></i> Aprobar
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaPediatras').DataTable();
        });
    </script>
</body>
</html>