<?php
    session_start();
    if (isset($_POST["ayuda_social"], $_POST["convivencia"], $_POST["ppal_cuidador"])) {
            $_SESSION["ayuda_social"] = !empty($_POST["ayuda_social"]) ? $_POST["ayuda_social"] : null;
            $_SESSION["convivencia"] = !empty($_POST["convivencia"]) ? $_POST["convivencia"] : null;
            $_SESSION["ppal_cuidador"] = !empty($_POST["ppal_cuidador"]) ? $_POST["ppal_cuidador"] : null;
            header("Location: ../vista/vista_resumen_paciente.php");
            exit();
    }
    else {
        $_SESSION["err"] = "Alguno de los campos está incompleto";
        header("Location: ../vista/aniadir_paciente_datos_generales.php");
        exit();
    }
?>