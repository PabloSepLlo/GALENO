<?php
    require_once("../modelo/ingreso.php");
    session_start();
    if (isset($_POST["id_ingreso"], $_SESSION["lista_ingresos"])) {
        foreach ($_SESSION["lista_ingresos"] as $ingreso_paciente) {
            if ($ingreso_paciente["id"] == $_POST["id_ingreso"]){
                $ingreso = new Ingreso();
                $ingreso->cargar_datos_desde_BBDD($_POST["id_ingreso"]);
                $datos_ingreso = $ingreso->get_datos_ingreso();
                $_SESSION["id_ingreso"] = $datos_ingreso["id"];
                $_SESSION["fecha_ingreso"] = $datos_ingreso["fecha_ingreso"];
                $_SESSION["fecha_alta"] = $datos_ingreso["fecha_alta"];
                $_SESSION["reingreso"] = $datos_ingreso["reingreso"];
                $_SESSION["eco"] = $datos_ingreso["eco"];
                $_SESSION["crf"] = $datos_ingreso["crf"];
                $_SESSION["crm"] = $datos_ingreso["crm"];
                $_SESSION["barthel"] = $datos_ingreso["barthel"];
                $_SESSION["pfeiffer"] = $datos_ingreso["pfeiffer"];
                $_SESSION["minimental"] = $datos_ingreso["minimental"];
                $_SESSION["cultivo"] = $datos_ingreso["cultivo"];
                $_SESSION["analitica"] = $datos_ingreso["analitica"];
                $_SESSION["NUM_VISIT"] = $datos_ingreso["NUM_VISIT"];
                $_SESSION["nhc"] = $datos_ingreso["nhc"];
                $_SESSION["motivo_ingreso"] = $datos_ingreso["motivo_ingreso"];
                $_SESSION["procedencia"] = $datos_ingreso["procedencia"] ? $datos_ingreso["procedencia"]["id"] : null;
                $_SESSION["destino"] = $datos_ingreso["destino"];
                $_SESSION["lista_tratamientos"] = $datos_ingreso["lista_tratamientos"];
                header("Location: ./cargar_datos_form_ingreso.php");
                exit();
            }
        }
    }
    else {
        $_SESSION["err"] = "Ha habido algún problema para editar este ingreso";
        header("Location: ../vista/vista_resumen_paciente.php");
        exit();
    }
?>