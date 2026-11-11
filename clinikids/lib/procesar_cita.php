<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['tip_usu'] != 2) {
    header('Location: ../public/login.php?error=' . urlencode('Acceso no permitido.'));
    exit;
}


$id_paciente = $_POST['id_paciente'];
$id_pediatra = $_POST['id_pediatra'];
$fecha_cita  = $_POST['fecha_cita']; 
$motivo      = trim($_POST['motivo']);


$sql = "INSERT INTO citas (id_paciente, id_pediatra, fecha_cita, observaciones) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $id_paciente, $id_pediatra, $fecha_cita, $motivo);

if (mysqli_stmt_execute($stmt)) {
    mysqli_close($conn);
    
    header('Location: ../public/cliente/indexCliente.php?mensaje=' . urlencode('¡Cita agendada correctamente!'));
    exit;
} else {
    mysqli_close($conn);
    header('Location: ../public/cliente/agendar_cita.php?error=' . urlencode('Error al registrar la cita.'));
    exit;
}
?>
