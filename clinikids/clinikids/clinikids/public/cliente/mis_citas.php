<?php
// 1. Configuración de sesión y base de datos
session_start();
require_once __DIR__ . '/../../config/db.php'; 

// 2. Parche de compatibilidad para la conexión (Soporta $conn o $conexion)
if (!isset($conexion) && isset($conn)) { $conexion = $conn; }
if (!isset($conn) && isset($conexion)) { $conn = $conexion; }

if (!$conexion) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Error: No se pudo conectar a la base de datos.</div></div>");
}

include_once "./menu.php";

$id_tutor = $_SESSION['id_usr'] ?? null;
$citas_query = null;

if ($id_tutor) {
    /**
     * NOTA: Usamos SELECT * para evitar el error de "Unknown column" en el listado inicial.
     * El INNER JOIN conecta con pacientes (para el nombre del niño) 
     * y con pediatras (para el nombre del doctor).
     */
    $sql = "SELECT c.*, p.nombre AS nombre_paciente, d.nombre AS nombre_pediatra 
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN pediatras d ON c.id_pediatra = d.id_pediatra
            WHERE c.id_tutor = ?
            ORDER BY 1 DESC"; // Ordena por la primera columna (usualmente el ID)
            
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_tutor);
        mysqli_stmt_execute($stmt);
        $citas_query = mysqli_stmt_get_result($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Citas - Clinikids</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f0f7ff; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 20px !important; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(45deg, #007bff, #00d4ff) !important; padding: 2rem; }
        .badge-pendiente { background-color: #ffc107; color: #000; }
        .badge-confirmada { background-color: #28a745; color: #fff; }
        .badge-completada { background-color: #17a2b8; color: #fff; }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card">
                    <div class="card-header text-white text-center">
                        <h3 class="mb-0 fw-bold">Mis Citas Agendadas</h3>
                        <p class="mb-0 opacity-75">Consulta el historial médico de tus hijos</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-secondary mb-0">Listado de Consultas</h5>
                            <a href="agendar_cita.php" class="btn btn-primary fw-bold rounded-pill px-4">
                                <i class="bi bi-plus-circle me-2"></i>Nueva Cita
                            </a>
                        </div>
                        
                        <?php if (!$id_tutor): ?>
                            <div class="alert alert-warning text-center border-0 shadow-sm">
                                <i class="bi bi-exclamation-octagon fs-1 d-block mb-3"></i>
                                <h5>Inicia Sesión</h5>
                                <p>Debes ingresar a tu cuenta para ver tus citas.</p>
                                <a href="../login.php" class="btn btn-primary">Ir al Login</a>
                            </div>

                        <?php elseif ($citas_query && mysqli_num_rows($citas_query) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha y Hora</th>
                                            <th>Paciente</th>
                                            <th>Pediatra</th>
                                            <th>Motivo</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($c = mysqli_fetch_assoc($citas_query)): 
                                            // DETECCIÓN AUTOMÁTICA DE COLUMNAS DE FECHA/HORA
                                            $fecha = $c['fecha_cita'] ?? $c['fecha'] ?? $c['fecha_consulta'] ?? 'N/A';
                                            $hora = $c['hora_cita'] ?? $c['hora'] ?? $c['hora_consulta'] ?? '--:--';
                                            $estatus = $c['estatus'] ?? 'Pendiente';
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-primary"><?php echo $fecha; ?></span><br>
                                                    <small class="text-muted"><i class="bi bi-clock me-1"></i><?php echo $hora; ?></small>
                                                </td>
                                                <td class="fw-semibold"><?php echo htmlspecialchars($c['nombre_paciente']); ?></td>
                                                <td>Dr. <?php echo htmlspecialchars($c['nombre_pediatra']); ?></td>
                                                <td>
                                                    <small class="text-muted"><?php echo htmlspecialchars($c['motivo']); ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill badge-<?php echo strtolower($estatus); ?> px-3 py-2">
                                                        <?php echo $estatus; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                <h4 class="text-muted mt-3">No hay citas registradas</h4>
                                <p>Una vez que agendes una cita, aparecerá en esta lista.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>