<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_ingreso {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_n_ingreso($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) AS total_ingresos 
                FROM ingreso
                WHERE (
                    (fecha_ingreso BETWEEN :inicio AND :fin)
                )
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_COLUMN);
        }

        public function get_datos_ingresos($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH ultimos_ingresos AS (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                )
                SELECT 
                    ROUND(SUM(CASE WHEN i.reingreso = 'SÍ' THEN 1 ELSE 0 END) * 100 / 
                        NULLIF(SUM(CASE WHEN i.reingreso IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS reingreso,
                    SUM(i.analitica) AS analiticas,
                    SUM(CASE WHEN i.eco = 'SÍ' THEN 1 ELSE 0 END) AS eco,
                    ROUND(AVG(i.minimental), 2) AS minimental,
                    SUM(i.cultivo) AS cultivo,
                    SUM(i.num_visit) AS num_visit
                FROM ingreso i
                JOIN ultimos_ingresos u ON i.nhc = u.nhc AND i.fecha_ingreso = u.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_crm($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH ultimos_ingresos AS (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                )
                SELECT 
                    ROUND(SUM(CASE WHEN i.crm = '0' OR i.crm = '1' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRM 1',
                    ROUND(SUM(CASE WHEN i.crm = '2' OR i.crm = '3' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRM 2-3',
                    ROUND(SUM(CASE WHEN i.crm = '4' OR i.crm = '5' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crm IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRM 4-5'
                FROM ingreso AS i
                JOIN ultimos_ingresos u ON i.nhc = u.nhc AND i.fecha_ingreso = u.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_crf($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH ultimos_ingresos AS (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                )
                SELECT 
                    ROUND(SUM(CASE WHEN i.crf = '0' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRF 0',
                    ROUND(SUM(CASE WHEN i.crf = '1' OR i.crf = '2' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRF 1-2',
                    ROUND(SUM(CASE WHEN i.crf = '3' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRF 3',
                    ROUND(SUM(CASE WHEN i.crf = '4' OR i.crf = 5 THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.crf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'CRF 4-5'
                FROM ingreso AS i
                JOIN ultimos_ingresos u ON i.nhc = u.nhc AND i.fecha_ingreso = u.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function get_datos_barthel($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH ultimos_ingresos AS (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                )
                SELECT 
                    ROUND(SUM(CASE WHEN i.barthel < '45' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Barthel menor que 45',
                    ROUND(SUM(CASE WHEN i.barthel >= '45' AND i.barthel <= '59' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Barthel entre 45 y 59',
                    ROUND(SUM(CASE WHEN i.barthel >= '60' AND i.barthel <= '80' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Barthel entre 60 y 80',
                    ROUND(SUM(CASE WHEN i.barthel > '80' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.barthel IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Barthel mayor que 80'
                FROM ingreso AS i
                JOIN ultimos_ingresos u ON i.nhc = u.nhc AND i.fecha_ingreso = u.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function get_datos_pfeiffer($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH ultimos_ingresos AS (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                )
                SELECT 
                    ROUND(SUM(CASE WHEN i.pfeiffer <= '4' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.pfeiffer IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Pfeiffer menor o igual que 4',
                    ROUND(SUM(CASE WHEN i.pfeiffer > '4' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN i.pfeiffer IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Pfeiffer mayor que 4'
                FROM ingreso AS i
                JOIN ultimos_ingresos u ON i.nhc = u.nhc AND i.fecha_ingreso = u.fecha_max
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        //seguir cambiando a with
        public function get_ingreso_pr($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT DISTINCT nhc, id_procedencia
                    FROM ingreso
                    WHERE fecha_ingreso <= :fin
                    AND (fecha_alta IS NULL OR fecha_alta >= :inicio)
                ),
                total_pacientes_con_procedencia AS (
                    SELECT COUNT(DISTINCT nhc) AS total
                    FROM pacientes_validos
                    WHERE id_procedencia IS NOT NULL
                )

                SELECT 
                    pr.descripcion AS descripcion,
                    ROUND(
                        COUNT(pv.nhc) * 100.0 / 
                        NULLIF((SELECT total FROM total_pacientes_con_procedencia), 0),
                    2) AS porcentaje
                FROM procedencia pr
                LEFT JOIN pacientes_validos pv ON pv.id_procedencia = pr.id_procedencia
                GROUP BY pr.descripcion;
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_ingreso_migr($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT DISTINCT nhc, id_motivo_ingreso
                    FROM ingreso
                    WHERE fecha_ingreso <= :fin
                    AND (fecha_alta IS NULL OR fecha_alta >= :inicio)
                ),
                total_pacientes_con_motivo_ingreso AS (
                    SELECT COUNT(DISTINCT nhc) AS total
                    FROM pacientes_validos
                    WHERE id_motivo_ingreso IS NOT NULL
                )
                SELECT 
                    migr.descripcion AS descripcion,
                    ROUND(
                        COUNT(pv.nhc) * 100.0 / 
                        NULLIF((SELECT total FROM total_pacientes_con_motivo_ingreso), 0),
                    2) AS porcentaje
                FROM motivo_ingreso migr
                LEFT JOIN pacientes_validos pv ON pv.id_motivo_ingreso = migr.id_motivo_ingreso
                GROUP BY migr.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_ingreso_de($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT DISTINCT nhc, id_destino
                    FROM ingreso
                    WHERE fecha_ingreso <= :fin
                    AND (fecha_alta IS NULL OR fecha_alta >= :inicio)
                ),
                total_pacientes_con_destino AS (
                    SELECT COUNT(DISTINCT nhc) AS total
                    FROM pacientes_validos
                    WHERE id_destino IS NOT NULL
                )
                SELECT 
                    de.descripcion AS descripcion,
                    ROUND(
                        COUNT(pv.nhc) * 100.0 / 
                        NULLIF((SELECT total FROM total_pacientes_con_destino), 0),
                    2) AS porcentaje
                FROM destino de
                LEFT JOIN pacientes_validos pv ON pv.id_destino = de.id_destino
                GROUP BY de.descripcion;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_porcentaje_muerte_domicilio($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(
                        COUNT(CASE WHEN dp.rip_domi = 'SÍ' THEN 1 END) * 100.0 /
                        NULLIF(COUNT(*), 0),
                        2
                    ) AS porcentaje
                FROM ingreso AS i
                JOIN (
                    SELECT nhc, MAX(fecha_ingreso) AS fecha_max
                    FROM ingreso
                    GROUP BY nhc
                ) AS ultimos
                    ON i.nhc = ultimos.nhc AND i.fecha_ingreso = ultimos.fecha_max
                JOIN datos_paciente AS dp ON dp.nhc = i.nhc
                WHERE i.id_destino = 8
                AND i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_media_dias_ingreso($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(AVG(DATEDIFF(fecha_alta, fecha_ingreso)), 2) as get_media_dias_ingreso
                FROM ingreso
                WHERE fecha_ingreso <= :fin
                AND (fecha_alta >= :inicio)
                AND fecha_alta IS NOT NULL;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function datos_paciente_por_migr($id_motivo_ingreso) {
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
                LEFT JOIN centro_salud AS cs ON dp.id_centro_salud = cs.id_centro_salud
                JOIN ingreso AS i ON i.nhc = dp.nhc
                LEFT JOIN motivo_inc AS mi ON dp.id_motivo_inc = mi.id_motivo_inc
                JOIN motivo_ingreso AS migr ON i.id_motivo_ingreso = migr.id_motivo_ingreso
                WHERE i.fecha_alta IS NULL 
                AND i.id_motivo_ingreso = :id_motivo_ingreso;
            ");
            $stmt->bindParam(":id_motivo_ingreso", $id_motivo_ingreso);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function datos_paciente_por_tr($id_tratamiento) {
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
                    cs.codigo_centro as codigo_centro,
                    tr.descripcion as tratamiento
                FROM datos_paciente AS dp
                LEFT JOIN centro_salud AS cs ON dp.id_centro_salud = cs.id_centro_salud
                JOIN ingreso AS i ON i.nhc = dp.nhc
                JOIN ingreso_tratamiento AS it ON it.id_ingreso = i.id_ingreso
                JOIN tratamiento AS tr ON it.id_tratamiento = tr.id_tratamiento
                LEFT JOIN motivo_inc AS mi ON dp.id_motivo_inc = mi.id_motivo_inc
                JOIN motivo_ingreso AS migr ON i.id_motivo_ingreso = migr.id_motivo_ingreso
                WHERE i.fecha_alta IS NULL 
                AND tr.id_tratamiento = :id_tratamiento;
            ");
            $stmt->bindParam(":id_tratamiento", $id_tratamiento);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>