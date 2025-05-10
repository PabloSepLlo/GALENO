<?php
    require_once("../servicios/consultas_ingreso.php");
    session_start();
    $consultas = new Consultas_ingreso();
    $_SESSION["pacientes_por_migr"] = $consultas->datos_paciente_por_migr($_POST["motivo_ingreso"]);
    if (!empty($_SESSION["pacientes_por_migr"])) {
        header("Location: ../vista/visor_consultas_migr.php");
        exit();
    }
    else {
        $_SESSION["err"] = "No hay datos para el motivo de ingreso seleccionado";
        header("Location: ../vista/menu.php");
        exit();
    }
?>