<?php
/*$mensaje=$_POST['mail'];
echo htmlspecialchars($mensaje);*/
if($_SERVER['REQUEST_METHOD']==='POST'){//=== significa exactamente igual, incluyendo valor y tipo de dato
    session_start();
    if(isset($_POST['mail'],$_POST['pass'])){
        //echo _DIR_ . '/../lib/public';
        require_once __DIR__. '/../config/db.php';
        $mail=trim($_POST['mail']);
        $password=trim($_POST['pass']);

        //Seguridad 1: correo@ejemplo.com' OR '1'='1
        /*$sql = "SELECT * FROM usuario WHERE mail = '$mail'";
        $resultado = mysqli_query($conn, $sql);

        $usuario = mysqli_fetch_assoc($resultado);
        print_r($usuario);*/

        //Seguridad 2: correo@ejemplo.com'; TRUNCATE TABLE usuario; --
        //$sql = "SELECT * FROM usuario WHERE mail = '$mail'";
        //mysql_multi_query($conn, $sql);

        $sql="SELECT id_usr, nom_usr, mail, pass, tip_usu FROM usuario
        WHERE mail = ?";
        $query_preparada=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($query_preparada,"s",$mail);
        mysqli_stmt_execute($query_preparada);

        //Solo para el select
        $resultado=mysqli_stmt_get_result($query_preparada);
        /*print_r($resultado);
        echo "<br>";
        $usuario=mysqli_fetch_assoc($resultado);
        print_r($usuario);*/
        if($resultado && mysqli_num_rows($resultado)==1){
            // CÓDIGO CORREGIDO en procesar_login.php:
// ... (Líneas 33-34) ...
$usuario=mysqli_fetch_assoc($resultado);

// CAMBIO CRÍTICO: Usar password_verify() para comparar la contraseña plana
// con el hash guardado en la base de datos ($usuario['pass']).
if(password_verify($password, $usuario['pass'])){ 
    
    // Contraseña válida: Inicia las sesiones
    $_SESSION['id_usr']=$usuario['id_usr'];
    $_SESSION['nom_usr']=$usuario['nom_usr'];
    $_SESSION['mail']=$usuario['mail'];
    $_SESSION['tip_usu']=$usuario['tip_usu'];
    
    // ... (El resto de la lógica de redirección) ...
                if($usuario['tip_usu']==1){
                    mysqli_close($conn);
                    header("Location: ../public/admin/index.php");
                    exit;
                }elseif($usuario['tip_usu']==2){
                    mysqli_close($conn);
                    header("Location: ../public/cliente/indexCliente.php");
                    exit;
                }else{
                    mysqli_close($conn);
                    header('Location: ../public/login.php?error=' . urldecode('Usuario no reconocido. Validar credenciales'));
                    exit;
                }
            }else{
                header('Location: ../public/login.php?error='.urldecode('Credenciales incorrectas. Intente de nuevo'));
                exit;
            }
        }else{
            header('Location: ../public/login.php?error='.urldecode('Correo no regitrado'));
            exit;
        }

    }else{
       header('Location: ../public/login.php?error='.urldecode('Completa el formulario'));
       exit; 
    }
}else{
    header('Location: ../public/login.php?error='.urldecode('Acceso no permitido'));
exit;
}

?>