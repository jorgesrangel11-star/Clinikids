<?php
session_start();
if (!isset($_SESSION['id_pediatra'])) {
    header("Location: ../cliente/login.php");
    exit();
}

require_once '../config/db.php';
$id_pediatra = $_SESSION['id_pediatra'];

$sql = "SELECT r.id_reporte, p.nombre AS paciente, r.diagnostico, r.fecha_generado, c.fecha_cita
        FROM reportes r
        JOIN citas c ON r.id_cita = c.id_cita
        JOIN pacientes p ON c.id_paciente = p.id_paciente
        WHERE c.id_pediatra = ?
        ORDER BY r.fecha_generado DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pediatra);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Reportes | Clinikids</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .report-card { border-left: 5px solid #28a745; background: #fff; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .date { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Historial de Reportes Clínicos</h1>
    <a href="indexPediatra.php">Volver al Inicio</a>
    <hr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="report-card">
                <h3>Paciente: <?php echo $row['paciente']; ?></h3>
                <p class="date">Consulta del: <?php echo $row['fecha_cita']; ?> | Generado: <?php echo $row['fecha_generado']; ?></p>
                <p><strong>Diagnóstico:</strong> <?php echo nl2br($row['diagnostico']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No has generado reportes clínicos aún.</p>
    <?php endif; ?>
</body>
</html>