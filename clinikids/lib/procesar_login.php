<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    session_start();
    if(isset($_POST['mail'],$_POST['pass'])){
        require_once __DIR__. '/../config/db.php';
        $mail=trim($_POST['mail']);
        $password=trim($_POST['pass']);


        $sql = "SELECT u.id_usr, u.nom_usr, u.mail, u.pass, u.tip_usu, d.cedula_profesional 
                FROM usuarios u 
                LEFT JOIN datos_pediatras d ON u.id_usr = d.id_pediatra 
                WHERE u.mail = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $mail);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if($resultado && mysqli_num_rows($resultado) == 1){
            $usuario = mysqli_fetch_assoc($resultado);
            
            
            if(password_verify($password, $usuario['pass'])){
                
              
                $_SESSION['id_usr'] = $usuario['id_usr'];
                $_SESSION['nom_usr'] = $usuario['nom_usr'];
                $_SESSION['mail'] = $usuario['mail'];
                $_SESSION['tip_usu'] = $usuario['tip_usu'];

              
                if($usuario['tip_usu'] == 1){ 
                   
                    header("Location: ../public/admin/index.php");
                } elseif($usuario['tip_usu'] == 2){ 
                  
                    header("Location: ../public/cliente/indexCliente.php");
                } elseif($usuario['tip_usu'] == 3){ 
                
                    $_SESSION['id_pediatra'] = $usuario['id_usr'];
                    $_SESSION['cedula'] = $usuario['cedula_profesional'];
                    header("Location: ../public/pediatra/indexPediatra.php");
                } else {
                    header('Location: ../public/login.php?error=' . urlencode('Rol no asignado'));
                }
                mysqli_close($conn);
                exit;
            } else {
                header('Location: ../public/login.php?error=' . urlencode('Contraseña incorrecta'));
                exit;
            }
        } else {
            header('Location: ../public/login.php?error=' . urlencode('Correo no registrado'));
            exit;
        }

    } else {
       header('Location: ../public/login.php?error=' . urlencode('Completa el formulario'));
       exit; 
    }
} else {
    header('Location: ../public/login.php?error=' . urlencode('Acceso no permitido'));
    exit;
}
?>
