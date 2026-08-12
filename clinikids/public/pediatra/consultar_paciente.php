<?php
session_start();
if (!isset($_SESSION['id_pediatra'])) {
    header("Location: ../cliente/login.php");
    exit();
}

require_once '../config/db.php';

// Validar que recibimos un ID de paciente
if (!isset($_GET['id'])) {
    echo "Paciente no especificado.";
    exit();
}

$id_paciente = $_GET['id'];

// Consulta para obtener datos del paciente y su tutor (usando tus tablas)
$sql = "SELECT p.nombre AS paciente, t.nombre AS tutor, t.mail 
        FROM pacientes p 
        JOIN tutores t ON p.id_tutor = t.id_tutor 
        WHERE p.id_paciente = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "No se encontró la información del paciente.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Paciente | Clinikids</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 500px; margin: 20px auto; background: #f9f9f9; }
        .back-link { display: block; margin-top: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Información del Paciente</h2>
        <p><strong>Nombre del Menor:</strong> <?php echo $data['paciente']; ?></p>
        <hr>
        <h3>Datos del Tutor Responsable</h3>
        <p><strong>Nombre:</strong> <?php echo $data['tutor']; ?></p>
        <p><strong>Correo de Contacto:</strong> <?php echo $data['mail']; ?></p>
        
        <a href="indexPediatra.php" class="back-link">← Volver al listado de citas</a>
    </div>
</body>
</html>