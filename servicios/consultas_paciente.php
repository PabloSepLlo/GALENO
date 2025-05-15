<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_paciente {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_datos_paciente($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT DISTINCT dp.nhc, dp.edad, dp.sexo, dp.in_ur, dp.in_fec, 
                        dp.insom, dp.dolor, dp.disf, dp.grado_ulcera
                    FROM datos_paciente dp
                    JOIN ingreso i ON dp.nhc = i.nhc
                    WHERE i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                )
                SELECT 
                    COUNT(*) AS n_pacientes,
                    ROUND(AVG(edad), 2) AS edad_media,
                    ROUND(SUM(CASE WHEN sexo = 'F' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS mujeres,
                    ROUND(SUM(CASE WHEN sexo = 'M' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS hombres,
                    ROUND(SUM(CASE WHEN in_ur = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(in_ur), 0), 2) AS in_ur,
                    ROUND(SUM(CASE WHEN in_fec = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(in_fec), 0), 2) AS in_fec,
                    ROUND(SUM(CASE WHEN insom = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(insom), 0), 2) AS insom,
                    ROUND(SUM(CASE WHEN dolor = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(dolor), 0), 2) AS dolor,
                    ROUND(SUM(CASE WHEN disf = 'SÍ' THEN 1 ELSE 0 END) * 100.0 / NULLIF(COUNT(disf), 0), 2) AS disfagia,
                    ROUND(
                        SUM(CASE WHEN grado_ulcera IS NOT NULL AND grado_ulcera != '0' THEN 1 ELSE 0 END) * 100.0
                        / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0),
                    2) AS ulcera_total
                FROM pacientes_validos;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_grados_ulcera($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT DISTINCT dp.nhc, dp.grado_ulcera
                    FROM datos_paciente dp
                    JOIN ingreso i ON dp.nhc = i.nhc
                    WHERE i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                )
                SELECT 
                    ROUND(SUM(CASE WHEN grado_ulcera = '0' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Sin úlcera',
                    ROUND(SUM(CASE WHEN grado_ulcera = '1' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 1',
                    ROUND(SUM(CASE WHEN grado_ulcera = '2' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 2',
                    ROUND(SUM(CASE WHEN grado_ulcera = '3' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 3',
                    ROUND(SUM(CASE WHEN grado_ulcera = '4' THEN 1 ELSE 0 END) * 100.0 / NULLIF(SUM(CASE WHEN grado_ulcera IS NOT NULL THEN 1 ELSE 0 END), 0), 2) AS 'Grado 4'
                FROM pacientes_validos
                ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function get_paciente_cs($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH pacientes_validos AS (
                    SELECT COUNT(DISTINCT i.nhc) AS total
                    FROM ingreso i
                    JOIN datos_paciente dp ON i.nhc = dp.nhc
                    WHERE i.fecha_ingreso <= :fin
                    AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                    AND dp.id_centro_salud IS NOT NULL
                    ),
                    pacientes_por_centro AS (
                        SELECT 
                            cs.codigo_centro,
                            COUNT(DISTINCT i.nhc) AS cantidad
                        FROM centro_salud cs
                        LEFT JOIN datos_paciente dp ON dp.id_centro_salud = cs.id_centro_salud
                        LEFT JOIN ingreso i ON i.nhc = dp.nhc
                            AND i.fecha_ingreso <= :fin
                            AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        GROUP BY cs.codigo_centro
                )
                SELECT 
                    ppcs.codigo_centro,
                    ROUND(
                        ppcs.cantidad * 100.0 / 
                        NULLIF(pv.total, 0),
                    2) AS porcentaje
                FROM pacientes_por_centro ppcs
                CROSS JOIN pacientes_validos pv;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_c($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH 
                    pacientes_validos AS (
                        SELECT COUNT(DISTINCT i.nhc) AS total
                        FROM ingreso i
                        JOIN datos_paciente dp ON i.nhc = dp.nhc
                        WHERE i.fecha_ingreso <= :fin
                        AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        AND dp.id_convivencia IS NOT NULL
                    ),
                    pacientes_por_convivencia AS (
                        SELECT 
                            c.descripcion,
                            COUNT(DISTINCT i.nhc) AS cantidad
                        FROM convivencia c
                        LEFT JOIN datos_paciente dp ON dp.id_convivencia = c.id_convivencia
                        LEFT JOIN ingreso i ON i.nhc = dp.nhc
                            AND i.fecha_ingreso <= :fin
                            AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        GROUP BY c.descripcion
                    )
                SELECT 
                    ppc.descripcion,
                    ROUND(
                        ppc.cantidad * 100.0 / 
                        NULLIF(pv.total, 0),
                    2) AS porcentaje
                FROM pacientes_por_convivencia ppc
                CROSS JOIN pacientes_validos pv;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_pc($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH 
                    pacientes_validos AS (
                        SELECT COUNT(DISTINCT i.nhc) AS total
                        FROM ingreso i
                        JOIN datos_paciente dp ON i.nhc = dp.nhc
                        WHERE i.fecha_ingreso <= :fin
                        AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        AND dp.id_ppal_cuidador IS NOT NULL
                    ),
                    pacientes_por_ppal_cuidador AS (
                        SELECT 
                            pc.descripcion,
                            COUNT(DISTINCT i.nhc) AS cantidad
                        FROM ppal_cuidador pc
                        LEFT JOIN datos_paciente dp ON dp.id_ppal_cuidador = pc.id_ppal_cuidador
                        LEFT JOIN ingreso i ON i.nhc = dp.nhc
                            AND i.fecha_ingreso <= :fin
                            AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        GROUP BY pc.descripcion
                    )
                SELECT 
                    pppc.descripcion,
                    ROUND(
                        pppc.cantidad * 100.0 / 
                        NULLIF(pv.total, 0),
                    2) AS porcentaje
                FROM pacientes_por_ppal_cuidador pppc
                CROSS JOIN pacientes_validos pv;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_paciente_as($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH 
                    pacientes_validos AS (
                        SELECT COUNT(DISTINCT i.nhc) AS total
                        FROM ingreso i
                        JOIN datos_paciente dp ON i.nhc = dp.nhc
                        WHERE i.fecha_ingreso <= :fin
                        AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        AND dp.id_ayuda_social IS NOT NULL
                    ),
                    pacientes_por_ayuda_social AS (
                        SELECT 
                            ays.descripcion,
                            COUNT(DISTINCT i.nhc) AS cantidad
                        FROM ayuda_social ays
                        LEFT JOIN datos_paciente dp ON dp.id_ayuda_social = ays.id_ayuda_social
                        LEFT JOIN ingreso i ON i.nhc = dp.nhc
                            AND i.fecha_ingreso <= :fin
                            AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        GROUP BY ays.descripcion
                    )
                SELECT 
                    ppays.descripcion,
                    ROUND(
                        ppays.cantidad * 100.0 / 
                        NULLIF(pv.total, 0),
                    2) AS porcentaje
                FROM pacientes_por_ayuda_social ppays
                CROSS JOIN pacientes_validos pv;
            ");
            $stmt->bindParam(":inicio", $inicio);
            $stmt->bindParam(":fin", $fin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_paciente_mi($inicio, $fin) {
            $stmt = $this->pdo->prepare("
                WITH 
                    pacientes_validos AS (
                        SELECT COUNT(DISTINCT i.nhc) AS total
                        FROM ingreso i
                        JOIN datos_paciente dp ON i.nhc = dp.nhc
                        WHERE i.fecha_ingreso <= :fin
                        AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        AND dp.id_motivo_inc IS NOT NULL
                    ),
                    pacientes_por_motivo_inc AS (
                        SELECT 
                            mi.descripcion,
                            COUNT(DISTINCT i.nhc) AS cantidad
                        FROM motivo_inc mi
                        LEFT JOIN datos_paciente dp ON dp.id_motivo_inc = mi.id_motivo_inc
                        LEFT JOIN ingreso i ON i.nhc = dp.nhc
                            AND i.fecha_ingreso <= :fin
                            AND (i.fecha_alta IS NULL OR i.fecha_alta >= :inicio)
                        GROUP BY mi.descripcion
                    )
                SELECT 
                    ppmi.descripcion,
                    ROUND(
                        ppmi.cantidad * 100.0 / 
                        NULLIF(pv.total, 0),
                    2) AS porcentaje
                FROM pacientes_por_motivo_inc ppmi
                CROSS JOIN pacientes_validos pv;
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