<?php
    require_once("../modelo/usuario.php");
    require_once("../include/validaciones/validaciones.php");
    session_start();
    if (isset($_POST["id_usuario"], $_POST["pass_actual"], $_POST["pass1"], $_POST["pass2"])) {
        if ($_POST["pass1"] == $_POST["pass2"]){
            if (Validaciones::validar_pass($_POST["pass1"])) {
                $usuario = new Usuario();
                $usuario->cargar_datos_desde_BBDD($_POST["id_usuario"]);
                if ($usuario->cambiar_password($_POST["pass_actual"], $_POST["pass1"])){
                    $_SESSION["msg"] = "Contraseña actualizada";
                    header("Location: ../vista/mis_datos.php");
                    exit();
                }
                else {
                    $_SESSION["err"] = "Ha habido un problema al actualizar la contraseña";
                    header("Location: ../vista/mis_datos.php");
                    exit();
                }
            }
            else {
                $_SESSION["err"] = "La contraseña no cumple con los requisitos";
                header("Location: ../vista/mis_datos.php");
                exit();
            }
        }
        else {
            $_SESSION["err"] = "Deben coincidir las contraseñas";
            header("Location: ../vista/mis_datos.php");
            exit();
        } 
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ../vista/mis_datos.php");
        exit();
    }
?>