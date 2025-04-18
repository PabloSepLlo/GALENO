<?php
    require_once("../modelo/paciente.php");
    session_start();
    if(isset($_SESSION["nhc"], $_SESSION["fecha_ingreso"])){
            $paciente = new Paciente();
            $paciente->cargar_datos_desde_BBDD($_SESSION["nhc"]);
            if ($paciente->ingresar($_SESSION["fecha_ingreso"], $_SESSION["fecha_alta"], $_SESSION["reingreso"], $_SESSION["eco"],
                                    $_SESSION["crf"], $_SESSION["crm"], $_SESSION["barthel"], $_SESSION["pfeiffer"], $_SESSION["cultivo"],
                                    $_SESSION["minimental"], $_SESSION["analitica"], $_SESSION["NUM_VISIT"], $_SESSION["procedencia"], 
                                    $_SESSION["destino"], $_SESSION["motivo_ingreso"], $_SESSION["tratamientos"])) {
                $_SESSION["msg"] = "Ingreso añadido con éxito";
                header("Location: ./borrar_datos_formulario_ingreso.php");
                exit();
            }
            else {
                $_SESSION["err"] = "Ha habido algun problema, revise los datos";
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