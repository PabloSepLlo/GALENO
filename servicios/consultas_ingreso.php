<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_ingreso {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_n_ingreso($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) AS n_ingreso 
                FROM ingreso
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_datos_ingresos($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN i.reingreso = 'SÍ' THEN 1 ELSE 0 END) * 100 / NULLIF(COUNT(i.reingreso), 0), 2) AS reingreso,
                    SUM(i.analitica) AS analiticas,
                    SUM(i.eco) AS eco,
                    SUM(i.minimental) AS minimental,
                    SUM(i.cultivo) AS cultivo,
                    SUM(i.num_visit) AS num_visit
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_crm($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN i.crm = 0 OR i.crm = 1 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crm_0_1,
                    ROUND(SUM(CASE WHEN i.crm = 2 OR i.crm = 3 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crm_2_3,
                    ROUND(SUM(CASE WHEN i.crm = 4 OR i.crm = 5 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crm_4_5
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_crf($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN i.crf = 0 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crf_0,
                    ROUND(SUM(CASE WHEN i.crf = 1 OR i.crf = 2 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crf_1_2,
                    ROUND(SUM(CASE WHEN i.crf = 3 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crf_3,
                    ROUND(SUM(CASE WHEN i.crf = 4 OR i.crf = 5 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS crf_4_5
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_barthel($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN i.barthel < 45 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS barthel_menos_45,
                    ROUND(SUM(CASE WHEN i.barthel >= 1 AND i.barthel <= 59 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS barthel_45_59,
                    ROUND(SUM(CASE WHEN i.barthel >= 60 AND i.barthel <= 80 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS barthel_60_80,
                    ROUND(SUM(CASE WHEN i.barthel > 80 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS barthel_mas_80
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_datos_pfeiffer($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN i.pfeiffer <= 4 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.pfeiffer IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS pfeiffer_menor_4,
                    ROUND(SUM(CASE WHEN i.pfeiffer > 4 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.pfeiffer IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS pfeiffer_mas_4
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function get_ingreso_pr($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    pr.descripcion AS procedencia,
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
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                    ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                JOIN procedencia AS pr ON i.id_procedencia = pr.id_procedencia
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY pr.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_ingreso_migr($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    mi.descripcion AS motivo_ingreso,
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
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                    ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                JOIN motivo_ingreso AS mi ON i.id_motivo_ingreso = mi.id_motivo_ingreso
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY mi.motivo_ingreso;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_ingreso_de($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    de.descripcion AS destino,
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
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                    ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                JOIN destino AS de ON i.id_destino = de.id_destino
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY de.motivo_ingreso;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_porcentaje_muerte_domicilio($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(COUNT(CASE WHEN i.rip_domi = 'SÍ' THEN 1 ELSE NULL END) * 100.0 / (
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
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos 
                    ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                JOIN destino AS de ON i.id_destino = de.id_destino
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                AND i.id_destino = 8;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_media_dias_ingreso($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    AVG(DATEDIFF(fecha_alta, fecha_ingreso)) as get_media_dias_ingreso
                FROM ingreso
                WHERE fecha_ingreso <= :fin
                AND (fecha_alta >= :inicio)
                AND fecha_alta IS NOT NULL;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>