<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_paciente {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_datos_paciente() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) AS n_pacientes, 
                    AVG(edad) AS edad_media,
                    ROUND(SUM(CASE WHEN sexo = 'F' THEN 1 ELSE 0 END) * 100 / n_pacientes, 2) AS mujeres,
                    ROUND(SUM(CASE WHEN sexo = 'M' THEN 1 ELSE 0 END) * 100 / n_pacientes, 2) AS hombres
                    ROUND(SUM(CASE WHEN incontinencia_urinaria = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(incontinencia_urinaria), 0), 2) AS iu,
                    ROUND(SUM(CASE WHEN incontinencia_fecal = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(incontinencia_fecal), 0), 2) AS if,
                    ROUND(SUM(CASE WHEN insomnio = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(insomnio), 0), 2) AS insomnio,
                    ROUND(SUM(CASE WHEN dolor = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dolor), 0), 2) AS dolor,
                    ROUND(SUM(CASE WHEN disfagia = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(disfagia), 0), 2) AS disfagia,
                    ROUND(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(*), 0), 2) AS ulcera_total,
                    ROUND(SUM(CASE WHEN grado_ulcera = 1 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_1,
                    ROUND(SUM(CASE WHEN grado_ulcera = 2 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_2,
                    ROUND(SUM(CASE WHEN grado_ulcera = 3 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_3,
                    ROUND(SUM(CASE WHEN grado_ulcera = 4 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_4
                FROM datos_paciente
                WHERE fecha_ingreso BETWEEN :inicio AND :fin
                ");
        }
        public function get_paciente_cs() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    cs.descripcion AS centro_salud,
                    COUNT(*) AS num_pacientes
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN centro_salud AS cs ON dp.id_centro_salud = cs.id_centro_salud
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY cs.descripcion;
            ");
        }
        public function get_paciente_c() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    c.descripcion AS convivencia,
                    COUNT(*) AS num_pacientes
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN convivencia AS c ON dp.id_convivencia = c.id_convivencia
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY c.descripcion;
            ");
        }
        public function get_paciente_pc() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    pc.descripcion AS ppal_cuidador,
                    COUNT(*) AS num_pacientes
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN ppal_cuidador AS pc ON dp.id_ppal_cuidador = pc.id_ppal_cuidador
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY pc.descripcion;
            ");
        }
        public function get_paciente_as() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    as.descripcion AS ayuda_social,
                    COUNT(*) AS num_pacientes
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN ayuda_social AS as ON dp.id_centro_salud = as.id_ayuda_social
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY as.descripcion;
            ");
        }
        public function get_paciente_mi() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    mi.descripcion AS motivo_inc,
                    COUNT(*) AS num_pacientes
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN motivo_inc AS mi ON dp.id_motivo_inc = mi.id_motivo_inc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY mi.descripcion;
            ");
        }
    }
?>