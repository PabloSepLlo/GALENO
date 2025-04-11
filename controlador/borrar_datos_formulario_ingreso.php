<?php
session_start();
unset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"], $_SESSION["fecha_ingreso"], $_SESSION["fecha_alta"] ,
$_SESSION["reingreso"], $_SESSION["NUM_VISIT"], $_SESSION["procedencia"], $_SESSION["destino"], $_SESSION["crf"], $_SESSION["crm"], $_SESSION["eco"],
$_SESSION["cultivo"], $_SESSION["barthel"], $_SESSION["pfeiffer"], $_SESSION["analitica"], $_SESSION["minimental"], $_SESSION["motivo_ingreso"], 
$_SESSION["tratamientos"], $_SESSION["ingresando"]);
header("Location: ../vista/menu.php");
exit();
?>