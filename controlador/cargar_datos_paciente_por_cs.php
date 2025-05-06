<?php
    require_once("../servicios/consultas_paciente.php");
    session_start();
    $consultas = new Consultas_paciente();
    $_SESSION["pacientes_por_cs"] = $consultas->datos_paciente_por_cs($_POST["centro_salud"]);
    unset($_GET["filtrarCS"]);
    header("Location: ../vista/visor_consultas.php");
    exit();
?>