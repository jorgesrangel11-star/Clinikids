<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $mail = trim($_POST['mail']);
    $cedula = trim($_POST['cedula']);
    $especialidad = $_POST['especialidad'];
    $pass_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $tip_usu = 3; // Rol de Pediatra

    // --- LÓGICA DE SUBIDA DE ARCHIVO ---
    $nombre_archivo = $_FILES['titulo_archivo']['name'];
    $ruta_temporal = $_FILES['titulo_archivo']['tmp_name'];
    
    // Creamos un nombre único para que no se borren si dos suben "titulo.pdf"
    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
    $nuevo_nombre = "pediatra_" . time() . "_" . $cedula . "." . $extension;
    $ruta_destino = "../uploads/" . $nuevo_nombre;

    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
        // 1. Insertar en tabla 'usuarios' con estatus 0 (Pendiente)
        $sql_usr = "INSERT INTO usuarios (nom_usr, mail, pass, tip_usu, estatus) VALUES (?, ?, ?, ?, 0)";
        $stmt_usr = mysqli_prepare($conn, $sql_usr);
        mysqli_stmt_bind_param($stmt_usr, "sssi", $nombre, $mail, $pass_hash, $tip_usu);
        
        if (mysqli_stmt_execute($stmt_usr)) {
            $id_generado = mysqli_insert_id($conn);
            
            // 2. Insertar datos médicos en 'datos_pediatras'
            $sql_med = "INSERT INTO datos_pediatras (id_pediatra, cedula_profesional, especialidad, archivo_acreditacion) VALUES (?, ?, ?, ?)";
            $stmt_med = mysqli_prepare($conn, $sql_med);
            mysqli_stmt_bind_param($stmt_med "isss", $id_generado, $cedula, $especialidad, $nuevo_nombre);
            mysqli_stmt_execute($stmt_med);

            header('Location: ../login.php?mensaje=' . urlencode('Solicitud enviada. Espera la validación del Admin.'));
        }
    } else {
        header('Location: ../registro_pediatra.php?error=' . urlencode('Error al subir el comprobante.'));
    }
}
?>