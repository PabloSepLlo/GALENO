<?php
    require_once("centro_salud.php");
    require_once("ayuda_social.php");
    require_once("convivencia.php");
    require_once("motivo_inc.php");
    require_once("ppal_cuidador.php");
    require_once("ingreso.php");
    require_once("BBDD.php");
    error_reporting(E_ALL);
    ini_set('log_errors', 1);  
    ini_set('error_log', 'C:\\xampp\\htdocs\\php\\PROYECTO_FINAL\\TFG\\logs\\error_log.txt');

    /**
     * Clase Paciente
     * 
     * Esta clase representa a un paciente con sus datos personales, clínicos y sociales,
     * y permite realizar operaciones como cargar datos desde la base de datos, añadir y
     * actualizar, además de manejar relaciones con otras entidades
     * como centro de salud, motivo de ingreso, ayuda social, convivencia y cuidador principal.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Paciente {
        private string $nhc;
        private string $nombre;
        private string $ape1;
        private ?string $ape2;
        private string $sexo;
        private int $edad;
        private ?Centro_salud $centro_salud;
        private ?string $medico;
        private ?string $enfermera;
        private ?Motivo_inc $motivo_inc;
        private ?int $co_morb;
        private ?int $num_farm;
        private ?int $grado_ulcera;
        private ?string $rip_domi;
        private ?string $in_ur;
        private ?string $in_fec;
        private ?string $insom;
        private ?string $sob_cui;
        private ?string $dolor;
        private ?string $upp;
        private ?string $disf;
        private ?string $sv;
        private ?string $sng;
        private ?string $ocd;
        private ?Ayuda_social $ayuda_social;
        private ?Convivencia $convivencia;
        private ?Ppal_cuidador $ppal_cuidador;
        private array $lista_ingresos;
        

        public function __construct() {
            $this->nhc = 0;
            $this->nombre = "";
            $this->ape1 = "";
            $this->ape2 = "";
            $this->sexo = "";
            $this->edad = 0;
            $this->centro_salud = null;
            $this->medico = null;
            $this->enfermera = null;
            $this->motivo_inc = null;
            $this->co_morb = null;
            $this->num_farm = null;
            $this->grado_ulcera = null;
            $this->rip_domi = null;
            $this->in_ur = null;
            $this->in_fec = null;
            $this->insom = null;
            $this->sob_cui = null;
            $this->dolor = null;
            $this->upp = null;
            $this->disf = null;
            $this->sv = null;
            $this->sng = null;
            $this->ocd = null;
            $this->ayuda_social = null;
            $this->convivencia = null;
            $this->ppal_cuidador = null;
            $this->lista_ingresos = [];
        }
        public function __destruct() {
            $this->nhc = 0;
            $this->nombre = "";
            $this->ape1 = "";
            $this->ape2 = "";
            $this->sexo = "";
            $this->edad = 0;
            $this->centro_salud = null;
            $this->medico = null;
            $this->enfermera = null;
            $this->motivo_inc = null;
            $this->co_morb = null;
            $this->num_farm = null;
            $this->grado_ulcera = null;
            $this->rip_domi = null;
            $this->in_ur = null;
            $this->in_fec = null;
            $this->insom = null;
            $this->sob_cui = null;
            $this->dolor = null;
            $this->upp = null;
            $this->disf = null;
            $this->sv = null;
            $this->sng = null;
            $this->ocd = null;
            $this->ayuda_social = null;
            $this->convivencia = null;
            $this->ppal_cuidador = null;
            $this->lista_ingresos = [];
        }

        /**
         * Carga los datos del paciente en la instancia.
         * 
         * @param string $nhc Número de historia clínica.
         * @param string $nombre Nombre del paciente.
         * @param string $ape1 Primer apellido.
         * @param string $ape2 Segundo apellido.
         * @param string $sexo Sexo del paciente.
         * @param int $edad Edad del paciente.
         * @param string $medico Médico asignado.
         * @param string $enfermera Enfermero/a asignada.
         * @param string $co_morb Comorbilidades.
         * @param int $num_farm Número de fármacos.
         * @param string $grado_ulcera Grado de úlcera.
         * @param string $dolor Dolor asociado.
         * @param string $rip_domi Muerte en domicilio.
         * @param string $upp Úlceras por presión.
         * @param string $in_ur Incontinencia urinaria.
         * @param string $disf Disfagia.
         * @param string $in_fec Incontinencia fecal.
         * @param string $sv Sonda vesical.
         * @param string $insom Insomnio.
         * @param string $sng Sonda nasogástrica.
         * @param string $sob_cui Sobrecarga de cuidado.
         * @param string $ocd Oxigenoterapia.
         * 
         * @return void
         */
        public function cargar_datos($nhc, $nombre, $ape1, $ape2, $sexo, $edad, $medico, $enfermera, $co_morb, $num_farm, $grado_ulcera,
                                                $dolor, $rip_domi, $upp, $in_ur, $disf, $in_fec, $sv, $insom, $sng, $sob_cui, $ocd){
            $this->nhc = $nhc;
            $this->nombre = $nombre;
            $this->ape1 = $ape1;
            $this->ape2 = $ape2;  
            $this->sexo = $sexo;
            $this->edad = $edad;
            $this->medico = $medico;
            $this->enfermera = $enfermera;
            $this->co_morb = $co_morb;
            $this->num_farm = $num_farm;
            $this->grado_ulcera = $grado_ulcera;
            $this->rip_domi = $rip_domi;
            $this->in_ur = $in_ur;
            $this->in_fec = $in_fec;
            $this->insom = $insom;
            $this->sob_cui = $sob_cui;
            $this->dolor = $dolor;
            $this->upp = $upp;
            $this->disf = $disf;
            $this->sv = $sv;
            $this->sng = $sng;
            $this->ocd = $ocd;
        }

        /**
         * Establece el centro de salud del paciente.
         * 
         * @param int $id_centro_salud ID del centro de salud.
         * @return void
         */
        public function set_centro_salud(int $id_centro_salud) {
            $centro_salud = new Centro_salud();
            $centro_salud->cargar_datos_desde_BBDD($id_centro_salud);
            $this->centro_salud = $centro_salud;
        }

        /**
         * Establece el motivo de ingreso del paciente.
         * 
         * @param int $id_motivo_inc ID del motivo de incapacidad.
         * @return void
         */
        public function set_motivo_inc(int $id_motivo_inc) {
            $motivo_inc = new Motivo_inc();
            $motivo_inc->cargar_datos_desde_BBDD($id_motivo_inc);
            $this->motivo_inc = $motivo_inc;
        }

        /**
         * Establece la ayuda social del paciente.
         * 
         * @param int $id_ayuda_social ID de la ayuda social.
         * @return void
         */
        public function set_ayuda_social(int $id_ayuda_social) {
            $ayuda_social = new Ayuda_social();
            $ayuda_social->cargar_datos_desde_BBDD($id_ayuda_social);
            $this->ayuda_social = $ayuda_social;
        }

        /**
         * Establece la convivencia del paciente.
         * 
         * @param int $id_convivencia ID de la convivencia.
         * @return void
         */
        public function set_convivencia(int $id_convivencia) {
            $convivencia = new Convivencia();
            $convivencia->cargar_datos_desde_BBDD($id_convivencia);
            $this->convivencia = $convivencia;
        }

        /**
         * Establece el cuidador principal del paciente.
         * 
         * @param int $id_ppal_cuidador ID del cuidador principal.
         * @return void
         */
        public function set_ppal_cuidador(int $id_ppal_cuidador) {
            $ppal_cuidador = new Ppal_cuidador();
            $ppal_cuidador->cargar_datos_desde_BBDD($id_ppal_cuidador);
            $this->ppal_cuidador = $ppal_cuidador;
        }

        /**
         * Añade un nuevo paciente a la base de datos.
         * 
         * @return bool Resultado de la operación (true si se añadió correctamente).
         */
        public function aniadir_paciente() {
            $aniadido = false;
            try {
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $stmt = $pdo->prepare("SELECT * FROM datos_paciente;");
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                $repetido = false;
                while (($paciente = $stmt->fetch()) && !$repetido) {
                    if ($paciente["nhc"] == $this->nhc) {
                        $repetido = true;
                    }
                }
                if (!$repetido) {
                    $stmt = $pdo->prepare("INSERT INTO datos_paciente (nhc, nombre, ape1, ape2, sexo, edad, medico, enfermera, co_morb, num_farm, 
                                            grado_ulcera, rip_domi, in_ur, in_fec, insom, sob_cui, dolor, upp, disf, sv, sng, ocd, id_centro_salud, 
                                            id_ayuda_social, id_motivo_inc, id_convivencia, id_ppal_cuidador)
                                        VALUES (:nhc, :nombre, :ape1, :ape2, :sexo, :edad, :medico, :enfermera, :co_morb, :num_farm, 
                                            :grado_ulcera, :rip_domi, :in_ur, :in_fec, :insom, :sob_cui, :dolor, :upp, :disf, :sv, :sng, 
                                            :ocd, :id_centro_salud, :id_ayuda_social, :id_motivo_inc, :id_convivencia, :id_ppal_cuidador)");
                    error_log("ENhc: " .$this->nhc , 3, "../logs/error_log.txt");
                    $stmt->bindParam(":nhc", $this->nhc);
                    $stmt->bindParam(":nombre", $this->nombre);
                    $stmt->bindParam(":ape1", $this->ape1);
                    $stmt->bindParam(":ape2", $this->ape2);
                    $stmt->bindParam(":sexo", $this->sexo);
                    $stmt->bindParam(":edad", $this->edad);
                    $stmt->bindParam(":medico", $this->medico);
                    $stmt->bindParam(":enfermera", $this->enfermera);
                    $stmt->bindParam(":co_morb", $this->co_morb);
                    $stmt->bindParam(":num_farm", $this->num_farm);
                    $stmt->bindParam(":grado_ulcera", $this->grado_ulcera);
                    $stmt->bindParam(":rip_domi", $this->rip_domi);
                    $stmt->bindParam(":in_ur", $this->in_ur);
                    $stmt->bindParam(":in_fec", $this->in_fec);
                    $stmt->bindParam(":insom", $this->insom);
                    $stmt->bindParam(":sob_cui", $this->sob_cui);
                    $stmt->bindParam(":dolor", $this->dolor);
                    $stmt->bindParam(":upp", $this->upp);
                    $stmt->bindParam(":disf", $this->disf);
                    $stmt->bindParam(":sv", $this->sv);
                    $stmt->bindParam(":sng", $this->sng);
                    $stmt->bindParam(":ocd", $this->ocd);
                    if ($this->centro_salud != null) {
                        $datos = $this->centro_salud->get_cs();
                        $centro_salud = $datos["id"];
                    }
                    if ($this->ayuda_social != null) {
                        $datos = $this->ayuda_social->get_as();
                        $ayuda_social = $datos["id"];
                    }
                    if ($this->motivo_inc != null) {
                        $datos = $this->motivo_inc->get_mi();
                        $motivo_inc = $datos["id"];
                    }
                    if ($this->convivencia != null) {
                        $datos = $this->convivencia->get_c();
                        $convivencia = $datos["id"];
                    }
                    if ($this->ppal_cuidador != null) {
                        $datos = $this->ppal_cuidador->get_pc();
                        $ppal_cuidador = $datos["id"];
                    }
                    $stmt->bindParam(":id_centro_salud", $centro_salud);
                    $stmt->bindParam(":id_ayuda_social", $ayuda_social);
                    $stmt->bindParam(":id_motivo_inc", $motivo_inc);
                    $stmt->bindParam(":id_convivencia", $convivencia);
                    $stmt->bindParam(":id_ppal_cuidador", $ppal_cuidador);
                    $stmt->execute();
                    $aniadido = true;

                }
            }
            catch (Exception $e) {
                error_log("Error al añadir paciente: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $aniadido;
            }
        }
        
        /**
         * Carga los datos del paciente desde la base de datos usando su NHC.
         * 
         * @param string $nhc Número de historia clínica.
         * @return bool Resultado de la operación (true si se cargaron los datos).
         */
        public function cargar_datos_desde_BBDD($nhc) {
            $existe = false;
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM datos_paciente WHERE nhc=:nhc");
            $stmt->bindParam(":nhc", $nhc);
            $stmt->execute();
            if ($paciente = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->nhc = $paciente["nhc"];
                $this->nombre = $paciente["nombre"];
                $this->ape1 = $paciente["ape1"];
                $this->ape2 = $paciente["ape2"];
                $this->sexo = $paciente["sexo"];
                $this->edad = $paciente["edad"];
                $this->medico = $paciente["medico"];
                $this->enfermera = $paciente["enfermera"];
                $this->co_morb = $paciente["co_morb"];
                $this->num_farm = $paciente["num_farm"];
                $this->grado_ulcera = $paciente["grado_ulcera"];
                $this->rip_domi = $paciente["rip_domi"];
                $this->in_ur = $paciente["in_ur"];
                $this->in_fec = $paciente["in_fec"];
                $this->insom = $paciente["insom"];
                $this->sob_cui = $paciente["sob_cui"];
                $this->dolor = $paciente["dolor"];
                $this->upp = $paciente["upp"];
                $this->disf = $paciente["disf"];
                $this->sv = $paciente["sv"];
                $this->sng = $paciente["sng"];
                $this->ocd = $paciente["ocd"];

                if ($paciente["id_centro_salud"] != null) {
                    $this->centro_salud = new Centro_salud();
                    $this->centro_salud->cargar_datos_desde_BBDD($paciente["id_centro_salud"]);
                }

                if ($paciente["id_ayuda_social"] != null) {
                    $this->ayuda_social = new Ayuda_social();
                    $this->ayuda_social->cargar_datos_desde_BBDD($paciente["id_ayuda_social"]);
                }

                if ($paciente["id_convivencia"] != null) {
                    $this->convivencia = new Convivencia();
                    $this->convivencia->cargar_datos_desde_BBDD($paciente["id_convivencia"]);
                }

                if ($paciente["id_ppal_cuidador"] != null) {
                    $this->ppal_cuidador = new Ppal_cuidador();
                    $this->ppal_cuidador->cargar_datos_desde_BBDD($paciente["id_ppal_cuidador"]);
                } 

                if ($paciente["id_motivo_inc"] != null) {
                    $this->motivo_inc = new Motivo_inc();
                    $this->motivo_inc->cargar_datos_desde_BBDD($paciente["id_motivo_inc"]);
                }

                $stmt = $pdo->prepare("SELECT * FROM ingreso WHERE nhc=:nhc");
                $stmt->bindParam(":nhc", $nhc);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                while ($datos_ingreso = $stmt->fetch()) {//$stmt->fetchObject
                    $ingreso = new Ingreso();
                    $ingreso->cargar_datos_desde_BBDD($datos_ingreso["id_ingreso"]);
                    $this->lista_ingresos[] = $ingreso; 
                }//opcion a ver, revisar si merece la pena hacer funcion que cargue el objeto desde array y otra por id para no repetir
                $existe = true;
            }
            return $existe;
        }

        /**
         * Obtiene los datos del paciente.
         * 
         * @return array Datos del paciente.
         */
        public function get_datos_paciente() {
            $lista_ingresos = [];
            if (!empty($this->lista_ingresos)) {
                foreach ($this->lista_ingresos as $ingreso) {
                    $lista_ingresos[] = $ingreso->get_datos_ingreso();
                }
            }
            $datos = [
                "nhc" => $this->nhc,
                "nombre" => $this->nombre,
                "ape1" => $this->ape1,
                "ape2" => $this->ape2,
                "sexo" => $this->sexo,
                "edad" => $this->edad,
                "medico" => $this->medico,
                "enfermera" => $this->enfermera,
                "co_morb" => $this->co_morb,
                "num_farm" => $this->num_farm,
                "grado_ulcera" => $this->grado_ulcera,
                "rip_domi" => $this->rip_domi,
                "in_ur" => $this->in_ur,
                "in_fec" => $this->in_fec,
                "insom" => $this->insom,
                "sob_cui" => $this->sob_cui,
                "dolor" => $this->dolor,
                "upp" => $this->upp,
                "disf" => $this->disf,
                "sv" => $this->sv,
                "sng" => $this->sng,
                "ocd" => $this->ocd,
                "centro_salud" => $this->centro_salud ? $this->centro_salud->get_cs()["id"] : null,
                "motivo_inc" => $this->motivo_inc ? $this->motivo_inc->get_mi()["id"] : null,
                "ayuda_social" => $this->ayuda_social ? $this->ayuda_social->get_as()["id"] : null,
                "convivencia" => $this->convivencia ? $this->convivencia->get_c()["id"] : null,
                "ppal_cuidador" => $this->ppal_cuidador ? $this->ppal_cuidador->get_pc()["id"] : null,
                "lista_ingresos" => $lista_ingresos
            ]; 
            return $datos;
        }
        
        /**
         * Actualiza los datos del paciente en la base de datos.
         * 
         * @return bool Resultado de la operación (true si se actualizó correctamente).
         */
        public function actualizar_paciente(){
            $actualizado = false;
            try {
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $stmt = $pdo->prepare("UPDATE datos_paciente 
                                        SET nhc = :nhc, nombre = :nombre, ape1 = :ape1, ape2 = :ape2, sexo = :sexo, edad = :edad, 
                                            medico = :medico, enfermera = :enfermera, co_morb = :co_morb, num_farm = :num_farm, 
                                            grado_ulcera = :grado_ulcera, rip_domi = :rip_domi, in_ur = :in_ur, in_fec = :in_fec, 
                                            insom = :insom, sob_cui = :sob_cui, dolor = :dolor, upp = :upp, disf = :disf, sv = :sv,
                                            sng = :sng, ocd = :ocd, id_centro_salud = :id_centro_salud, id_ayuda_social = :id_ayuda_social, 
                                            id_motivo_inc = :id_motivo_inc, id_convivencia = :id_convivencia, id_ppal_cuidador = :id_ppal_cuidador 
                                        WHERE nhc = :nhc");
                $stmt->bindParam(":nhc", $this->nhc);
                $stmt->bindParam(":nombre", $this->nombre);
                $stmt->bindParam(":ape1", $this->ape1);
                $stmt->bindParam(":ape2", $this->ape2);
                $stmt->bindParam(":sexo", $this->sexo);
                $stmt->bindParam(":edad", $this->edad);
                $stmt->bindParam(":medico", $this->medico);
                $stmt->bindParam(":enfermera", $this->enfermera);
                $stmt->bindParam(":co_morb", $this->co_morb);
                $stmt->bindParam(":num_farm", $this->num_farm);
                $stmt->bindParam(":grado_ulcera", $this->grado_ulcera);
                $stmt->bindParam(":rip_domi", $this->rip_domi);
                $stmt->bindParam(":in_ur", $this->in_ur);
                $stmt->bindParam(":in_fec", $this->in_fec);
                $stmt->bindParam(":insom", $this->insom);
                $stmt->bindParam(":sob_cui", $this->sob_cui);
                $stmt->bindParam(":dolor", $this->dolor);
                $stmt->bindParam(":upp", $this->upp);
                $stmt->bindParam(":disf", $this->disf);
                $stmt->bindParam(":sv", $this->sv);
                $stmt->bindParam(":sng", $this->sng);
                $stmt->bindParam(":ocd", $this->ocd);
                if ($this->centro_salud != null) {
                    $datos = $this->centro_salud->get_cs();
                    $centro_salud = $datos["id"];
                }
                if ($this->ayuda_social != null) {
                    $datos = $this->ayuda_social->get_as();
                    $ayuda_social = $datos["id"];
                }
                if ($this->motivo_inc != null) {
                    $datos = $this->motivo_inc->get_mi();
                    $motivo_inc = $datos["id"];
                }
                if ($this->convivencia != null) {
                    $datos = $this->convivencia->get_c();
                    $convivencia = $datos["id"];
                }
                if ($this->ppal_cuidador != null) {
                    $datos = $this->ppal_cuidador->get_pc();
                    $ppal_cuidador = $datos["id"];
                }
                $stmt->bindParam(":id_centro_salud", $centro_salud);
                $stmt->bindParam(":id_ayuda_social", $ayuda_social);
                $stmt->bindParam(":id_motivo_inc", $motivo_inc);
                $stmt->bindParam(":id_convivencia", $convivencia);
                $stmt->bindParam(":id_ppal_cuidador", $ppal_cuidador);
                $stmt->execute();
                $actualizado = true;
            }
            catch (Exception $e) {
                error_log("Error al actualizar paciente: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $actualizado;
            }
        }


        /**
         * Crea un nuevo ingreso para el paciente con los datos proporcionados.
         * 
         * @param string $fecha_ingreso Fecha de ingreso.
         * @param string $fecha_alta Fecha de alta.
         * @param mixed $reingreso Indicador de reingreso.
         * @param mixed $eco Datos de ecografía.
         * @param mixed $crf Datos CRF.
         * @param mixed $crm Datos CRM.
         * @param int $barthel Índice de Barthel.
         * @param int $pfeiffer Índice de Pfeiffer.
         * @param mixed $cultivo Resultados de cultivo.
         * @param mixed $minimental Test de MiniMental.
         * @param mixed $analitica Resultados analíticos.
         * @param int $NUM_VISIT Número de visitas.
         * @param mixed $procedencia Procedencia del ingreso (opcional).
         * @param mixed $destino Destino tras el alta (opcional).
         * @param mixed $motivo_ingreso Motivo del ingreso (opcional).
         * @param array $tratamientos Lista de tratamientos (opcional).
         * 
         * @return bool Devuelve true si el ingreso se añadió correctamente, o false si falla.
         */
        public function ingresar($fecha_ingreso, $fecha_alta, $reingreso, $eco, $crf, $crm, $barthel, $pfeiffer, $cultivo,
                                    $minimental, $analitica, $NUM_VISIT, $procedencia, $destino, $motivo_ingreso, $tratamientos){
            $ingreso = new Ingreso();
            $ingreso->cargar_datos($fecha_ingreso, $fecha_alta, $reingreso, $eco, $crf, $crm, $barthel, $pfeiffer, $cultivo,
                                        $minimental, $analitica, $NUM_VISIT, $this->nhc);
            if ($motivo_ingreso != null) {
                $ingreso->set_motivo_ingreso($motivo_ingreso);
            }
            if ($procedencia != null) {
                $ingreso->set_procedencia($procedencia);
            }
            if ($destino != null) {
                $ingreso->set_destino($destino);
            }
            if (!empty($tratamientos)){
                $ingreso->set_tratamientos($tratamientos);
            }
            if ($ingreso->aniadir_ingreso()){
                $this->lista_ingresos[] = $ingreso;
                return true;
            }
            return false;
        }
    }
?>