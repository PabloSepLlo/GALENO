<?php
    require_once("../modelo/motivo_ingreso.php");
    session_start();
    $_SESSION["datos_migr"] = Motivo_ingreso::get_datos_migr();
    header('Location: ../vista/visor_consultas.php?filtrarMIGR');
    exit();
?>