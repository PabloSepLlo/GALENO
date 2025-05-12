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
                    ROUND(AVG(dp.edad), 2) AS edad_media,
                    ROUND(SUM(CASE WHEN dp.sexo = 'F' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS mujeres,
                    ROUND(SUM(CASE WHEN dp.sexo = 'M' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS hombres,
                    ROUND(SUM(CASE WHEN dp.in_ur = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.in_ur IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS in_ur,
                    ROUND(SUM(CASE WHEN dp.in_fec = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.in_fec IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS in_fec,
                    ROUND(SUM(CASE WHEN dp.insom = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.insom IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS insom,
                    ROUND(SUM(CASE WHEN dp.dolor = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.dolor IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS dolor,
                    ROUND(SUM(CASE WHEN dp.disf = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.disf IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS disfagia,
                    ROUND(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS ulcera_total
                FROM datos_paciente dp
                JOIN ingreso i ON dp.nhc = i.nhc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_grados_ulcera($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = '0' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Sin úlcera',
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = '1' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 1',
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = '2' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 2',
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = '3' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 3',
                    ROUND(SUM(CASE WHEN dp.grado_ulcera = '4' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN dp.grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 4'
                FROM datos_paciente dp
                JOIN ingreso i ON dp.nhc = i.nhc
                WHERE i.fecha_ingreso <= :fin
                AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio);
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_paciente_cs($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    cs.codigo_centro,
                    ROUND(
                        COUNT(i.nhc) * 100.0 /  
                        NULLIF(
                            (SELECT COUNT(i2.nhc)
                            FROM ingreso i2
                            JOIN datos_paciente dp2 ON i2.nhc = dp2.nhc
                            WHERE i2.fecha_ingreso <= :fin
                            AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                            AND dp2.id_centro_salud IS NOT NULL)
                        , 0)
                    , 2) AS porcentaje
                FROM centro_salud cs
                LEFT JOIN datos_paciente dp ON dp.id_centro_salud = cs.id_centro_salud
                LEFT JOIN ingreso i ON i.nhc = dp.nhc
                    AND i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY cs.codigo_centro
            ");
            /*Explicacion consulta:
                Capturamos todos los codigos centros y el porcentaje de pacientes activos (con un ingreso activo) y que
                el centro de salud no sea nulo. Hacemos dos left joins con las tablas de ingreso y de paciente. Nos aparecerán 
                todos los codigos centro y el porcentaje de pacientes en cada uno si los hay y si no un 0 (por NULLIF)
            */

            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_c($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    c.descripcion,
                    ROUND(
                        COUNT(i.nhc) * 100.0 / 
                        NULLIF(
                            (SELECT COUNT(i2.nhc)
                            FROM ingreso i2
                            JOIN datos_paciente dp2 ON i2.nhc = dp2.nhc
                            WHERE i2.fecha_ingreso <= :fin
                            AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                            AND dp2.id_convivencia IS NOT NULL)
                        , 0)
                    , 2) AS porcentaje
                FROM convivencia c
                LEFT JOIN datos_paciente dp ON dp.id_convivencia = c.id_convivencia
                LEFT JOIN ingreso i ON i.nhc = dp.nhc
                    AND i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY c.descripcion
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_pc($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    pc.descripcion,
                    ROUND(
                        COUNT(i.nhc) * 100.0 / 
                        NULLIF(
                            (SELECT COUNT(i2.nhc)
                            FROM ingreso i2
                            JOIN datos_paciente dp2 ON i2.nhc = dp2.nhc
                            WHERE i2.fecha_ingreso <= :fin
                            AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                            AND dp2.id_ppal_cuidador IS NOT NULL)
                        , 0)
                    , 2) AS porcentaje
                FROM ppal_cuidador pc
                LEFT JOIN datos_paciente dp ON dp.id_ppal_cuidador = pc.id_ppal_cuidador
                LEFT JOIN ingreso i ON i.nhc = dp.nhc
                    AND i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY pc.descripcion
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_as($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    ays.descripcion,
                    ROUND(
                        COUNT(i.nhc) * 100.0 / 
                        NULLIF(
                            (SELECT COUNT(i2.nhc)
                            FROM ingreso i2
                            JOIN datos_paciente dp2 ON i2.nhc = dp2.nhc
                            WHERE i2.fecha_ingreso <= :fin
                            AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                            AND dp2.id_ayuda_social IS NOT NULL)
                        , 0)
                    , 2) AS porcentaje
                FROM ayuda_social ays
                LEFT JOIN datos_paciente dp ON dp.id_ayuda_social = ays.id_ayuda_social
                LEFT JOIN ingreso i ON i.nhc = dp.nhc
                    AND i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY ays.descripcion
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_mi($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    mi.descripcion,
                    ROUND(
                        COUNT(i.nhc) * 100.0 / 
                        NULLIF(
                            (SELECT COUNT(i2.nhc)
                            FROM ingreso i2
                            JOIN datos_paciente dp2 ON i2.nhc = dp2.nhc
                            WHERE i2.fecha_ingreso <= :fin
                            AND (i2.fecha_alta IS NULL OR i2.fecha_alta >= :inicio)
                            AND dp2.id_motivo_inc IS NOT NULL)
                        , 0)
                    , 2) AS porcentaje
                FROM motivo_inc mi
                LEFT JOIN datos_paciente dp ON dp.id_motivo_inc = mi.id_motivo_inc
                LEFT JOIN ingreso i ON i.nhc = dp.nhc
                    AND i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                GROUP BY mi.descripcion
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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