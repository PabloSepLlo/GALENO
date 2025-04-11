<?php
    require_once("../modelo/usuario.php");
    session_start();
    if (isset($_POST["id_usuario"])) {
        $usuario = new Usuario();
        $usuario->cargar_datos_desde_BBDD($_POST["id_usuario"]);
        $usuario->borrar_usuario();
        $_SESSION["msg"] = "Usuario borrado correctamente";
        header("Location: ./cargar_usuarios.php");
        exit();
    }
?>