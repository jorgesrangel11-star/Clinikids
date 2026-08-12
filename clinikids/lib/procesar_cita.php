<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// 1. Seguridad: Solo permitimos POST y que sea un Tutor (Tipo 2)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['tip_usu'] != 2) {
    header('Location: ../public/login.php?error=' . urlencode('Acceso no permitido.'));
    exit;
}

// 2. Recibir datos del formulario
$id_paciente = $_POST['id_paciente'];
$id_pediatra = $_POST['id_pediatra'];
$fecha_cita  = $_POST['fecha_cita']; // Viene en formato YYYY-MM-DDTHH:MM
$motivo      = trim($_POST['motivo']);

// 3. Insertar en la tabla 'citas'
// El acta pide elegir horario (hora, día, semanas y mes) 
$sql = "INSERT INTO citas (id_paciente, id_pediatra, fecha_cita, observaciones) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $id_paciente, $id_pediatra, $fecha_cita, $motivo);

if (mysqli_stmt_execute($stmt)) {
    mysqli_close($conn);
    // Redirigir al panel del cliente con mensaje de éxito
    header('Location: ../public/cliente/indexCliente.php?mensaje=' . urlencode('¡Cita agendada correctamente!'));
    exit;
} else {
    mysqli_close($conn);
    header('Location: ../public/cliente/agendar_cita.php?error=' . urlencode('Error al registrar la cita.'));
    exit;
}
?>