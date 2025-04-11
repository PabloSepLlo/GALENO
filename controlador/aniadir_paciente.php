<?php
    require_once("../modelo/centro_salud.php");
    require_once("../modelo/ayuda_social.php");
    require_once("../modelo/convivencia.php");
    require_once("../modelo/motivo_inc.php");
    require_once("../modelo/ppal_cuidador.php");
    require_once("../modelo/paciente.php");
    session_start();
    if(isset($_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["sexo"], $_SESSION["edad"])){
            $paciente = new Paciente();
            $paciente->cargar_datos($_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["ape2"], $_SESSION["sexo"], $_SESSION["edad"], 
                $_SESSION["med"], $_SESSION["enf"], $_SESSION["co_morb"], $_SESSION["num_farm"], $_SESSION["grado_ulcera"], $_SESSION["dolor"], 
                $_SESSION["rip_domi"], $_SESSION["upp"], $_SESSION["in_ur"], $_SESSION["disf"], $_SESSION["in_fec"], $_SESSION["sv"], 
                $_SESSION["insom"], $_SESSION["sng"], $_SESSION["sob_cui"], $_SESSION["ocd"]);
            if ($_SESSION["centro_salud"] != null){
                $centro_salud = new Centro_salud();
                $centro_salud->cargar_datos_desde_BBDD($_SESSION["centro_salud"]);
                $paciente->set_centro_salud($centro_salud);
            }
            if ($_SESSION["motivo_inc"] != null){
                $motivo_inc = new Motivo_inc();
                $motivo_inc->cargar_datos_desde_BBDD($_SESSION["motivo_inc"]);
                $paciente->set_motivo_inc($motivo_inc);
            }
            if ($_SESSION["ayuda_social"] != null){
                $ayuda_social = new Ayuda_social();
                $ayuda_social->cargar_datos_desde_BBDD($_SESSION["ayuda_social"]);
                $paciente->set_ayuda_social($ayuda_social);
            }
            if ($_SESSION["convivencia"] != null){
                $convivencia = new Convivencia();
                $convivencia->cargar_datos_desde_BBDD($_SESSION["convivencia"]);
                $paciente->set_convivencia($convivencia);
            }
            if ($_SESSION["ppal_cuidador"] != null){
                $ppal_cuidador = new Ppal_cuidador();
                $ppal_cuidador->cargar_datos_desde_BBDD($_SESSION["ppal_cuidador"]);
                $paciente->set_ppal_cuidador($ppal_cuidador);
            }
            if ($paciente->aniadir_paciente()) {
                $_SESSION["msg"] = "Paciente añadido con éxito";
                header("Location: ./borrar_datos_formulario_paciente.php");
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