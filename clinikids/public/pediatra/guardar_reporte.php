<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if (!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 3) {
    header("Location: ../login.php?error=" . urlencode("Acceso denegado"));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $id_cita = intval($_POST['id_cita']);
    $diagnostico = trim($_POST['diagnostico']);
    $recomendaciones = trim($_POST['recomendaciones']);

    if (empty($diagnostico)) {
        header("Location: indexPediatra.php?error=" . urlencode("El diagnóstico es obligatorio"));
        exit;
    }


    $sqlReporte = "INSERT INTO reportes (id_cita, diagnostico, recomendaciones) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sqlReporte);
    mysqli_stmt_bind_param($stmt, "iss", $id_cita, $diagnostico, $recomendaciones);

    if (mysqli_stmt_execute($stmt)) {
      
        $sqlUpdate = "UPDATE citas SET estatus = 'Confirmada' WHERE id_cita = ?";
        $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "i", $id_cita);
        mysqli_stmt_execute($stmtUpdate);

        mysqli_close($conn);
        header("Location: indexPediatra.php?mensaje=" . urlencode("Reporte clínico guardado exitosamente"));
        exit;
    } else {
        header("Location: indexPediatra.php?error=" . urlencode("Error al guardar en la base de datos"));
        exit;
    }
} else {
    header("Location: indexPediatra.php");
    exit;
}
