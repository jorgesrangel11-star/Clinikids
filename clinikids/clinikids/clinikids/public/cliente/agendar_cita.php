<?php
session_start();
include_once "./menu.php";
require_once __DIR__ . '/../../config/db.php'; 

$id_tutor = $_SESSION['id_usr'] ?? 1;

$res_pacientes = mysqli_query($conn, "SELECT id_paciente, nombre FROM pacientes WHERE id_tutor = '$id_tutor'");
$res_docs = mysqli_query($conn, "SELECT id_pediatra, nombre FROM pediatras");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita - Clinikids</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f7ff;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 20px !important;
        }
        .card-header {
            background: linear-gradient(45deg, #007bff, #00d4ff) !important;
            border-radius: 15px 15px 0 0 !important;
            text-align: center;
        }
        .form-label {
            color: #444;
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            border: 1px solid #ced4da;
            padding: 10px 15px;
            border-radius: 10px !important;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 10px rgba(0,123,255,0.1);
            border-color: #007bff;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00d4ff) !important;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 12px !important;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.3);
        }
        #div_nuevo {
            background-color: #e9f4ff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header text-white py-4">
                        <h3 class="mb-0 fw-bold">Agendar Cita</h3>
                        <small class="opacity-75">Reserva la atención para tu pequeño</small>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="registrar_todo.php" method="POST">

                            <div class="mb-4">
                                <label class="form-label fw-bold">Paciente</label>
                                <select name="id_paciente" class="form-select mb-3" id="pac_select" onchange="toggleNuevo()">
                                    <option value="nuevo">-- REGISTRAR NUEVO PACIENTE --</option>
                                    <?php while($p = mysqli_fetch_assoc($res_pacientes)): ?>
                                        <option value="<?php echo $p['id_paciente']; ?>"><?php echo $p['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                
                                <div id="div_nuevo">
                                    <label class="form-label small fw-bold text-primary">Nombre del nuevo paciente</label>
                                    <input type="text" name="nom_paciente_nuevo" class="form-control" placeholder="Escribe el nombre completo...">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pediatra Especialista</label>
                                <select name="id_pediatra" class="form-select" required>
                                    <option value="" disabled selected>Selecciona un médico...</option>
                                    <?php while($d = mysqli_fetch_assoc($res_docs)): ?>
                                        <option value="<?php echo $d['id_pediatra']; ?>">Dr. <?php echo $d['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold">Fecha</label>
                                    <input type="date" name="fecha" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hora</label>
                                    <input type="time" name="hora" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Motivo de Consulta</label>
                                <textarea name="motivo" class="form-control" rows="3" placeholder="Ej: Control de rutina, fiebre, etc."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">
                                Confirmar y Agendar Cita
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-4 text-muted small">© 2026 Clinikids - Cuidado infantil con amor</p>
            </div>
        </div>
    </div>

    <script>
    function toggleNuevo() {
        var s = document.getElementById("pac_select");
        var d = document.getElementById("div_nuevo");
        if(s && d) {
            d.style.display = (s.value === "nuevo") ? "block" : "none";
        }
    }
    // Ejecutar al cargar para asegurar estado inicial
    window.onload = toggleNuevo;
    </script>
</body>
</html>