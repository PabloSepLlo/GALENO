<?php
    session_start();
    if (isset($_POST["fecha_ingreso"], $_POST["fecha_alta"], $_POST["reingreso"], $_POST["NUM_VISIT"], $_POST["procedencia"], $_POST["destino"]) 
            && !empty($_POST["fecha_ingreso"])) {
            $_SESSION["fecha_ingreso"] = $_POST["fecha_ingreso"];
            $_SESSION["fecha_alta"] = !empty($_POST["fecha_alta"]) ? $_POST["fecha_alta"] : null;
            $_SESSION["reingreso"] = !empty($_POST["reingreso"]) ? $_POST["reingreso"] : null;
            $_SESSION["NUM_VISIT"] = !empty($_POST["NUM_VISIT"]) ? $_POST["NUM_VISIT"] : null;
            $_SESSION["procedencia"] = !empty($_POST["procedencia"]) ? $_POST["procedencia"] : null;
            $_SESSION["destino"] = !empty($_POST["destino"]) ? $_POST["destino"] : null;
            header("Location: ../vista/aniadir_ingreso_diagnosticos.php");
            exit();
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ../vista/aniadir_ingreso_generales.php");
        exit();
    }
?>