<?php
    require_once("../modelo/ingreso.php");
    session_start();
    if (isset($_SESSION["id_ingreso"], $_SESSION["fecha_ingreso"])){
        $ingreso = new Ingreso();
        $ingreso->cargar_datos($_SESSION["fecha_ingreso"], $_SESSION["fecha_alta"], $_SESSION["reingreso"], $_SESSION["eco"],
                                $_SESSION["crf"], $_SESSION["crm"], $_SESSION["barthel"], $_SESSION["pfeiffer"], $_SESSION["cultivo"],
                                $_SESSION["minimental"], $_SESSION["analitica"], $_SESSION["NUM_VISIT"], $_SESSION["nhc"]);
        $ingreso->set_id($_SESSION['id_ingreso']);
        if ($_SESSION["motivo_ingreso"] != null) {
            $ingreso->set_motivo_ingreso($_SESSION["motivo_ingreso"]);
        }
        if ($_SESSION["procedencia"] != null) {
            $ingreso->set_procedencia($_SESSION["procedencia"]);
        }
        if ($_SESSION["destino"] != null) {
            $ingreso->set_destino($_SESSION["destino"]);
        }
        if (!empty($_SESSION["tratamientos"])){
            $ingreso->set_tratamientos($S_ESSION["tratamientos"]);
        }
        if ($ingreso->actualizar_ingreso($_SESSION["id_ingreso"])){
            $_SESSION["msg"] = "Ingreso actualizado";
            header("Location: ../vista/vista_resumen_paciente.php");
            exit();
        }
        else {
            $_SESSION["err"] = "No se ha podido actualizar el ingreso, revise los datos";
            header("Location: ../vista/vista_resumen_ingreso.php");
            exit();
        }
    }       
    else {
        $_SESSION["err"] = "Los valores no se han establecido correctamente";
        header("Location: ../vista/vista_resumen_ingreso.php");
        exit();
    }

?>