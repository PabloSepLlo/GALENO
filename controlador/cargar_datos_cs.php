<?php
    require_once("../modelo/centro_salud.php");
    session_start();
    $_SESSION["datos_cs"] = Centro_salud::get_datos_cs();
    header('Location: ../vista/visor_consultas.php?filtrarCS');
    exit();
?>