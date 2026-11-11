<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/registro_tutor.php?error=' . urlencode('Acceso no permitido.'));
    exit;
}


$nombre = trim($_POST['nombre']);
$mail   = trim($_POST['mail']);
$pass   = $_POST['pass'];
$pass2  = $_POST['pass2'];
$tip_usu = 2; 


if ($pass !== $pass2) {
    header('Location: ../public/registro_tutor.php?error=' . urlencode('Las contraseñas no coinciden.'));
    exit;
}


$sql_check = "SELECT id_usr FROM usuarios WHERE mail = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "s", $mail);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) > 0) {
    mysqli_close($conn);
    header('Location: ../public/registro_tutor.php?error=' . urlencode('Este correo ya está registrado.'));
    exit;
}
mysqli_stmt_close($stmt_check);


$pass_hash = password_hash($pass, PASSWORD_DEFAULT);


$sql_insert = "INSERT INTO usuarios (nom_usr, mail, pass, tip_usu, estatus) VALUES (?, ?, ?, ?, 1)";
$stmt_insert = mysqli_prepare($conn, $sql_insert);
mysqli_stmt_bind_param($stmt_insert, "sssi", $nombre, $mail, $pass_hash, $tip_usu);

if (mysqli_stmt_execute($stmt_insert)) {
    mysqli_close($conn);

    header('Location: ../public/login.php?mensaje=' . urlencode('¡Registro exitoso! Ya puedes iniciar sesión.'));
    exit;
} else {
    mysqli_close($conn);
    header('Location: ../public/registro_tutor.php?error=' . urlencode('Error al guardar en el sistema.'));
    exit;
}
?>
