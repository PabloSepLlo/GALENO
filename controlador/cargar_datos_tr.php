<?php
    require_once("../modelo/tratamiento.php");
    session_start();
    $_SESSION["datos_tr"] = Tratamiento::get_datos_tr();
    header('Location: ../vista/visor_consultas_tr.php?filtroTR');
    exit();
?>