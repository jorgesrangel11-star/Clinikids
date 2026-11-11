<?php
session_start();

if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 1){
    header('Location: ../login.php?error=' . urlencode('Acceso denegado'));
    exit;
}

require_once __DIR__ . '/../../config/db.php';


if(isset($_GET['id'])){
    $id_doctor = intval($_GET['id']); 

 
    $sql = "UPDATE usuarios SET estatus = 1 WHERE id_usr = ? AND tip_usu = 3";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_doctor);

    if(mysqli_stmt_execute($stmt)){
        mysqli_close($conn);
  
        header('Location: validar_pediatras.php?mensaje=' . urlencode('Doctor aprobado correctamente.'));
        exit;
    } else {
        mysqli_close($conn);
        header('Location: validar_pediatras.php?error=' . urlencode('No se pudo aprobar al doctor.'));
        exit;
    }
} else {
    header('Location: validar_pediatras.php');
    exit;
}
?>
