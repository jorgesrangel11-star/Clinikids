<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Parche de conexión
if (!isset($conexion) && isset($conn)) { $conexion = $conn; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tutor = $_SESSION['id_usr'] ?? null;
    $id_paciente = $_POST['id_paciente']; // Puede ser un ID o la palabra "nuevo"
    $id_pediatra = $_POST['id_pediatra'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];
    $estatus = "Pendiente";

    // --- ESCENARIO 1: SI EL PACIENTE ES NUEVO ---
    if ($id_paciente === "nuevo") {
        $nombre_nuevo = $_POST['nom_paciente_nuevo'];
        
        // Primero insertamos al nuevo paciente
        $sql_pac = "INSERT INTO pacientes (nombre, id_tutor) VALUES (?, ?)";
        $stmt_pac = mysqli_prepare($conexion, $sql_pac);
        mysqli_stmt_bind_param($stmt_pac, "si", $nombre_nuevo, $id_tutor);
        
        if (mysqli_stmt_execute($stmt_pac)) {
            // Obtenemos el ID que se le asignó al nuevo niño
            $id_paciente = mysqli_insert_id($conexion);
        } else {
            die("Error al registrar al nuevo paciente: " . mysqli_error($conexion));
        }
    }

    // --- ESCENARIO 2: REGISTRAR LA CITA ---
    // Intentamos con 'id_usr' que es el que parece tener tu tabla
    $sql_cita = "INSERT INTO citas (id_usr, id_paciente, id_pediatra, fecha, hora, motivo, estatus) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_cita = mysqli_prepare($conexion, $sql_cita);

    // Si falla por el nombre de la columna, intentamos con 'id_usuario'
    if (!$stmt_cita) {
        $sql_cita = "INSERT INTO citas (id_usuario, id_paciente, id_pediatra, fecha, hora, motivo, estatus) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_cita = mysqli_prepare($conexion, $sql_cita);
    }

    if ($stmt_cita) {
        mysqli_stmt_bind_param($stmt_cita, "iiissss", $id_tutor, $id_paciente, $id_pediatra, $fecha, $hora, $motivo, $estatus);
        
        if (mysqli_stmt_execute($stmt_cita)) {
            echo "<script>
                    alert('¡Paciente y Cita registrados con éxito!');
                    window.location.href = 'mis_citas.php';
                  </script>";
        } else {
            echo "Error al registrar la cita: " . mysqli_error($conexion);
        }
    } else {
        echo "Error de estructura: No se encuentra la columna de usuario en la tabla citas.";
    }
}
?>