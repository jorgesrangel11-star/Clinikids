<?php
session_start();
if (!isset($_SESSION['id_pediatra'])) {
    header("Location: ../cliente/login.php");
    exit();
}

require_once '../config/db.php';

if (!isset($_GET['id_cita'])) {
    echo "Cita no especificada.";
    exit();
}

$id_cita = $_GET['id_cita'];

$sql = "SELECT c.id_cita, p.nombre AS paciente 
        FROM citas c 
        JOIN pacientes p ON c.id_paciente = p.id_paciente 
        WHERE c.id_cita = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cita);
$stmt->execute();
$result = $stmt->get_result();
$cita = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Reporte | Clinikids</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        textarea { width: 100%; height: 150px; margin-bottom: 10px; padding: 10px; }
        .btn-save { background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Generar Reporte Clínico</h2>
        <p><strong>Paciente:</strong> <?php echo $cita['paciente']; ?></p>
        
        <form action="guardar_reporte.php" method="POST">
            <input type="hidden" name="id_cita" value="<?php echo $id_cita; ?>">
            
            <label>Diagnóstico y Observaciones:</label>
            <textarea name="diagnostico" required placeholder="Escriba el diagnóstico detallado..."></textarea>
            
            <label>Recomendaciones / Tratamiento:</label>
            <textarea name="recomendaciones" required placeholder="Medicamentos, dosis o cuidados especiales..."></textarea>
            
            <button type="submit" class="btn-save">Guardar y Finalizar Consulta</button>
            <a href="indexPediatra.php">Cancelar</a>
        </form>
    </div>
</body>
</html>