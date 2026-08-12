<?php
session_start();
require_once __DIR__ . '/../../config/db.php'; 

// Asegurar conexión
if (!isset($conexion) && isset($conn)) { $conexion = $conn; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // RF-01: Identificación del Tutor desde la sesión
    $id_tutor = $_SESSION['id_usr'] ?? 1; 
    
    $id_paciente = $_POST['id_paciente'];
    $id_pediatra = $_POST['id_pediatra'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $motivo      = $_POST['motivo'];
    $dudas       = $_POST['dudas'] ?? 'Sin dudas adicionales';
    $estatus     = "Pendiente";

    // RF-02: Registro de nuevo paciente si se seleccionó la opción
    if ($id_paciente === "nuevo") {
        $nombre_nuevo = $_POST['nom_paciente_nuevo'];
        $sql_pac = "INSERT INTO pacientes (nombre, id_tutor) VALUES (?, ?)";
        $stmt_pac = mysqli_prepare($conexion, $sql_pac);
        mysqli_stmt_bind_param($stmt_pac, "si", $nombre_nuevo, $id_tutor);
        
        if (mysqli_stmt_execute($stmt_pac)) {
            $id_paciente = mysqli_insert_id($conexion);
        } else {
            die("Error al registrar paciente: " . mysqli_error($conexion));
        }
    }

    // RF-03: Registro de la Cita con apartado de dudas integrado
    // Usando nombres reales de tu BD: fecha_cita y hora_cita
    $motivo_completo = "MOTIVO: " . $motivo . " | DUDAS: " . $dudas;

    $sql_cita = "INSERT INTO citas (id_tutor, id_paciente, id_pediatra, fecha_cita, hora_cita, motivo, estatus) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_cita = mysqli_prepare($conexion, $sql_cita);

    if ($stmt_cita) {
        mysqli_stmt_bind_param($stmt_cita, "iiissss", $id_tutor, $id_paciente, $id_pediatra, $fecha, $hora, $motivo_completo, $estatus);
        
        if (mysqli_stmt_execute($stmt_cita)) {
            echo "<script>
                    alert('¡Cita registrada correctamente!');
                    window.location.href = 'mis_citas.php';
                  </script>";
        } else {
            echo "Error al insertar cita: " . mysqli_error($conexion);
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
?>