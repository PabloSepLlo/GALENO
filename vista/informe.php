<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 40px;
            line-height: 1.5;
        }
        h1, h2, h4 {
            text-align: center;
        }
        .seccion {
            margin-top: 20px;
        }
        .bloque {
            margin: 10px 0;
        }
        .dato-label {
            font-weight: bold;
        }
        ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <h1>INFORME DE ASISTENCIA GERIÁTRICA DOMICILIARIA</h1>
    <h4>Periodo: <?= $_SESSION['fecha_inicio'] ?? "-" ?> a <?= $_SESSION['fecha_fin'] ?? "-" ?></h4>

    <div class="seccion">
        <p>
            <span class="dato-label">N.º pacientes:</span> <?= $_SESSION['num_pacientes'] ?? "-" ?> |
            <span class="dato-label">Edad media:</span> <?= $_SESSION['edad_media'] ?? "-" ?> |
            <span class="dato-label">Mujeres:</span> <?= $_SESSION['mujeres'] ?? "-" ?> |
            <span class="dato-label">Hombres:</span> <?= $_SESSION['hombres'] ?? "-" ?> |
            <span class="dato-label">Ingresos:</span> <?= $_SESSION['num_ingresos'] ?? "-" ?>
        </p>
    </div>

    <div class="seccion">
        <h2>Datos de Procedencia</h2>
        <p class="bloque"><span class="dato-label">Reingresos:</span> <?= $_SESSION['reingresos'] ?? "-" ?></p>
        <p class="bloque"><span class="dato-label">Procedencias:</span> <?= $_SESSION['procedencias'] ?? "-" ?></p>
        <p class="bloque"><span class="dato-label">Centro de salud:</span> <?= $_SESSION['centro_salud'] ?? "-" ?></p>
        <p class="bloque"><span class="dato-label">Motivo de ingreso:</span> <?= $_SESSION['motivo_ingreso'] ?? "-" ?></p>
    </div>

    <div class="seccion">
        <h2>Motivo de Incapacidad</h2>
        <p><?= $_SESSION['motivo_incapacidad'] ?? "-" ?></p>
    </div>

    <div class="seccion">
        <h2>Síndromes Geriátricos</h2>
        <ul>
            <li>Incontinencia urinaria: <?= $_SESSION['iu'] ?? "-" ?></li>
            <li>Incontinencia fecal: <?= $_SESSION['if'] ?? "-" ?></li>
            <li>Insomnio: <?= $_SESSION['insomnio'] ?? "-" ?></li>
            <li>Dolor: <?= $_SESSION['dolor'] ?? "-" ?></li>
            <li>Úlcera (grado): <?= $_SESSION['ulcera'] ?? "-" ?> (<?= $_SESSION['grado_ulcera'] ?? "-" ?>)</li>
            <li>Disfagia: <?= $_SESSION['disfagia'] ?? "-" ?></li>
        </ul>
    </div>

    <div class="seccion">
        <h2>Valoración Geriátrica</h2>
        <p class="bloque">
            CRF: <?= $_SESSION['crf'] ?? "-" ?> |
            CRM: <?= $_SESSION['crm'] ?? "-" ?> |
            Barthel: <?= $_SESSION['barthel'] ?? "-" ?> |
            Pfeiffer: <?= $_SESSION['pfeiffer'] ?? "-" ?>
        </p>
        <p class="bloque">
            Cuidador principal: <?= $_SESSION['cuidador'] ?? "-" ?> |
            Convivencia: <?= $_SESSION['convivencia'] ?? "-" ?> |
            Ayuda social: <?= $_SESSION['ayuda_social'] ?? "-" ?>
        </p>
    </div>

    <div class="seccion">
        <h2>Pruebas Diagnósticas</h2>
        <ul>
            <li>Analíticas: <?= $_SESSION['analiticas'] ?? "-" ?></li>
            <li>Ecografía: <?= $_SESSION['eco'] ?? "-" ?></li>
            <li>Cultivos: <?= $_SESSION['cultivo'] ?? "-" ?></li>
            <li>Minimental: <?= $_SESSION['minimental'] ?? "-" ?></li>
        </ul>
    </div>

    <div class="seccion">
        <h2>Datos de Alta</h2>
        <p class="bloque">
            Media días ingreso: <?= $_SESSION['media_dias'] ?? "-" ?> |
            Nº visitas: <?= $_SESSION['num_visitas'] ?? "-" ?> |
            Destinos: <?= $_SESSION['destinos'] ?? "-" ?> |
            % RIP domicilio: <?= $_SESSION['rip_domi'] ?? "-" ?>
        </p>
    </div>
</body>

</html>
