<?php  
    require_once("../modelo/paciente.php");
    session_start();
    if (isset($_POST["nhc"])) {
        $paciente = new Paciente();
        if ($paciente->cargar_datos_desde_BBDD($_POST["nhc"])) {
            $datos = $paciente->get_datos_paciente();
            $_SESSION["nhc"] = $datos["nhc"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["ape1"] = $datos["ape1"];
            $_SESSION["ape2"] = $datos["ape2"];
            $_SESSION["sexo"] = $datos["sexo"];
            $_SESSION["edad"] = $datos["edad"];
            $_SESSION["med"] = $datos["medico"];
            $_SESSION["enf"] = $datos["enfermera"];
            $_SESSION["co_morb"] = $datos["co_morb"];
            $_SESSION["num_farm"] = $datos["num_farm"];
            $_SESSION["grado_ulcera"] = $datos["grado_ulcera"];
            $_SESSION["rip_domi"] = $datos["rip_domi"];
            $_SESSION["in_ur"] = $datos["in_ur"];
            $_SESSION["in_fec"] = $datos["in_fec"];
            $_SESSION["insom"] = $datos["insom"];
            $_SESSION["sob_cui"] = $datos["sob_cui"];
            $_SESSION["dolor"] = $datos["dolor"];
            $_SESSION["upp"] = $datos["upp"];
            $_SESSION["disf"] = $datos["disf"];
            $_SESSION["sv"] = $datos["sv"];
            $_SESSION["sng"] = $datos["sng"];
            $_SESSION["ocd"] = $datos["ocd"];
            $_SESSION["centro_salud"] = $datos["centro_salud"];
            $_SESSION["motivo_inc"] = $datos["motivo_inc"];
            $_SESSION["ayuda_social"] = $datos["ayuda_social"];
            $_SESSION["convivencia"] = $datos["convivencia"];
            $_SESSION["ppal_cuidador"] = $datos["ppal_cuidador"];
            if (!empty($datos["lista_ingresos"])) {
                $_SESSION["lista_ingresos"] = []; 
                foreach ($datos["lista_ingresos"] as $datos_ingreso) {
                    $_SESSION["lista_ingresos"][] = [
                        "id" => $datos_ingreso["id"] ?? null,
                        "fecha_ingreso" => $datos_ingreso["fecha_ingreso"] ?? null,
                        "procedencia" => $datos_ingreso["procedencia"]["descripcion"] ?? null
                    ];
                }
            }
            else {
                $_SESSION["lista_ingresos"] = [];
            }
            if (isset($_GET["editando"])){
                $_SESSION["editando"] = true;
                header("Location: ./cargar_datos_form_pacientes.php");
                exit();
            }
            else if (isset($_GET["ingresando"])) {
                $_SESSION["ingresando"] = true;
                header("Location: ./cargar_datos_form_ingreso.php");
                exit();
            }
            else if (isset($_GET["consultando"])){
                header("Location: ./cargar_datos_form_pacientes.php?consultando");
                exit();
            }
        }
        else {
            $_SESSION["err"] = "No se ha encontrado el paciente. Revise el NHC introducido y vuelva a intentarlo";
            header("Location: ../vista/menu.php");
            exit();
        }
    }
?>