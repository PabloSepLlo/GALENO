<?php
    session_start();
    if (isset($_POST["motivo_inc"], $_POST["co_morb"], $_POST["num_farm"], $_POST["grado_ulcera"], $_POST["dolor"],
        $_POST["rip_domi"], $_POST["upp"], $_POST["in_ur"], $_POST["disf"], $_POST["in_fec"], $_POST["sv"],
        $_POST["insom"], $_POST["sng"], $_POST["sob_cui"], $_POST["ocd"])) {
            $_SESSION["motivo_inc"] = !empty($_POST["motivo_inc"]) ? $_POST["motivo_inc"] : null;
            $_SESSION["co_morb"] = !empty($_POST["co_morb"]) ? $_POST["co_morb"] : null;
            $_SESSION["num_farm"] = !empty($_POST["num_farm"]) ? $_POST["num_farm"] : null;
            $_SESSION["grado_ulcera"] = !empty($_POST["grado_ulcera"]) || $_POST["grado_ulcera"] == 0 ? $_POST["grado_ulcera"] : null;
            $_SESSION["dolor"] = !empty($_POST["dolor"]) ? $_POST["dolor"] : null;
            $_SESSION["rip_domi"] = !empty($_POST["rip_domi"]) ? $_POST["rip_domi"] : null;
            $_SESSION["upp"] = !empty($_POST["upp"]) ? $_POST["upp"] : null;
            $_SESSION["in_ur"] = !empty($_POST["in_ur"]) ? $_POST["in_ur"] : null;
            $_SESSION["disf"] = !empty($_POST["disf"]) ? $_POST["disf"] : null;
            $_SESSION["in_fec"] = !empty($_POST["in_fec"]) ? $_POST["in_fec"] : null;
            $_SESSION["sv"] = !empty($_POST["sv"]) ? $_POST["sv"] : null;
            $_SESSION["insom"] = !empty($_POST["insom"]) ? $_POST["insom"] : null;
            $_SESSION["sng"] = !empty($_POST["sng"]) ? $_POST["sng"] : null;
            $_SESSION["sob_cui"] = !empty($_POST["sob_cui"]) ? $_POST["sob_cui"] : null;
            $_SESSION["ocd"] = !empty($_POST["ocd"]) ? $_POST["ocd"] : null;
            header("Location: ../vista/aniadir_paciente_datos_generales.php");
            exit();
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ../vista/aniadir_paciente_diagnosticos.php");
        exit();
    }
?>
