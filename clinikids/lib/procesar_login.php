<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    session_start();
    if(isset($_POST['mail'],$_POST['pass'])){
        require_once __DIR__. '/../config/db.php';
        $mail=trim($_POST['mail']);
        $password=trim($_POST['pass']);

        // Consultamos en la tabla real 'usuarios' [cite: 22, 84]
        // Hacemos un LEFT JOIN con 'datos_pediatras' para traer la cédula si es médico 
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
            
            // Verificamos la contraseña encriptada
            if(password_verify($password, $usuario['pass'])){
                
                // Guardamos datos comunes en la sesión
                $_SESSION['id_usr'] = $usuario['id_usr'];
                $_SESSION['nom_usr'] = $usuario['nom_usr'];
                $_SESSION['mail'] = $usuario['mail'];
                $_SESSION['tip_usu'] = $usuario['tip_usu'];

                // Redirección según el tipo de usuario (tip_usu) [cite: 22, 84]
                if($usuario['tip_usu'] == 1){ 
                    // Administrador [cite: 22]
                    header("Location: ../public/admin/index.php");
                } elseif($usuario['tip_usu'] == 2){ 
                    // Tutor (Cliente) [cite: 84]
                    header("Location: ../public/cliente/indexCliente.php");
                } elseif($usuario['tip_usu'] == 3){ 
                    // Pediatra 
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