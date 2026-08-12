<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre       = trim($_POST['nombre']);
    $cedula       = trim($_POST['cedula']);
    $especialidad = trim($_POST['especialidad']);
    $mail         = trim($_POST['mail']);
    $pass         = $_POST['pass'];
    $pass2        = $_POST['confirm_pass']; 

    if ($pass !== $pass2) {
        header('Location: ../public/registro_pediatra.php?error=' . urlencode('Las contraseñas no coinciden.'));
        exit;
    }

    // Hash de seguridad
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO pediatras (nombre, cedula, especialidad, mail, pass) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $cedula, $especialidad, $mail, $pass_hash);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../public/login.php?mensaje=' . urlencode('¡Registro exitoso! Ya puedes entrar.'));
            exit;
        } else {
            header('Location: ../public/registro_pediatra.php?error=' . urlencode('Error al registrar médico.'));
            exit;
        }
    }
}
?>