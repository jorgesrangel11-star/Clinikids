<?php
@session_start();


require_once __DIR__ .'/../config/db.php';

function mostrar_productos(){
    global $conn;
    $sql="SELECT * FROM catalogo";
    $select_preparado=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($select_preparado);

    $resultado=mysqli_stmt_get_result($select_preparado);

    $productos=array();
    while($fila_bd=mysqli_fetch_assoc($resultado)){
        $productos[]=$fila_bd;
    }

    mysqli_stmt_close($select_preparado);
    return $productos;
}
function clientes(){
    global $conn;
    $sql="SELECT * FROM catalogo WHERE estatus = 1";
    $select_preparado=mysqli_prepare($conn,$sql);
    mysqli_stmt_execute($select_preparado);

    $resultado=mysqli_stmt_get_result($select_preparado);

    $productos=array();
    while($fila_bd=mysqli_fetch_assoc($resultado)){
        $productos[]=$fila_bd;
    }

    mysqli_stmt_close($select_preparado);
    return $productos;
}

function agregar_producto($nom_prod,$desc,$prec,$img,$estatus,$stock){
    global $conn;
    $sql="INSERT INTO catalogo (nom_prod,`desc`,prec,img,estatus,stock) VALUES (?,?,?,?,?,?)";
    $insert_preparado=mysqli_prepare($conn,$sql);

    if(!$insert_preparado){
        return[
            'estatus' => 'error',
            'mensaje' => 'Error en la base de datos'
        ];
    }

    mysqli_stmt_bind_param($insert_preparado, 'ssdsii',$nom_prod,$desc,$prec,$img,$estatus,$stock);
    $query_ok=mysqli_stmt_execute($insert_preparado);
    $rows_ok=mysqli_affected_rows($conn);
    mysqli_stmt_close($insert_preparado);

    if($query_ok && $rows_ok > 0){
        return[
            'estatus'=>'msg',
            'mensaje'=>'Producto agregado exitosamente'
        ];
    }else{
        return[
            'estatus'=>'error', 
            'mensaje'=>'Error al insertar el producto'
        ];
    }

}

function editar_producto($id_prod, $nom_prod, $desc, $prec, $img,$estatus, $stock){
    global $conn;
    $sql = "UPDATE catalogo SET nom_prod = ?, `desc` = ?, prec = ?, img = ?, estatus = ?, stock = ? WHERE id_prod = ?";
    $update_preparado = mysqli_prepare($conn, $sql);

    if(!$update_preparado){
        return [
            'estatus' => 'error',
            'mensaje' => 'Error en la ejecucion en la base de datos '
        ];
    }

   
    mysqli_stmt_bind_param($update_preparado, "ssdsiii", $nom_prod, $desc, $prec, $img, $estatus, $stock, $id_prod);
    $query_ok = mysqli_stmt_execute($update_preparado);
    $rows_ok = mysqli_affected_rows($conn);
    mysqli_stmt_close($update_preparado);

    if($query_ok){
        return [
            'estatus' => 'msg',
            'mensaje' => 'Producto actualizado exitosamente'
        ];
    }else{
        return [
            'estatus' => 'error',
            'mensaje' => 'Error al actualizar producto.'
        ];
    }
}

function eliminar_producto($id_prod){
    global $conn;
    $sql = "DELETE FROM catalogo WHERE id_prod = ?";
    $delete_preparado = mysqli_prepare($conn, $sql);
    if(!$delete_preparado){
        return [
            'estatus' => 'error',
            'mensaje' => 'Error en la ejecucion en la base de datos '
        ];
    }
    mysqli_stmt_bind_param($delete_preparado, 'i', $id_prod);
    $query_ok = mysqli_stmt_execute($delete_preparado); 
    $rows_ok = mysqli_affected_rows($conn);

    if($query_ok && $rows_ok > 0){
        return [
            'estatus' => 'msg',
            'mensaje' => 'Producto eliminado exitosamente'
        ];

    }else{
        return[
            'estatus' => 'error',
            'mensaje' => 'Error al eliminar producto. No hubo cambios'
        ];
    }
}


if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['accion'])){
        $accion=$_POST['accion'];
        switch($accion){
            case 'agregar':
                if(isset($_POST['nom_prod'], $_POST['desc'], $_POST['prec'],
                 $_POST['img'], $_POST['stock'], $_POST['estatus'])){

                    $nom_prod=trim($_POST['nom_prod']);
                    $desc=trim($_POST['desc']);
                    $prec=(float)$_POST['prec'];
                    $img=trim($_POST['img']);
                    // Esto es para el estatus
                    $estatus_str = trim($_POST['estatus']);
                    $estatus = ($estatus_str === 'Activo') ? 1 : 0; 

                    $stock=(int)$_POST['stock'];

                    $resultado=agregar_producto($nom_prod,$desc,$prec,$img,$estatus,$stock);

                    header('Location: ../public/admin/alta_productos.php?' . $resultado['estatus'] . '=' . urlencode($resultado['mensaje'])); // Usar urlencode
                    exit;

                }
                break;
            case 'editar':
                if(isset($_POST['id_prod'], $_POST['nom_prod'], $_POST['desc'], $_POST['prec'], $_POST['img'], $_POST['stock'], $_POST['estatus'])){

                    $id_prod = (int)$_POST['id_prod']; 
                    $nom_prod = trim($_POST['nom_prod']);
                    $desc = trim($_POST['desc']);
                    $prec = (float)$_POST['prec'];
                    $img = trim($_POST['img']);
                    $estatus_str = trim($_POST['estatus']); 
                    $estatus = ($estatus_str === 'Activo') ? 1 : 0;
                    $stock = (int)$_POST['stock'];

                    $resultado = editar_producto($id_prod, $nom_prod, $desc, $prec, $img, $estatus, $stock);
                    
                    header('Location: ../public/admin/editar_producto.php?id_prod=' . $id_prod . '&' . $resultado['estatus'] . '=' . urlencode($resultado['mensaje']));
                    exit;

                }

                break;
            case 'eliminar':
               if(isset($_POST['id_prod'])){
                    $id_prod = (int)$_POST['id_prod'];
                    $resultado = eliminar_producto($id_prod);
                    header('Location: ../public/admin/catalogo.php?' . $resultado['estatus'] . '=' . urlencode($resultado['mensaje']));
                    exit;

                    
                }

                break;
            default:
        }
    }else{
        echo "
        <sript>
            alert('Acción no detectada, intente de nuevo');
            window.location.href='../public/admin/catalogo.php';
        </script>
        ";
        exit;
    }
}
?>
