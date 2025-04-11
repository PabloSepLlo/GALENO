<?php
    require_once("../modelo/usuario.php");
    session_start();
    $datos_usuarios = Usuario::get_datos_usuarios();
    if (!empty($datos_usuarios)) {
        $_SESSION["lista_usuarios"] = $datos_usuarios;
        header('Location: ../vista/gestionar_usuarios.php');
        exit();
    }
    else {
        $_SESSION["err"] = "Aún no hay usuarios añadidos";
        header('Location: ../vista/gestionar_usuarios.php');
        exit();
    }
?>