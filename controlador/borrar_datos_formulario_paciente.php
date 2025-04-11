<?php
session_start();
if (!isset($_SESSION["editando"])){
        unset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"], 
                $_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["ape2"], $_SESSION["sexo"], $_SESSION["edad"], 
                $_SESSION["centro_salud"], $_SESSION["med"], $_SESSION["enf"], $_SESSION["motivo_inc"], $_SESSION["co_morb"], 
                $_SESSION["num_farm"], $_SESSION["grado_ulcera"], $_SESSION["dolor"], $_SESSION["rip_domi"], $_SESSION["upp"], $_SESSION["in_ur"], 
                $_SESSION["disf"], $_SESSION["in_fec"], $_SESSION["sv"], $_SESSION["insom"], $_SESSION["sng"], $_SESSION["sob_cui"], $_SESSION["ocd"],
                $_SESSION["ayuda_social"], $_SESSION["convivencia"], $_SESSION["ppal_cuidador"]);
        header("Location: ../vista/menu.php");
}
else {
        unset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"], 
                $_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["ape2"], $_SESSION["sexo"], $_SESSION["edad"], 
                $_SESSION["centro_salud"], $_SESSION["med"], $_SESSION["enf"], $_SESSION["motivo_inc"], $_SESSION["co_morb"], 
                $_SESSION["num_farm"], $_SESSION["grado_ulcera"], $_SESSION["dolor"], $_SESSION["rip_domi"], $_SESSION["upp"], $_SESSION["in_ur"], 
                $_SESSION["disf"], $_SESSION["in_fec"], $_SESSION["sv"], $_SESSION["insom"], $_SESSION["sng"], $_SESSION["sob_cui"], $_SESSION["ocd"],
                $_SESSION["ayuda_social"], $_SESSION["convivencia"], $_SESSION["ppal_cuidador"], $_SESSION["editando"]);
        header("Location: ../vista/menu.php");
}
exit();
?>