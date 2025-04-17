<?php
    require_once("centro_salud.php");
    require_once("ayuda_social.php");
    require_once("convivencia.php");
    require_once("motivo_inc.php");
    require_once("ppal_cuidador.php");
    require_once("BBDD.php");

    class Paciente {
        private int $nhc;
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
        public function cargar_datos($nhc, $nombre, $ape1, $ape2, $sexo, $edad, $medico, $enfermera, $co_morb, $num_farm, $grado_ulcera,
                                                $rip_domi, $in_ur, $in_fec, $insom, $sob_cui, $dolor, $upp, $disf, $sv, $sng, $ocd){
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
        public function set_centro_salud(int $id_centro_salud) {
            $centro_salud = new Centro_salud();
            $centro_salud->cargar_datos_desde_BBDD($id_centro_salud);
            $this->centro_salud = $centro_salud;
        }
        public function set_motivo_inc(Motivo_inc $motivo_inc) {
            $this->motivo_inc = $motivo_inc;
        }
        public function set_ayuda_social(Ayuda_social $ayuda_social) {
            $this->ayuda_social = $ayuda_social;
        }
        public function set_convivencia(Convivencia $convivencia) {
            $this->convivencia = $convivencia;
        }
        public function set_ppal_cuidador(Ppal_cuidador $ppal_cuidador) {
            $this->ppal_cuidador = $ppal_cuidador;
        }

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
                $_SESSION["err"]=$e->getMessage();
            }
            finally {
                unset($bd);
                return $aniadido;
            }
        }
        
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
                $this->motivo_inc = $paciente["motivo_inc"];
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
                $existe = true;
            }
            return $existe;
        }

        public function get_datos() {
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
                "centro_salud" => $this->centro_salud ? $centro_salud : null,
                "motivo_inc" => $this->motivo_inc ? $motivo_inc : null,
                "ayuda_social" => $this->ayuda_social ? $ayuda_social : null,
                "convivencia" => $this->convivencia ? $convivencia : null,
                "ppal_cuidador" => $this->ppal_cuidador ? $ppal_cuidador : null
            ]; 
            return $datos;
        }
        
        public function borrar_usuario() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario={$this->id}");
            $stmt->execute();
        }
        
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
                $_SESSION["msg"]=$e->getMessage();
            }
            finally {
                unset($bd);
                return $actualizado;
            }
        }
    }
?>