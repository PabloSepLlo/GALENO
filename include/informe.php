    <h1>INFORME DE ASISTENCIA GERIÁTRICA DOMICILIARIA</h1>
    <h4>Periodo: <?php echo $_SESSION['fecha_inicio'] ?? "-" ?> a <?php echo $_SESSION['fecha_fin'] ?? "-" ?></h4>

    <div class="seccion">
        <h2>Datos Generales</h2>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">N.º Pacientes:</span> <?php echo $_SESSION['datos_paciente']['n_pacientes'] ?? "-"; ?></td>
                <td><span class="dato-label">Edad media:</span> <?php echo $_SESSION['datos_paciente']['edad_media'] ?? "-" ?></td>
                <td><span class="dato-label">Mujeres:</span> <?php echo $_SESSION['datos_paciente']['mujeres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Hombres:</span> <?php echo $_SESSION['datos_paciente']['hombres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Ingresos:</span> <?php echo $_SESSION['num_ingresos'] ?? "-" ?></td>
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
                foreach ($_SESSION['centro_salud'] as $cs) {
                    echo "<tr>
                        <td>{$cs['codigo_centro']}</td>
                        <td>{$cs['porcentaje']}%</td>
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
                foreach ($_SESSION['motivo_inc'] as $mi) {
                    echo "<tr>
                        <td>{$mi['descripcion']}</td>
                        <td>{$mi['porcentaje']}%</td>
                    </tr>";
                }
            ?>
        </table>
    </div>

    <div class="seccion">
        <h2>Síndromes Geriátricos</h2>
        <ul>
            <li>Incontinencia urinaria: <?php echo $_SESSION['datos_paciente']['in_ur'] ?? "-" ?>%</li>
            <li>Incontinencia fecal: <?php echo $_SESSION['datos_paciente']['in_fec'] ?? "-" ?>%</li>
            <li>Insomnio: <?php echo $_SESSION['datos_paciente']['insom'] ?? "-" ?>%</li>
            <li>Dolor: <?php echo $_SESSION['datos_paciente']['dolor'] ?? "-" ?>%</li>
            <li>Disfagia: <?php echo $_SESSION['datos_paciente']['disfagia'] ?? "-" ?></li>
            <li>Úlcera: <?php echo $_SESSION['datos_paciente']['ulcera_total'] ?? "-" ?>%</li>
            <table class="info-table">
                <tr><th>Grado</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['grados_ulcera'] as $grado => $porcentaje) {
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
                    foreach ($_SESSION['ppal_cuidador'] as $pc) {
                        echo "
                            <td>{$pc['descripcion']}</td>
                            <td>{$pc['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
                </td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Convivencia:
                <?php 
                    foreach ($_SESSION['convivencia'] as $c) {
                        echo "
                            <td>{$c['descripcion']}</td>
                            <td>{$c['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
                </td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Ayuda social:
                <?php 
                    foreach ($_SESSION['ayuda_social'] as $ays) {
                        echo "
                            <td>{$ays['descripcion']}</td>
                            <td>{$ays['porcentaje']}%</td>";
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
