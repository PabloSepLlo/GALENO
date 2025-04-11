<?php
    require_once("../modelo/usuario.php");
    session_start();
    if (isset($_POST["id_usuario"], $_POST["nombre"], $_POST["ape1"], $_POST["ape2"], $_POST["nombre_usuario"], $_POST["administrador"]) &&
        !empty($_POST["id_usuario"]) && !empty($_POST["nombre"]) && !empty($_POST["ape1"]) && !empty($_POST["ape2"]) && !empty($_POST["nombre_usuario"]) && 
        !empty($_POST["administrador"])) {
        $usuario = new Usuario();
        $usuario->cargar_datos_desde_BBDD($_POST["id_usuario"]);
        if ($usuario->actualizar_usuario($_POST["nombre_usuario"], $_POST["nombre"], $_POST["ape1"], $_POST["ape2"], $_POST["administrador"])){
            $_SESSION["msg"] = "Usuario actualizado";
            header("Location: ./cargar_usuarios.php");
            exit();
        }
        else {
            header("Location: ../vista/gestionar_usuarios.php");
            exit();
        }
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ./cargar_usuarios.php");
        exit();
    }
?>