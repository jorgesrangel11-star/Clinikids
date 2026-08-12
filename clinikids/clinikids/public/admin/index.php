<?php
session_start();
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 1){
    header('Location: ../login.php?error=' . urlencode('Acceso no autorizado'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        
    </style>
</head>

<body>
    <!-- CONTENIDO -->
    <main class="d-flex">
        <?php
        require_once __DIR__ .'/menu.php';
        ?>
        <div id="admin-main" class="p-4">
            <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nom_usr']) ?></h1>
            <p>Este es el panel de administrador.</p>
            <p>Aqui puedes gestionar los productos, lo que es poder agregar, editar o eliminar productos del catálogo.</p>
            <p>Ademas de eso puedes ver lo comentarios de los productos en un apartado que hay de comentarios.</p>
        </div>

    </main>
</body>

</html>