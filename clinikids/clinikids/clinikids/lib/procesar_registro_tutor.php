<?php
session_start();
// Asegúrate de que la ruta a db.php sea la correcta
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recibir y limpiar datos
    $nombre = trim($_POST['nombre']);
    $mail   = trim($_POST['mail']);
    $pass   = $_POST['pass'];
    $pass2  = $_POST['pass2'];

    // 2. Validar que las contraseñas coincidan
    if ($pass !== $pass2) {
        header('Location: ../public/registro_tutor.php?error=' . urlencode('Las contraseñas no coinciden.'));
        exit;
    }

    // 3. Verificar si el correo ya existe
    // USAMOS $conn (ajusta a $conexion solo si en db.php dice exactamente $conexion)
    $sql_check = "SELECT id_tutor FROM tutores WHERE mail = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check); 
    
    if (!$stmt_check) {
        die("Error en la base de datos: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_check, "s", $mail);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        header('Location: ../public/registro_tutor.php?error=' . urlencode('Este correo ya está registrado.'));
        exit;
    }
    mysqli_stmt_close($stmt_check);

    // 4. Encriptar contraseña (IMPORTANTE)
    // Al usar password_hash, en el LOGIN deberás usar password_verify
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO tutores (nombre, mail, pass) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "sss", $nombre, $mail, $pass_hash);

    if (mysqli_stmt_execute($stmt_insert)) {
        header('Location: ../public/login.php?mensaje=' . urlencode('¡Registro exitoso! Ya puedes iniciar sesión.'));
        exit;
    } else {
        header('Location: ../public/registro_tutor.php?error=' . urlencode('Error al guardar en el sistema.'));
        exit;
    }
}
?>