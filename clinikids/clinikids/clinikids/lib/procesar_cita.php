<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Parche de conexión
if (!isset($conexion) && isset($conn)) { $conexion = $conn; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recogemos el ID del usuario de la sesión (Tutor)
    $id_usr = $_SESSION['id_usr'] ?? null;
    
    // 2. Recogemos los datos del formulario
    $id_paciente = $_POST['id_paciente'];
    $id_pediatra = $_POST['id_pediatra'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $motivo      = $_POST['motivo'];
    $estatus     = "Pendiente";

    // 3. LA CORRECCIÓN: Usamos 'id_usr' en lugar de 'id_tutor'
    // También asegúrate de que 'fecha' y 'hora' coincidan con tu BD (pueden ser fecha_cita/hora_cita)
    $sql = "INSERT INTO citas (id_usr, id_paciente, id_pediatra, fecha, hora, motivo, estatus) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiissss", $id_usr, $id_paciente, $id_pediatra, $fecha, $hora, $motivo, $estatus);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Cita agendada con éxito'); window.location.href='mis_citas.php';</script>";
        } else {
            echo "Error al ejecutar: " . mysqli_error($conexion);
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
?>