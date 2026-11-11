<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// 1. Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['tip_usu'] != 2) {
    header('Location: ../public/login.php?error=' . urlencode('Acceso no permitido.'));
    exit;
}


$id_tutor = $_SESSION['id_usr']; 
$nom_paciente = trim($_POST['nom_paciente']);
$fecha_nac = $_POST['fecha_nac'];
$historial = trim($_POST['historial']);


$sql = "INSERT INTO pacientes (id_tutor, nom_paciente, fecha_nacimiento, historial_medico) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isss", $id_tutor, $nom_paciente, $fecha_nac, $historial);

if (mysqli_stmt_execute($stmt)) {
    mysqli_close($conn);
    
    header('Location: ../public/cliente/indexCliente.php?mensaje=' . urlencode('Paciente registrado con éxito.'));
    exit;
} else {
    mysqli_close($conn);
    header('Location: ../public/cliente/alta_paciente.php?error=' . urlencode('Error al guardar los datos.'));
    exit;
}
?>
