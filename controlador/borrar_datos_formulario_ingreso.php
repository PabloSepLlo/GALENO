<?php
session_start();
//hacer un session destroy guardando los datos del usuario y reponerlos con un session start
unset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"], $_SESSION["fecha_ingreso"], $_SESSION["fecha_alta"] ,
$_SESSION["reingreso"], $_SESSION["NUM_VISIT"], $_SESSION["procedencia"], $_SESSION["destino"], $_SESSION["crf"], $_SESSION["crm"], $_SESSION["eco"],
$_SESSION["cultivo"], $_SESSION["barthel"], $_SESSION["pfeiffer"], $_SESSION["analitica"], $_SESSION["minimental"], $_SESSION["motivo_ingreso"], 
$_SESSION["tratamientos"], $_SESSION["ingresando"], $_SESSION["nhc"], $_SESSION["nombre"], $_SESSION["ape1"], $_SESSION["ape2"], $_SESSION["sexo"], $_SESSION["edad"], 
$_SESSION["centro_salud"], $_SESSION["med"], $_SESSION["enf"], $_SESSION["motivo_inc"], $_SESSION["co_morb"], 
$_SESSION["num_farm"], $_SESSION["grado_ulcera"], $_SESSION["dolor"], $_SESSION["rip_domi"], $_SESSION["upp"], $_SESSION["in_ur"], 
$_SESSION["disf"], $_SESSION["in_fec"], $_SESSION["sv"], $_SESSION["insom"], $_SESSION["sng"], $_SESSION["sob_cui"], $_SESSION["ocd"],
$_SESSION["ayuda_social"], $_SESSION["convivencia"], $_SESSION["ppal_cuidador"]);
header("Location: ../vista/menu.php");
exit();
?>