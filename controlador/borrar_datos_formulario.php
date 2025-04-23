<?php
session_start();
$id_usuario = $_SESSION["id_usuario"];
session_destroy();
session_start();
$_SESSION["id_usuario"] = $id_usuario;
header("Location: ../vista/menu.php");
exit();
?>