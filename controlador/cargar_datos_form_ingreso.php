<?php
    require_once("../modelo/motivo_ingreso.php");
    require_once("../modelo/procedencia.php");
    require_once("../modelo/destino.php");
    require_once("../modelo/tratamiento.php");
    session_start();
    $datos_migr = Motivo_ingreso::get_datos_migr();
    $datos_pr = Procedencia::get_datos_pr();
    $datos_de = Destino::get_datos_de();
    $datos_tr = Tratamiento::get_datos_tr();
    if (!empty($datos_migr) && !empty($datos_pr) && !empty($datos_de) && !empty($datos_tr)) {
        $_SESSION["datos_migr"] = $datos_migr;
        $_SESSION["datos_pr"] = $datos_pr;
        $_SESSION["datos_de"] = $datos_de;
        $_SESSION["datos_tr"] = $datos_tr;
        header('Location: ../vista/aniadir_ingreso_generales.php');
        exit();
    }
    else {
        $_SESSION["err"] = "Ha habido un problema cargando los datos";
        header('Location: ../vista/menu.php');
        exit();
    }
?>