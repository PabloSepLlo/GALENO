<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_paciente {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_datos_paciente($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) AS n_pacientes, 
                    AVG(dp.edad) AS edad_media,
                    ROUND(SUM(CASE WHEN dp.sexo = 'F' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS mujeres,
                    ROUND(SUM(CASE WHEN dp.sexo = 'M' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS hombres,
                    ROUND(SUM(CASE WHEN dp.in_ur = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dp.in_ur), 0), 2) AS iu,
                    ROUND(SUM(CASE WHEN dp.in_fec = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dp.in_fec), 0), 2) AS ifec,
                    ROUND(SUM(CASE WHEN dp.insom = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dp.insom), 0), 2) AS insomnio,
                    ROUND(SUM(CASE WHEN dp.dolor = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dp.dolor), 0), 2) AS dolor,
                    ROUND(SUM(CASE WHEN dp.disf = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dp.disf), 0), 2) AS disfagia,
                    ROUND(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(*), 0), 2) AS ulcera_total
                FROM datos_paciente dp
                JOIN ingreso i ON dp.nhc = i.nhc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_grados_ulcera($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) AS n_pacientes, 
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = 1 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_1,
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = 2 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_2,
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = 3 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_3,
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = 4 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_4
                FROM datos_paciente dp
                JOIN ingreso i ON dp.nhc = i.nhc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_cs($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    cs.codigo_centro AS centro_salud,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*)
                        FROM ingreso AS i2
                        JOIN (
                            SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                            FROM ingreso
                            GROUP BY nhc
                        ) AS ultimos2 
                        ON i2.nhc = ultimos2.nhc AND i2.fecha_ingreso = ultimos2.fecha_max
                        WHERE i2.fecha_ingreso <= '2025-12-31'
                        AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= '2024-12-31')
                    ), 2) AS porcentaje
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN centro_salud AS cs ON dp.id_centro_salud = cs.id_centro_salud
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY cs.codigo_centro;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_c($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    c.descripcion AS convivencia,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*)
                        FROM ingreso AS i2
                        JOIN (
                            SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                            FROM ingreso
                            GROUP BY nhc
                        ) AS ultimos2 
                        ON i2.nhc = ultimos2.nhc AND i2.fecha_ingreso = ultimos2.fecha_max
                        WHERE i2.fecha_ingreso <= :fin
                        AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                    ), 2) AS porcentaje
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN convivencia AS c ON dp.id_convivencia = c.id_convivencia
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY c.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_pc($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    pc.descripcion AS ppal_cuidador,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*)
                        FROM ingreso AS i2
                        JOIN (
                            SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                            FROM ingreso
                            GROUP BY nhc
                        ) AS ultimos2 
                        ON i2.nhc = ultimos2.nhc AND i2.fecha_ingreso = ultimos2.fecha_max
                        WHERE i2.fecha_ingreso <= :fin
                        AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                    ), 2) AS porcentaje
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN ppal_cuidador AS pc ON dp.id_ppal_cuidador = pc.id_ppal_cuidador
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY pc.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_as($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    as.descripcion AS ayuda_social,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*)
                        FROM ingreso AS i2
                        JOIN (
                            SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                            FROM ingreso
                            GROUP BY nhc
                        ) AS ultimos2 
                        ON i2.nhc = ultimos2.nhc AND i2.fecha_ingreso = ultimos2.fecha_max
                        WHERE i2.fecha_ingreso <= :fin
                        AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                    ), 2) AS porcentaje
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN ayuda_social AS as ON dp.id_centro_salud = as.id_ayuda_social
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY as.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_mi($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    mi.descripcion AS motivo_inc,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*)
                        FROM ingreso AS i2
                        JOIN (
                            SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                            FROM ingreso
                            GROUP BY nhc
                        ) AS ultimos2 
                        ON i2.nhc = ultimos2.nhc AND i2.fecha_ingreso = ultimos2.fecha_max
                        WHERE i2.fecha_ingreso <= :fin
                        AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                    ), 2) AS porcentaje
                FROM datos_paciente AS dp
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN motivo_inc AS mi ON dp.id_motivo_inc = mi.id_motivo_inc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY mi.descripcion;
            ");
        }
        public function datos_paciente_por_cs($id_centro_salud) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    dp.nhc, 
                    dp.nombre, 
                    dp.ape1, 
                    dp.ape2, 
                    dp.edad, 
                    dp.medico,
                    mi.descripcion AS motivo_inc, 
                    migr.descripcion AS motivo_ingreso,
                    cs.codigo_centro as codigo_centro
                FROM datos_paciente AS dp
                JOIN centro_salud AS cs ON dp.id_centro_salud = cs.id_centro_salud
                LEFT JOIN motivo_inc AS mi ON dp.id_motivo_inc = mi.id_motivo_inc
                JOIN ingreso AS i ON i.nhc = dp.nhc
                LEFT JOIN motivo_ingreso AS migr ON i.id_motivo_ingreso = migr.id_motivo_ingreso
                WHERE i.fecha_alta IS NULL 
                AND dp.id_centro_salud = :id_centro_salud;
            ");
            $stmt->bindParam(":id_centro_salud", $id_centro_salud);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>