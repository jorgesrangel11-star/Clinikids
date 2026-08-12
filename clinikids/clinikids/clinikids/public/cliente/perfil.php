<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Asegurar conexión
if (!isset($conexion) && isset($conn)) { $conexion = $conn; }

// Verificar sesión
if (!isset($_SESSION['id_usr'])) {
    header("Location: ../login.php");
    exit();
}

$id_tutor = $_SESSION['id_usr'];

// Consulta de datos del tutor (según tu tabla 'tutores')
$query_tutor = mysqli_query($conexion, "SELECT nombre, mail, fecha_registro FROM tutores WHERE id_tutor = '$id_tutor'");
$datos = mysqli_fetch_assoc($query_tutor);

// Consulta para contar cuántos hijos (pacientes) tiene registrados
$query_hijos = mysqli_query($conexion, "SELECT COUNT(*) as total FROM pacientes WHERE id_tutor = '$id_tutor'");
$total_hijos = mysqli_fetch_assoc($query_hijos)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - CliniKids</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f7ff; font-family: 'Poppins', sans-serif; }
        .profile-card { border: none; border-radius: 25px; overflow: hidden; }
        .profile-header { background: linear-gradient(45deg, #013970, #007bff); color: white; padding: 40px 20px; }
        .avatar-circle { width: 100px; height: 100px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #013970; }
        .info-label { color: #6c757d; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
        .info-value { color: #212529; font-size: 1.1rem; font-weight: 500; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include_once "./menu.php"; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card profile-card shadow-lg">
                    <div class="profile-header text-center">
                        <div class="avatar-circle shadow">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                        <h3 class="mb-0"><?php echo $datos['nombre']; ?></h3>
                        <p class="opacity-75 mb-0">Tutor CliniKids</p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="row text-center mb-4">
                            <div class="col-6 border-end">
                                <h4 class="fw-bold text-primary mb-0"><?php echo $total_hijos; ?></h4>
                                <small class="text-muted">Hijos registrados</small>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-bold text-primary mb-0">Tutor</h4>
                                <small class="text-muted">Tipo de Usuario</small>
                            </div>
                        </div>

                        <hr class="mb-4 opacity-25">

                        <div class="info-group">
                            <p class="info-label mb-1">Correo Electrónico</p>
                            <p class="info-value"><i class="bi bi-envelope me-2 text-primary"></i><?php echo $datos['mail']; ?></p>
                            
                            <p class="info-label mb-1">Miembro desde</p>
                            <p class="info-value">
                                <i class="bi bi-calendar-check me-2 text-primary"></i>
                                <?php echo date("d/m/Y", strtotime($datos['fecha_registro'])); ?>
                            </p>

                            <p class="info-label mb-1">ID de Usuario</p>
                            <p class="info-value"><i class="bi bi-hash me-2 text-primary"></i><?php echo $id_tutor; ?></p>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <a href="./indexCliente.php" class="btn btn-outline-primary rounded-pill">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>