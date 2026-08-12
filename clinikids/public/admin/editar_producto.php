<?php
session_start();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$mensaje = isset($_GET['msg']) ? $_GET['msg'] : '';
require_once __DIR__ . '/../../config/db.php';
$id_prod = isset($_GET['id_prod']) ? intval($_GET['id_prod']) : 0;
if ($id_prod <= 0) {
    header('Location: ./catalogo.php?error=' . urlencode('ID de producto inválida'));
    exit;
}
$stmt = mysqli_prepare($conn, "SELECT id_prod, nom_prod,prec ,stock , img, estatus,`desc` FROM catalogo WHERE id_prod = ?");
mysqli_stmt_bind_param($stmt, "i", $id_prod);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result || mysqli_num_rows($result) !== 1) {
    mysqli_stmt_close($stmt);
    header('Location: ./catalogo.php?error=' . urlencode('Producto no encontrado'));
    exit;
}
$producto = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$nom_prod= htmlspecialchars($producto['nom_prod']);
$prec= htmlspecialchars($producto['prec']);
$stock=htmlspecialchars($producto['stock']);
$img = htmlspecialchars($producto['img']);
$estatus= htmlspecialchars($producto['estatus']);
$desc= htmlspecialchars($producto['desc']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar productos</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        
    </style>
</head>

<body>
    <main class="d-flex">
        <?php
        require_once __DIR__ .'/menu.php';
        ?>
        <div id="admin-main" class="p-4">
            <h1>Editar producto</h1>
            <?php
                if($mensaje){
            ?>
            <div class="alert alert-success alert-dismissible fade-show mb-4" role="alert">
                <?= htmlspecialchars($mensaje)?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
            </div>
            <?php }?>
            <?php if ($error){?>
                <div class="alert alert-danger alert-dismissible fade-show mb-4" role="alert">
                <?= htmlspecialchars($error)?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php }?>

             <form id="productsForm" class="needs-validation border rounded p-3 bg-white"
                  action="../../lib/gestor_productos.php" method="post" novalidate>
                <input type="hidden" name="id_prod" value="<?= $id_prod ?>">
                <input type="hidden" name="accion" value="editar">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre del producto</label>
                        <input type="text" id="nom_prod" name="nom_prod" class="form-control"
                        placeholder="Ej. Curso de Front End" minlength="2" maxlength="255"
                        value="<?= $nom_prod ?>">
                        <div class="valid-feedback">Nombre válido</div>
                        <div class="invalid-feedback">Nombre no válido usa 2-255 caracteres</div>
                    </div>
                    <div class="col-md-3">
                    <label class="form-label">Precio</label>
                    <input type="number" id="prec" name="prec" class="form-control"
                        placeholder="Ej.499.00" min="1" step="0.001" value="<?= $prec ?>" required>
                        <div class="valid-feedback">Precio válido</div>
                        <div class="invalid-feedback">Ingresa un precio válido (mayor a 0, con 2 decimales).</div>
                    </div>
                    <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control"
                        placeholder="Ej.25" min="0" step="1" value="<?= $stock ?>" required>
                        <div class="valid-feedback">Stock válido</div>
                        <div class="invalid-feedback">Ingresa un número entero mayor o igual a 0.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Imagen (URL)</label>
                        <input id="img" name="img" type="url" class="form-control"
                        placeholder="https://sitio/img/smb3.jpg" minlength="1"
                        maxlength="500" pattern="^https?://\S+\.(jpg|jpeg|png)$" 
                        value="<?= $img ?>" required>
                        <div class="valid-feedback">Ok</div>
                        <div class="invalid-feedback">Proporciona una ruta URL correcta de máximo 500 caracteres</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Estatus</label>
                        <select id="estatus" name="estatus" class="form-select" required>
                            <option value="">Selecciona una opción...</option>
                            <option value="Activo" <?= $estatus == 1 ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatus == 0 ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                        <div class="valid-feedback">Ok</div>
                        <div class="invalid-feedback">Favor de seleccionar un estatus válido</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="desc" id="desc" rows="4" class="form-control"
                        minlength="20" maxlength="500" placeholder="Describe el producto..."
                        required><?= $desc ?></textarea>
                        <div class="valid-feedback">Ok</div>
                        <div class="invalid-feedback">Escribe entre 20 y 500 caracteres</div>
                    </div>
                    <div class="col-6 mt-3">
                        <button class="btn btn-success" type="submit" name="accion"
                        value="editar">Actualizar</button>
                        <a class="btn btn-outline-success" href="./catalogo.php">Cancelar</a>   
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script>
        var form=document.getElementById('productsForm');
        var controls=form.querySelectorAll('.form-control, .form-select');
        form.addEventListener('submit',function(e){
            if(!form.checkValidity()){
                e.preventDefault();
                e.stopPropagation();
            }else{
                form.action='../../lib/gestor_productos.php';
                form.method='post';
            }
            form.classList.add('was-validated');
        })
    </script>
</body>

</html>
