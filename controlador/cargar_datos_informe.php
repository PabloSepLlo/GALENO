<?php
    require_once("../servicios/consultas_ingreso.php");
    require_once("../servicios/consultas_paciente.php");
    session_start();
    if (isset($_POST["fecha_inicio"], $_POST["fecha_fin"])) {
        $_SESSION["fecha_inicio"] = $_POST["fecha_inicio"];
        $_SESSION["fecha_fin"] = $_POST["fecha_fin"];
        $consultas_ingreso = new Consultas_ingreso();
        $_SESSION["num_ingresos"] = $consultas_ingreso->get_n_ingreso($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["datos_ingresos"] = $consultas_ingreso->get_datos_ingresos($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["crm"] = $consultas_ingreso->get_datos_crm($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["crf"] = $consultas_ingreso->get_datos_crf($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["barthel"] = $consultas_ingreso->get_datos_barthel($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["pfeiffer"] = $consultas_ingreso->get_datos_pfeiffer($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["procedencia"] = $consultas_ingreso->get_ingreso_pr($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["motivo_ingreso"] = $consultas_ingreso->get_ingreso_migr($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["destino"] = $consultas_ingreso->get_ingreso_de($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["rip_domi"] = $consultas_ingreso->get_porcentaje_muerte_domicilio($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["avg_ingreso"] = $consultas_ingreso->get_media_dias_ingreso($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $consultas_paciente = new Consultas_paciente();
        $_SESSION["datos_paciente"] = $consultas_paciente->get_datos_paciente($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["grado_ulcera"] = $consultas_paciente->get_grados_ulcera($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["centro_salud"] = $consultas_paciente->get_paciente_cs($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["convivencia"] = $consultas_paciente->get_paciente_c($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["ppal_cuidador"] = $consultas_paciente->get_paciente_pc($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["ayuda_social"] = $consultas_paciente->get_paciente_as($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        $_SESSION["motivo_inc"] = $consultas_paciente->get_paciente_mi($_POST["fecha_inicio"], $_POST["fecha_fin"]);
        header('Location: ../vista/visor_consultas_informe.php?informe_generado');
        exit();
    }
    else {
        $_SESSION["err"] = "No se ha podido generar el PDF, revise los datos";
        header('Location: ../vista/gestionar_usuarios.php');
        exit();
    }
?>