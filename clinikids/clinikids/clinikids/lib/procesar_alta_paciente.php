<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id_usr'])) {
    $id_tutor = $_SESSION['id_usr'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $fecha_nac = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $notas = mysqli_real_escape_string($conexion, $_POST['notas']);

    $sql = "INSERT INTO pacientes (id_tutor, nombre, fecha_nacimiento, genero, notas_medicas) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $id_tutor, $nombre, $fecha_nac, $genero, $notas);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../public/cliente/indexCliente.php?mensaje=" . urlencode("Paciente registrado con éxito"));
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);
    }
}
?>