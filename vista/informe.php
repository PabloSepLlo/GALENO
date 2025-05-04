<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11.5px;
            margin: 30px;
            color: #222;
        }
        h1, h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 10px;
        }
        h4 {
            text-align: center;
            font-weight: normal;
            margin-top: 0;
            margin-bottom: 30px;
        }
        .seccion {
            margin-top: 25px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .dato-label {
            font-weight: bold;
        }
        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.info-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        ul {
            margin: 0;
            padding-left: 20px;
        }
        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    <h1>INFORME DE ASISTENCIA GERIÁTRICA DOMICILIARIA</h1>
    <h4>Periodo: <?= $_SESSION['fecha_inicio'] ?? "-" ?> a <?= $_SESSION['fecha_fin'] ?? "-" ?></h4>

    <div class="seccion">
        <h2>Datos Generales</h2>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">N.º Pacientes:</span> <?= $_SESSION['num_pacientes'] ?? "-" ?></td>
                <td><span class="dato-label">Edad media:</span> <?= $_SESSION['edad_media'] ?? "-" ?></td>
                <td><span class="dato-label">Mujeres:</span> <?= $_SESSION['mujeres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Hombres:</span> <?= $_SESSION['hombres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Ingresos:</span> <?= $_SESSION['num_ingresos'] ?? "-" ?></td>
            </tr>
        </table>
    </div>

    <div class="seccion">
        <h2>Datos de Procedencia</h2>

        <p><span class="dato-label">Reingresos:</span> <?= $_SESSION['reingresos'] ?? "-" ?>%</p>

        <h4>Procedencias</h4>
        <table class="info-table">
            <tr><th>Procedencia</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['procedencia'] ?? [] as $descripcion => $porcentaje) {
                    echo"
                        <tr>
                            <td>$descripcion</td>
                            <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>

        <h4>Centros de Salud</h4>
        <table class="info-table">
            <tr><th>Centro</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['centro_salud'] ?? [] as $codigo_centro => $porcentaje) {
                    echo "<tr>
                        <td>$codigo_centro</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>

        <h4>Motivos de Ingreso</h4>
        <table class="info-table">
            <tr><th>Motivo</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['motivo_ingreso'] ?? [] as $descripcion => $porcentaje) {
                    echo "<tr>
                        <td>$descripcion</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
    </div>

    <div class="seccion">
        <h2>Motivo de Incapacidad</h2>
        <table class="info-table">
            <tr><th>Motivo</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['motivo_inc'] ?? [] as $descripcion => $porcentaje) {
                    echo "<tr>
                        <td>$descripcion</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
    </div>

    <div class="seccion">
        <h2>Síndromes Geriátricos</h2>
        <ul>
            <li>Incontinencia urinaria: <?= $_SESSION['in_ur'] ?? "-" ?>%</li>
            <li>Incontinencia fecal: <?= $_SESSION['in_fec'] ?? "-" ?>%</li>
            <li>Insomnio: <?= $_SESSION['insom'] ?? "-" ?>%</li>
            <li>Dolor: <?= $_SESSION['dolor'] ?? "-" ?>%</li>
            <li>Disfagia: <?= $_SESSION['disfagia'] ?? "-" ?></li>
            <li>Úlcera: <?= $_SESSION['ulcera_total'] ?? "-" ?>%</li>
            <table class="info-table">
                <tr><th>Grado</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['grado_ulcera'] ?? [] as $grado => $porcentaje) {
                        echo "<tr>
                            <td>$grado</td>
                            <td>$porcentaje%</td>
                        </tr>";
                    }
                ?>
            </table>
        </ul>
    </div>

    <div class="seccion">
        <h2>Valoración Geriátrica</h2>
        <h4>CRF</h4>
        <table class="info-table">
            <tr><th>Rangos</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['crf'] ?? [] as $rango => $porcentaje) {
                    echo "<tr>
                        <td>$rango</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
        <h4>CRM</h4>
        <table class="info-table">
            <tr><th>Rangos</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['crm'] ?? [] as $rango => $porcentaje) {
                    echo "<tr>
                        <td>$rango</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
        <h4>Barthel</h4>
        <table class="info-table">
            <tr><th>Rangos</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['barthel'] ?? [] as $rango => $porcentaje) {
                    echo "<tr>
                        <td>$rango</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
        <h4>Pfeiffer</h4>
        <table class="info-table">
            <tr><th>Rangos</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['pfeiffer'] ?? [] as $rango => $porcentaje) {
                    echo "<tr>
                        <td>$rango</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
        <h3>Social</h3>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Cuidador principal:
                <?php 
                    foreach ($_SESSION['ppal_cuidador'] ?? [] as $descripcion => $porcentaje) {
                        echo "
                            <td>$descripcion></td>
                            <td>$porcentaje%</td>";
                    }
                ?>
                </td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Convivencia:
                <?php 
                    foreach ($_SESSION['convivencia'] ?? [] as $descripcion => $porcentaje) {
                        echo "
                            <td>$descripcion</td>
                            <td>$porcentaje%</td>";
                    }
                ?>
                </td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Ayuda social:
                <?php 
                    foreach ($_SESSION['ayuda_social'] ?? [] as $descripcion => $porcentaje) {
                        echo "
                            <td>$descripcion</td>
                            <td><$porcentaje%</td>";
                    }
                ?>
                </td>
            </tr>
        </table>
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
        <h4>Destino</h4>
        <table class="info-table">
            <tr><th>Destino</th><th>% Pacientes</th></tr>
            
                <?php 
                    foreach ($_SESSION['destino'] ?? [] as $descripcion => $porcentaje) {
                        echo "<tr>
                            <td>$descripcion</td>
                            <td><$porcentaje%</td>
                            </tr>";
                    }
                ?>
            
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Media días ingreso:</span> <?= $_SESSION['media_dias'] ?? "-" ?></td>
                <td><span class="dato-label">N.º visitas:</span> <?= $_SESSION['num_visitas'] ?? "-" ?></td>
                <td><span class="dato-label">% RIP domicilio:</span> <?= $_SESSION['rip_domi'] ?? "-" ?></td>
            </tr>
        </table>
    </div>

    <footer>
        Informe generado automáticamente. Servicio de Geriatría Domiciliaria.
    </footer>

</body>
</html>
