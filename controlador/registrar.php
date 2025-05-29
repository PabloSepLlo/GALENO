<?php
    require_once("../modelo/usuario.php");
    require_once("../include/validaciones/validaciones.php");
    session_start();
    if (isset($_POST['user_name'], $_POST['nombre'], $_POST['ape1'], $_POST['ape2'], $_POST['pass1'], $_POST['pass2']) &&
    !empty($_POST['user_name']) && !empty($_POST['nombre']) && !empty($_POST['ape1']) && !empty($_POST['ape2']) &&
    !empty($_POST['pass1']) && !empty($_POST['pass2'])) {
        if ($_POST["pass1"] == $_POST["pass2"]){
            if (Validaciones::validar_pass($_POST["pass1"])) { 
                $usuario = new Usuario();
                $usuario->cargar_datos($_POST["user_name"], $_POST["nombre"], $_POST["ape1"], $_POST["ape2"], $_POST["pass1"]);
                if ($usuario->registrar_usuario()){
                    $_SESSION["msg"] = "Usuario registrado con éxito. Inicie sesión";
                    header('Location: ../vista/iniciar_sesion.php');
                    exit();
                }
                else {
                    $_SESSION["err"] = "El nombre de usuario ya existe";
                    header('Location: ../vista/registrar.php');
                    exit();
                } 
            }
            else {
                $_SESSION["err"] = "La contraseña no cumple con los requisitos";
                header("Location: ../vista/registrar.php");
                exit();
            }
        }
        else {
            $_SESSION["err"] = "Deben coincidir las contraseñas";
            header('Location: ../vista/registrar.php');
            exit();
        }
    }
    else {
        $_SESSION["err"] = "Alguno de los campos esta incompleto";
        header('Location: ../vista/registrar.php');
        exit();
    }
?>