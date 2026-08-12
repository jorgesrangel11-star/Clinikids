<?php
session_start();
// Si tienes validación, puedes dejar esto o quitarlo:
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentarios</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet">

    <style>
        .comentario-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }
        .producto {
            font-weight: bold;
            color: #0d6efd;
        }
        .cliente {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-4">
    <h2 class="text-center mb-4">Comentarios de Clientes</h2>

    <!-- COMENTARIOS PREDEFINIDOS, SIN BASE DE DATOS -->

    <div class="comentario-card">
        <span class="producto">Repuesto de ruedas</span>
        <p class="cliente">Carlos Gómez:</p>
        <p>Muy buen repuesto, le quedó perfecto a mi silla.</p>
    </div>

    <div class="comentario-card">
        <span class="producto">Cojín</span>
        <p class="cliente">María Pérez:</p>
        <p>Muy cómodo, me quitó el dolor de espalda.</p>
    </div>

    <div class="comentario-card">
        <span class="producto">Mochila para la silla</span>
        <p class="cliente">Ana López:</p>
        <p>Excelente calidad y muy práctica.</p>
    </div>

    <div class="comentario-card">
        <span class="producto">Luz reflectante</span>
        <p class="cliente">Luis Martínez:</p>
        <p>Se ve muy bien por las noches, me siento más seguro.</p>
    </div>

    <div class="comentario-card">
        <span class="producto">Limpiador para la silla</span>
        <p class="cliente">Jorge Ramírez:</p>
        <p>Funcionó perfecto, dejó todo brillante.</p>
    </div>

    <div class="comentario-card">
        <span class="producto">Kit de emergencia</span>
        <p class="cliente">Sofía Hernández:</p>
        <p>Muy útil, todos deberían tener uno.</p>
    </div>

</div>
<!-- boton de regresar -->
<div class="container mb-4">
    <a href="./index.php" class="btn btn-secondary">Regresar al Panel Admin</a>

<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>