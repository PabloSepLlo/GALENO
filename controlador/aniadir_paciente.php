<?php
    require_once("../modelo/paciente.php");
    session_start();
    if(isset($_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["sexo"], $_SESSION["edad"])){
            $paciente = new Paciente();
            $paciente->cargar_datos($_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["ape2"], $_SESSION["sexo"], $_SESSION["edad"], 
                $_SESSION["med"], $_SESSION["enf"], $_SESSION["co_morb"], $_SESSION["num_farm"], $_SESSION["grado_ulcera"], $_SESSION["dolor"], 
                $_SESSION["rip_domi"], $_SESSION["upp"], $_SESSION["in_ur"], $_SESSION["disf"], $_SESSION["in_fec"], $_SESSION["sv"], 
                $_SESSION["insom"], $_SESSION["sng"], $_SESSION["sob_cui"], $_SESSION["ocd"]);
            if ($_SESSION["centro_salud"] != null){
                $paciente->set_centro_salud($_SESSION["centro_salud"]);
            }
            if ($_SESSION["motivo_inc"] != null){
                $paciente->set_motivo_inc($_SESSION["motivo_inc"]);
            }
            if ($_SESSION["ayuda_social"] != null){
                $paciente->set_ayuda_social($_SESSION["ayuda_social"]);
            }
            if ($_SESSION["convivencia"] != null){
                $paciente->set_convivencia($_SESSION["convivencia"]);
            }
            if ($_SESSION["ppal_cuidador"] != null){
                $paciente->set_ppal_cuidador($_SESSION["ppal_cuidador"]);
            }
            if ($paciente->aniadir_paciente()) {
                $_SESSION["msg"] = "Paciente añadido con éxito";
                header("Location: ./borrar_datos_formulario.php");
                exit();
            }
            else {
                $_SESSION["err"] = "No se ha podido añadir el paciente, revise los datos";
                header("Location: ../vista/vista_resumen_paciente.php");
                exit();
            }
    }
    else {
        $_SESSION["err"] = "Los valores no se han establecido correctamente";
        header("Location: ../vista/vista_resumen_paciente.php");
        exit();
    }

?>