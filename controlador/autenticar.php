<?php
    require_once("../modelo/usuario.php");
    session_start();
    if (isset($_POST["user_name"], $_POST["pass"]) && !empty($_POST["user_name"]) && !empty($_POST["pass"])) {
        $usuario = new Usuario();
        if ($usuario->autenticar($_POST["user_name"], $_POST["pass"])) {
            $datos = $usuario->get_datos();
            $_SESSION["id_usuario"] = $datos["id"];
            header('Location: ../vista/menu.php');
            exit();
        }
        else {
            $_SESSION["err"] = "Error en la autenticación";
            header('Location: ../vista/iniciar_sesion.php');
            exit();
        }
    }
    else {
        $_SESSION["err"] = "Alguno de los campos esta incompleto";
        header('Location: ../vista/iniciar_sesion.php');
        exit();
    }
?>