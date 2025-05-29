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
        if (!empty($_SESSION["lista_tratamientos"])){
            $ingreso->set_tratamientos($_SESSION["lista_tratamientos"]);
        }
        if ($ingreso->actualizar_ingreso($_SESSION["id_ingreso"])){
            foreach ($_SESSION["lista_ingresos"] as &$datos_ingreso) { 
                /*El & hace que se referencie la session pudiendo hacer cambios
                directamente en la lista y que se muestre la nueva fecha y procedencia 
                si se ha actualizado*/
                if ($datos_ingreso["id"] == $_SESSION["id_ingreso"]) {
                    //Si se ha modificado el ingreso
                    $datos_ingreso["fecha_ingreso"] = $_SESSION["fecha_ingreso"];
                    //Actualizamos la fecha
                    foreach ($_SESSION["datos_pr"] as $pr) {
                        /*Usamos la sesion de datos de pr para mostrar las descripciones ya que solo
                        tenemos el id y completamos abajo $datos_ingreso["procedencia"] con el id que corresponda*/
                        if ($pr["id_procedencia"] == $_SESSION["procedencia"]) {
                            $descripcion_procedencia = $pr["descripcion"];
                            break;
                        }
                    }
                    $datos_ingreso["procedencia"] = $descripcion_procedencia;
                }
            }
            unset($datos_ingreso); // Rompe la referencia

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