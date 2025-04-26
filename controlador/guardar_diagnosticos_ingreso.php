<?php
    session_start();
    if (isset($_POST["crf"], $_POST["crm"], $_POST["eco"], $_POST["cultivo"], $_POST["barthel"], $_POST["pfeiffer"],
    $_POST["analitica"], $_POST["minimental"], $_POST["motivo_ingreso"])){
        $_SESSION["crf"] = !empty($_POST["crf"]) ? $_POST["crf"] : null;
        $_SESSION["crm"] = !empty($_POST["crm"]) ? $_POST["crm"] : null;
        $_SESSION["eco"] = !empty($_POST["eco"]) ? $_POST["eco"] : null;
        $_SESSION["cultivo"] = !empty($_POST["cultivo"]) ? $_POST["cultivo"] : null;
        $_SESSION["barthel"] = !empty($_POST["barthel"]) ? $_POST["barthel"] : null;
        $_SESSION["pfeiffer"] = !empty($_POST["pfeiffer"]) ? $_POST["pfeiffer"] : null;
        $_SESSION["analitica"] = !empty($_POST["analitica"]) ? $_POST["analitica"] : null;
        $_SESSION["minimental"] = !empty($_POST["minimental"]) ? $_POST["minimental"] : null;
        $_SESSION["motivo_ingreso"] = !empty($_POST["motivo_ingreso"]) ? $_POST["motivo_ingreso"] : null;
        $_SESSION["lista_tratamientos"] = !empty($_POST["tratamientos"]) ? $_POST["tratamientos"] : null;
        header("Location: ../vista/vista_resumen_ingreso.php");
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ../vista/aniadir_ingreso_diagnosticos.php");
    }
    exit();
?>