    <h1>INFORME DE ASISTENCIA GERIÁTRICA DOMICILIARIA</h1>
    <h4>Periodo: <?php echo $_SESSION['fecha_inicio'] ?? "-" ?> a <?php echo $_SESSION['fecha_fin'] ?? "-" ?></h4>

    <div class="seccion">
        <h2>Datos Generales</h2>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">N.º Pacientes:</span> <?php echo $_SESSION['inf_datos_paciente']['n_pacientes'] ?? "-"; ?></td>
                <td><span class="dato-label">Edad media:</span> <?php echo $_SESSION['inf_datos_paciente']['edad_media'] ?? "-" ?></td>
                <td><span class="dato-label">Mujeres:</span> <?php echo $_SESSION['inf_datos_paciente']['mujeres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Hombres:</span> <?php echo $_SESSION['inf_datos_paciente']['hombres'] ?? "-" ?>%</td>
                <td><span class="dato-label">Ingresos:</span> <?php echo $_SESSION['inf_num_ingresos'] ?? "-" ?></td>
            </tr>
        </table>
    </div>

    <div class="seccion">
        <h2>Datos de Procedencia</h2>

        <p><span class="dato-label">Reingresos:</span> <?php  echo $_SESSION['inf_datos_ingresos']['reingreso'] ?? "-" ?>%</p>

        <h4>Procedencias</h4>
        <table class="info-table">
            <tr><th>Procedencia</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['inf_procedencia'] as $pr) {
                    echo "<tr>
                        <td>{$pr['descripcion']}</td>
                        <td>{$pr['porcentaje']}%</td>
                    </tr>";
                }
            ?>
        </table>

        <h4>Centros de Salud</h4>
        <table class="info-table">
            <tr><th>Centro</th><th>% Pacientes</th></tr>
            <?php 
                foreach ($_SESSION['inf_centro_salud'] as $cs) {
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
                foreach ($_SESSION['inf_motivo_ingreso'] as $migr) {
                    echo "<tr>
                        <td>{$migr['descripcion']}</td>
                        <td>{$migr['porcentaje']}%</td>
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
                foreach ($_SESSION['inf_motivo_inc'] as $mi) {
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
            <li>Incontinencia urinaria: <?php echo $_SESSION['inf_datos_paciente']['in_ur'] ?? "-" ?>%</li>
            <li>Incontinencia fecal: <?php echo $_SESSION['inf_datos_paciente']['in_fec'] ?? "-" ?>%</li>
            <li>Insomnio: <?php echo $_SESSION['inf_datos_paciente']['insom'] ?? "-" ?>%</li>
            <li>Dolor: <?php echo $_SESSION['inf_datos_paciente']['dolor'] ?? "-" ?>%</li>
            <li>Disfagia: <?php echo $_SESSION['inf_datos_paciente']['disfagia'] ?? "-" ?></li>
            <li>Úlcera: <?php echo $_SESSION['inf_datos_paciente']['ulcera_total'] ?? "-" ?>%</li>
            <table class="info-table">
                <tr><th>Grado</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['inf_grados_ulcera'] as $grado => $porcentaje) {
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
                foreach ($_SESSION['inf_crf'] ?? [] as $rango => $porcentaje) {
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
                foreach ($_SESSION['inf_crm'] ?? [] as $rango => $porcentaje) {
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
                foreach ($_SESSION['inf_barthel'] ?? [] as $rango => $porcentaje) {
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
                foreach ($_SESSION['inf_pfeiffer'] ?? [] as $rango => $porcentaje) {
                    echo "<tr>
                        <td>$rango</td>
                        <td>$porcentaje%</td>
                    </tr>";
                }
            ?>
        </table>
        <h3>Social</h3>
        <table class="info-table">
            <tr><th>Cuidador principal</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['inf_ppal_cuidador'] as $pc) {
                        echo "<tr>
                            <td>{$pc['descripcion']}</td>
                            <td>{$pc['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
            </tr>
        </table>
        <table class="info-table">
            <tr><th>Convivencia</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['inf_convivencia'] as $c) {
                        echo "<tr>
                            <td>{$c['descripcion']}</td>
                            <td>{$c['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
            </tr>
        </table>
        <table class="info-table">
            <tr><th>Ayuda social</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['inf_ayuda_social'] as $ays) {
                        echo "<tr>
                            <td>{$ays['descripcion']}</td>
                            <td>{$ays['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
            </tr>
        </table>
    </div>

    <div class="seccion">
        
        <h2>Pruebas Diagnósticas</h2>
        <ul>
            <li>Analíticas: <?php echo $_SESSION['inf_datos_ingresos']['analiticas'] ?? "-" ?></li>
            <li>Ecografía: <?php echo $_SESSION['inf_datos_ingresos']['eco'] ?? "-" ?></li>
            <li>Cultivos: <?php echo $_SESSION['inf_datos_ingresos']['cultivo'] ?? "-" ?></li>
            <li>Minimental: <?php echo $_SESSION['inf_datos_ingresos']['minimental'] ?? "-" ?></li>
        </ul>
    </div>

    <div class="seccion">
        <h2>Datos de Alta</h2>
        <h4>Destino</h4>
        <table class="info-table">
            <tr><th>Destino</th><th>% Pacientes</th></tr>
                <?php 
                    foreach ($_SESSION['inf_destino'] as $de) {
                        echo "<tr>
                            <td>{$de['descripcion']}</td>
                            <td>{$de['porcentaje']}%</td>
                        </tr>";
                    }
                ?>
        </table>
        <table class="info-table">
            <tr>
                <td><span class="dato-label">Media días ingreso:</span> <?php echo $_SESSION['inf_avg_ingreso']['get_media_dias_ingreso'] ?? "-" ?></td>
                <td><span class="dato-label">N.º visitas:</span> <?php echo $_SESSION['inf_datos_ingresos']['num_visit'] ?? "-" ?></td>
                <td><span class="dato-label">% RIP domicilio:</span> <?php echo $_SESSION["inf_rip_domi"]['porcentaje'] ?? "-" ?></td>
            </tr>
        </table>
    </div>

    <footer>
        Informe generado automáticamente. Servicio de Geriatría Domiciliaria.
    </footer>
