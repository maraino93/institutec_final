<?php
session_start();
require_once '../model/query.php';

$modelSql = new model_sql();

if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $resul = $modelSql->login($user, $password);

    if ($resul != false) {
        $dni= $resul['dni'];
        $name = $resul['name'];
        $mail = $resul['mail'];
        $rol = $resul['fk_rol_id'];
        $state = $resul['state'];
        $user_id = $resul['id_user'];
       
        $changed = $resul['password_changed'];
        $_SESSION['dni'] = $dni;
        $_SESSION['name'] = $name;
        $_SESSION['fk_rol_id'] = $rol;
        $_SESSION['id_user'] = $user_id;
        $_SESSION['mail']= $mail;
        
        

        if ($state == 1) {
            $_SESSION['state'] = $state;
            if ($changed == 0) {
                header("Location: ../views/views_changed_password.php");
                exit();
            }
            switch ($rol) {
                case 1:
                    header("Location: ../views/dashboard_preceptor_home.php?mensaje=correcto");
                    exit();
                case 2:
                    header("Location: ../views/dashboard-teacher.php?mensaje=correcto");
                    exit();
                case 3:
                    header("Location: ../views/dashboard-student.php?mensaje=correcto");
                    exit();
                default:
                    // Redirección predeterminada en caso de rol no reconocido
                    header("Location: ../views/default_page.php");
                    exit();
            }
        } else {
            header("Location: ../views/login.php?desactivo=error");
            exit();
        }
    } else {
        header("Location: ../views/login.php?no_coinciden=error");
        exit();
    }
}
?>
