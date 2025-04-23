<?php
    require_once("motivo_ingreso.php");
    require_once("procedencia.php");
    require_once("destino.php");
    require_once("tratamiento.php");
    require_once("BBDD.php");
    error_reporting(E_ALL);
    ini_set('log_errors', 1);  
    ini_set('error_log', 'C:\\xampp\\htdocs\\php\\PROYECTO_FINAL\\TFG\\logs\\error_log.txt');
    class Ingreso {
        private ?int $id; 
        private string $fecha_ingreso;
        private ?string $fecha_alta;
        private ?string $reingreso;
        private ?string $eco;
        private ?string $crf;
        private ?string $crm;
        private ?int $barthel;
        private ?int $pfeiffer;
        private ?int $cultivo;
        private ?int $minimental;
        private ?int $analitica;
        private ?int $NUM_VISIT;
        private int $nhc;
        private ?Motivo_ingreso $motivo_ingreso;
        private ?Procedencia $procedencia;
        private ?Destino $destino;
        private array $lista_tratamientos;
        
        public function __construct() {
            $this->id = null;
            $this->fecha_ingreso = "";
            $this->fecha_alta = null;
            $this->reingreso = null;
            $this->eco = null;
            $this->crf = null;
            $this->crm = null;
            $this->barthel = null;
            $this->pfeiffer = null;
            $this->cultivo = null;
            $this->minimental = null;
            $this->analitica = null;
            $this->NUM_VISIT = null;
            $this->nhc = 0;
            $this->motivo_ingreso = null;
            $this->procedencia = null;
            $this->destino = null;
            $this->lista_tratamientos = [];
        }
        public function __destruct() {
            $this->id = null;
            $this->fecha_ingreso = "";
            $this->fecha_alta = null;
            $this->reingreso = null;
            $this->eco = null;
            $this->crf = null;
            $this->crm = null;
            $this->barthel = null;
            $this->pfeiffer = null;
            $this->cultivo = null;
            $this->minimental = null;
            $this->analitica = null;
            $this->NUM_VISIT = null;
            $this->nhc = 0;
            $this->motivo_ingreso = null;
            $this->procedencia = null;
            $this->destino = null;
            $this->lista_tratamientos = [];
        }
        public function cargar_datos($fecha_ingreso, $fecha_alta, $reingreso, $eco, $crf, $crm, $barthel, $pfeiffer, $cultivo, 
                                    $minimental, $analitica, $NUM_VISIT, $nhc) {
            $this->fecha_ingreso = $fecha_ingreso;
            $this->fecha_alta = $fecha_alta;
            $this->reingreso = $reingreso;
            $this->eco = $eco;
            $this->crf = $crf;
            $this->crm = $crm;
            $this->barthel = $barthel;
            $this->pfeiffer = $pfeiffer;
            $this->minimental = $minimental;
            $this->cultivo = $cultivo;
            $this->analitica = $analitica;
            $this->NUM_VISIT = $NUM_VISIT;
            $this->nhc = $nhc;
        }
        public function set_motivo_ingreso(int $id_motivo_ingreso) {
            $motivo_ingreso = new Motivo_ingreso();
            $motivo_ingreso->cargar_datos_desde_BBDD($id_motivo_ingreso);
            $this->motivo_ingreso = $motivo_ingreso;
        }
        public function set_procedencia(int $id_procedencia) {
            $procedencia = new Procedencia();
            $procedencia->cargar_datos_desde_BBDD($id_procedencia);
            $this->procedencia = $procedencia;
        }
        public function set_destino(int $id_destino) {
            $destino = new Destino();
            $destino->cargar_datos_desde_BBDD($id_destino);
            $this->destino = $destino;
        }
        public function set_tratamientos($lista_tratamientos) {
            foreach($lista_tratamientos as $id_tratamiento) {
                $tratamiento = new Tratamiento();
                $tratamiento->cargar_datos_desde_BBDD($id_tratamiento);
                $this->lista_tratamientos[] = $tratamiento;
            }
        }
        public function aniadir_ingreso() {
            $aniadido = false;
            try {
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $pdo->beginTransaction();
                $stmt = $pdo->prepare("INSERT INTO ingreso (fecha_ingreso, fecha_alta, reingreso, eco, crf, crm, barthel, pfeiffer, cultivo,
                                        minimental, analitica, NUM_VISIT, nhc, id_motivo_ingreso, id_procedencia, id_destino)
                                    VALUES (:fecha_ingreso, :fecha_alta, :reingreso, :eco, :crf, :crm, :barthel, :pfeiffer, :cultivo, 
                                        :minimental, :analitica, :NUM_VISIT, :nhc, :id_motivo_ingreso, :id_procedencia, :id_destino)");
                    $stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
                    $stmt->bindParam(":fecha_alta", $this->fecha_alta);
                    $stmt->bindParam(":reingreso", $this->reingreso);
                    $stmt->bindParam(":eco", $this->eco);
                    $stmt->bindParam(":crf", $this->crf);
                    $stmt->bindParam(":crm", $this->crm);
                    $stmt->bindParam(":barthel", $this->barthel);
                    $stmt->bindParam(":pfeiffer", $this->pfeiffer);
                    $stmt->bindParam(":cultivo", $this->cultivo);
                    $stmt->bindParam(":minimental", $this->minimental);
                    $stmt->bindParam(":analitica", $this->analitica);
                    $stmt->bindParam(":NUM_VISIT", $this->NUM_VISIT);
                    $stmt->bindParam(":nhc", $this->nhc);
                    if ($this->motivo_ingreso != null) {
                        $datos = $this->motivo_ingreso->get_migr();
                        $motivo_ingreso = $datos["id"];
                    }
                    if ($this->procedencia != null) {
                        $datos = $this->procedencia->get_pr();
                        $procedencia = $datos["id"];
                    }
                    if ($this->destino != null) {
                        $datos = $this->destino->get_de();
                        $destino = $datos["id"];
                    }
                    $stmt->bindParam(":id_motivo_ingreso", $motivo_ingreso);
                    $stmt->bindParam(":id_procedencia", $procedencia);
                    $stmt->bindParam(":id_destino", $destino);
                    $stmt->execute();
                    //$id_ingreso = $pdo->lastInsertId(); opcion mas rapida sin hacer el select
                    if (!empty($this->lista_tratamientos)) {
                        $stmt = $pdo->prepare("SELECT * FROM ingreso WHERE nhc = :nhc AND fecha_ingreso = :fecha_ingreso;");
                        $stmt->bindParam(":nhc", $this->nhc);
                        $stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);
                        $stmt->execute();
                        $ingreso = $stmt->fetch(PDO::FETCH_ASSOC);
                        $id_ingreso = $ingreso["id_ingreso"];
                        $stmt = $pdo->prepare("INSERT INTO ingreso_tratamiento (id_ingreso, id_tratamiento)
                                                VALUES (:id_ingreso, :id_tratamiento)");
                        $stmt->bindParam(":id_ingreso", $id_ingreso);
                        foreach($this->lista_tratamientos as $tratamiento) {
                            $datos = $tratamiento->get_tr();
                            $tratamiento = $datos["id"];
                            $stmt->bindParam(":id_tratamiento", $tratamiento);
                            $stmt->execute();
                        }
                    }
                    $pdo->commit();
                    $aniadido = true;
            }
            catch (Exception $e) {
                error_log("Error al añadir ingreso: " . $e->getMessage(), 3, "logs/error_log.txt");
                $pdo->rollback();
            }
            finally {
                unset($bd);
                return $aniadido;
            }
        }

        public function cargar_datos_desde_BBDD($id_ingreso) {
            $existe = false;
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ingreso WHERE id_ingreso=:id_ingreso");
            $stmt->bindParam(":id_ingreso", $id_ingreso);
            $stmt->execute();
            if ($ingreso = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->id = $ingreso["id_ingreso"];
                $this->fecha_ingreso = $ingreso["fecha_ingreso"];
                $this->fecha_alta = $ingreso["fecha_alta"];
                $this->reingreso = $ingreso["reingreso"];
                $this->eco = $ingreso["eco"];
                $this->crf = $ingreso["crf"];
                $this->crm = $ingreso["crm"];
                $this->barthel = $ingreso["barthel"];
                $this->pfeiffer = $ingreso["pfeiffer"];
                $this->minimental = $ingreso["minimental"];
                $this->cultivo = $ingreso["cultivo"];
                $this->analitica = $ingreso["analitica"];
                $this->NUM_VISIT = $ingreso["NUM_VISIT"];
                $this->nhc = $ingreso["nhc"];
                if ($ingreso["id_motivo_ingreso"] != null) {
                    $this->motivo_ingreso = new Motivo_ingreso();
                    $this->motivo_ingreso->cargar_datos_desde_BBDD($ingreso["id_motivo_ingreso"]);
                }

                if ($ingreso["id_procedencia"] != null) {
                    $this->procedencia = new Procedencia();
                    $this->procedencia->cargar_datos_desde_BBDD($ingreso["id_procedencia"]);
                }

                if ($ingreso["id_destino"] != null) {
                    $this->destino = new Destino();
                    $this->destino->cargar_datos_desde_BBDD($ingreso["id_destino"]);
                }
                $stmt = $pdo->prepare("SELECT * FROM ingreso_tratamiento WHERE id_ingreso=:id_ingreso");
                $stmt->bindParam(":id_ingreso", $id_ingreso);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();       
                while ($ingreso_tratamiento = $stmt->fetch()) {
                    $tratamiento = new Tratamiento();
                    $tratamiento->cargar_datos_desde_BBDD($ingreso_tratamiento["id_tratamiento"]);
                    $this->lista_tratamientos[] = $tratamiento;
                }
            }
        }

        public function get_datos_ingreso() {
            $lista_tratamientos = [];
            if (!empty($this->lista_tratamientos)){
                foreach ($this->lista_tratamientos as $tratamiento) {
                    $lista_tratamientos[] = $tratamiento->get_tr()["id"];
                }
            }
            $datos = [
                "id" => $this->id,
                "fecha_ingreso" => $this->fecha_ingreso,
                "fecha_alta" => $this->fecha_alta,
                "reingreso" => $this->reingreso,
                "eco" => $this->eco,
                "crf" => $this->crf,
                "crm" => $this->crm,
                "barthel" => $this->barthel,
                "pfeiffer" => $this->pfeiffer,
                "minimental" => $this->minimental,
                "cultivo" => $this->cultivo,
                "analitica" => $this->analitica,
                "NUM_VISIT" => $this->NUM_VISIT,
                "nhc" => $this->nhc,
                "motivo_ingreso" => $this->motivo_ingreso ? $this->motivo_ingreso->get_migr()["id"] : null,
                "procedencia" => $this->procedencia ? $this->procedencia->get_pr() : null,
                "destino" => $this->destino ? $this->destino->get_de()["id"] : null,
                "lista_tratamientos" => $lista_tratamientos
            ];
            return $datos;
        }
        
    }
?>