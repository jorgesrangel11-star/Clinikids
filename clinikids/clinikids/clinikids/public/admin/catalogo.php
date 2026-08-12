<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catalogo productos/servicios</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- CONTENIDO -->
     <main class="d-flex">
        <?php
        require_once __DIR__ . '/menu.php';
        ?>
        <div id="admin-main" class="p-4">
            <h1>Catalogo de productos/servicios</h1>
            <a href="./alta_productos.php" class="btn btn-primary mt-3">Agregar productos</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre productos</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th class="w-25">Imagen</th>
                        <th>Estatus</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    require_once __DIR__ . '/../../lib/gestor_productos.php';

                    $productos = mostrar_productos();
                    foreach ($productos as $fila_tabla) {
                    ?>
                        <tr> 
                            <td><?php echo $fila_tabla['id_prod']; ?></td>
                            <td><?php echo $fila_tabla['nom_prod']; ?></td>
                            <td><?php echo $fila_tabla['desc']; ?></td>
                            <td><?php echo $fila_tabla['prec']; ?></td>
                           <td>
                                <img class="img-fluid" src="<?= $fila_tabla['img'] ?>" alt="<?= $fila_tabla['nom_prod'] ?>">
                            </td>
                            <td><?= $fila_tabla['estatus'] ? "Activo" : "Inactivo" ?></td>
                            <td><?php echo $fila_tabla['stock']; ?></td>
                            <td>
                                <a class="btn btn-warning m-1" href="./editar_producto.php?id_prod=<?php echo$fila_tabla['id_prod']?>">Editar</a>
                                <form method="POST" action="../../lib/gestor_productos.php" onsubmit="return confirm('¿Eliminar este producto?');" style="display:inline">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id_prod" value="<?= $fila_tabla['id_prod'] ?>"> 
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>

     </main>
</body>

</html>