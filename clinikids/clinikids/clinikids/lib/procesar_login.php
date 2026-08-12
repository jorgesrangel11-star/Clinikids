<?php
session_start();
require_once __DIR__ . '/../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, trim($_POST['mail']));
    $password_input = $_POST['pass'];

    // 1. BUSCAR EN TUTORES (Usando columna 'pass')
    $sql_tutor = "SELECT id_tutor, pass, nombre FROM tutores WHERE mail = ?";
    $stmt = mysqli_prepare($conexion, $sql_tutor);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($res)) {
        if (password_verify($password_input, $usuario['pass'])) {
            $_SESSION['id_usr'] = $usuario['id_tutor'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol']    = 'Tutor';
            
            // RUTA CORREGIDA: Según tu VS Code la ruta es esta
            header("Location: ../public/cliente/indexCliente.php"); 
            exit();
        }
    } 

    // 2. BUSCAR EN PEDIATRAS
    $sql_pediatra = "SELECT id_pediatra, pass, nombre FROM pediatras WHERE mail = ?";
    $stmt_p = mysqli_prepare($conexion, $sql_pediatra);
    mysqli_stmt_bind_param($stmt_p, "s", $email);
    mysqli_stmt_execute($stmt_p);
    $res_p = mysqli_stmt_get_result($stmt_p);

    if ($usuario = mysqli_fetch_assoc($res_p)) {
        if (password_verify($password_input, $usuario['pass'])) {
            $_SESSION['id_usr'] = $usuario['id_pediatra'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol']    = 'Pediatra';
            
            header("Location: ../public/pediatra/panel.php");
            exit();
        }
    }

    header("Location: ../public/login.php?error=" . urlencode("Correo o contraseña incorrectos"));
    exit();
}
?>