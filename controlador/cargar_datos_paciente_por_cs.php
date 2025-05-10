<?php
    require_once("../servicios/consultas_paciente.php");
    session_start();
    $consultas = new Consultas_paciente();
    $_SESSION["pacientes_por_cs"] = $consultas->datos_paciente_por_cs($_POST["centro_salud"]);
    if (!empty($_SESSION["pacientes_por_cs"])) {
        header("Location: ../vista/visor_consultas_cs.php");
        exit();
    }
    else {
        $_SESSION["err"] = "No hay datos para el centro de salud seleccionado";
        header("Location: ../vista/menu.php");
        exit();
    }

?>