<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $mail = trim($_POST['mail']);
    $cedula = trim($_POST['cedula']);
    $especialidad = $_POST['especialidad'];
    $pass_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $tip_usu = 3; // Rol de Pediatra definido en los requerimientos [cite: 22]

    // --- LÓGICA DE SUBIDA DE ARCHIVO ---
    // El pediatra debe proporcionar credenciales/comprobantes para ser validado por el admin 
    $nombre_archivo = $_FILES['titulo_archivo']['name'];
    $ruta_temporal = $_FILES['titulo_archivo']['tmp_name'];
    
    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
    $nuevo_nombre = "pediatra_" . time() . "_" . $cedula . "." . $extension;
    $ruta_destino = "../uploads/" . $nuevo_nombre;

    // Verificar que la carpeta 'uploads' exista
    if (!is_dir("../uploads/")) {
        mkdir("../uploads/", 0777, true);
    }

    if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
        // 1. Insertar en tabla 'usuarios' con estatus 0 (Pendiente de validación por Admin) 
        $sql_usr = "INSERT INTO usuarios (nom_usr, mail, pass, tip_usu, estatus) VALUES (?, ?, ?, ?, 0)";
        $stmt_usr = mysqli_prepare($conn, $sql_usr);
        mysqli_stmt_bind_param($stmt_usr, "sssi", $nombre, $mail, $pass_hash, $tip_usu);
        
        if (mysqli_stmt_execute($stmt_usr)) {
            $id_generado = mysqli_insert_id($conn);
            
            // 2. Insertar datos médicos en 'datos_pediatras' relacionando con el ID de usuario
            $sql_med = "INSERT INTO datos_pediatras (id_pediatra, cedula_profesional, especialidad, archivo_acreditacion) VALUES (?, ?, ?, ?)";
            $stmt_med = mysqli_prepare($conn, $sql_med);
            
            // CORRECCIÓN: Se agregó la coma faltante entre $stmt_med e "isss"
            mysqli_stmt_bind_param($stmt_med, "isss", $id_generado, $cedula, $especialidad, $nuevo_nombre);
            mysqli_stmt_execute($stmt_med);

            header('Location: ../login.php?mensaje=' . urlencode('Solicitud enviada. Espera la validación del Admin.'));
            exit;
        }
    } else {
        header('Location: ../registro_pediatra.php?error=' . urlencode('Error al subir el comprobante.'));
        exit;
    }
}
?>