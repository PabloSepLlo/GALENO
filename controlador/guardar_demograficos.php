<?php
    require_once("../include/validaciones/validaciones.php");
    session_start();
    if (isset($_POST["nhc"], $_POST["nombre"], $_POST["ape1"], $_POST["sexo"], $_POST["edad"], 
    $_POST["ape2"], $_POST["med"], $_POST["enf"], $_POST["centro_salud"]) && Validaciones::validar_NHC($_POST["nhc"]) &&
        !empty($_POST["nhc"]) && !empty($_POST["nombre"]) && !empty($_POST["ape1"]) &&
        !empty($_POST["sexo"]) && !empty($_POST["edad"])) {
            $_SESSION["nhc"] = $_POST["nhc"];
            $_SESSION["nombre"] = $_POST["nombre"];
            $_SESSION["ape1"] = $_POST["ape1"];
            $_SESSION["ape2"] = !empty($_POST["ape2"]) ? $_POST["ape2"] : null;
            $_SESSION["sexo"] = $_POST["sexo"];
            $_SESSION["edad"] = $_POST["edad"];
            $_SESSION["centro_salud"] = !empty($_POST["centro_salud"]) ? $_POST["centro_salud"] : null;
            $_SESSION["med"] = !empty($_POST["med"]) ? $_POST["med"] : null;
            $_SESSION["enf"] = !empty($_POST["enf"]) ? $_POST["enf"] : null;
            header("Location: ../vista/aniadir_paciente_diagnosticos.php");
            exit();
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto o tiene formato erróneo";
        header("Location: ../vista/aniadir_paciente_demograficos.php");
        exit();
    }
?>
