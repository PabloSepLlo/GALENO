<?php
    require_once("../modelo/centro_salud.php");
    require_once("../modelo/ayuda_social.php");
    require_once("../modelo/convivencia.php");
    require_once("../modelo/motivo_inc.php");
    require_once("../modelo/ppal_cuidador.php");
    session_start();
    $datos_cs = Centro_salud::get_datos_cs();
    $datos_as = Ayuda_social::get_datos_as();
    $datos_c = Convivencia::get_datos_c();
    $datos_mi = Motivo_inc::get_datos_mi();
    $datos_pc = Ppal_cuidador::get_datos_pc();
    if (!empty($datos_cs) && !empty($datos_as) && !empty($datos_c) && !empty($datos_mi) && !empty($datos_pc)) {
        $_SESSION["datos_cs"] = $datos_cs;
        $_SESSION["datos_as"] = $datos_as;
        $_SESSION["datos_c"] = $datos_c;
        $_SESSION["datos_mi"] = $datos_mi;
        $_SESSION["datos_pc"] = $datos_pc;
        header('Location: ../vista/aniadir_paciente_demograficos.php');
        exit();
    }
    else {
        $_SESSION["err"] = "Ha habido un problema cargando los datos";
        header('Location: ../vista/menu.php');
        exit();
    }
?>