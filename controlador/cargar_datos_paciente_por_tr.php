<?php
    require_once("../servicios/consultas_ingreso.php");
    session_start();
    $consultas = new Consultas_ingreso();
    $_SESSION["pacientes_por_tr"] = $consultas->datos_paciente_por_tr($_POST["tratamiento"]);
    if (!empty($_SESSION["pacientes_por_tr"])) {
        header("Location: ../vista/visor_consultas_tr.php");
        exit();
    }
    else {
        $_SESSION["err"] = "No hay datos para el tratamiento seleccionado";
        header("Location: ../vista/menu.php");
        exit();
    }
?>