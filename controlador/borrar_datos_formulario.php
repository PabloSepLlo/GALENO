<?php
    session_start();

    $id_usuario = $_SESSION["id_usuario"];
    $msg = $_SESSION["msg"] ?? null;
    $err = $_SESSION["err"] ?? null;

    session_destroy();

    session_start();
    $_SESSION["id_usuario"] = $id_usuario;
    if ($msg != null) $_SESSION["msg"] = $msg;
    if ($err != null) $_SESSION["err"] = $err;

    header("Location: ../vista/menu.php");
    exit();
?>