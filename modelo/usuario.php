<?php
    require_once("BBDD.php");
    class Usuario {
        private ?int $id;
        private string $user_name;
        public string $nombre;
        private string $ape1;
        private string $ape2;
        private string $pass;
        private string $administrador;

        public function __construct() {
            $this->id = null;
            $this->user_name = "";
            $this->nombre = "";
            $this->ape1 = "";
            $this->ape2 = "";  
            $this->pass = "";
            $this->administrador = "NO";
        }
        public function __destruct() {
            $this->id = null;
            $this->user_name = "";
            $this->nombre = "";
            $this->ape1 = "";
            $this->ape2 = "";  
            $this->pass = "";
            $this->administrador = "";
        }
        public function cargar_datos($user_name, $nombre, $ape1, $ape2, $pass){
            $this->user_name = $user_name;
            $this->nombre = $nombre;
            $this->ape1 = $ape1;
            $this->ape2 = $ape2;  
            $this->pass = password_hash($pass, PASSWORD_BCRYPT);
        }

        public function cargar_datos_para_edicion($id, $user_name, $nombre, $ape1, $ape2, $administrador){
            $this->id = $id;
            $this->user_name = $user_name;
            $this->nombre = $nombre;
            $this->ape1 = $ape1;
            $this->ape2 = $ape2;  
            $this->administrador = $administrador;  
        }

        public function cargar_datos_desde_BBDD($id_usuario) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario=:id_usuario");
            $stmt->bindParam(":id_usuario", $id_usuario);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $usuario["id_usuario"];
            $this->user_name = $usuario["nombre_usuario"];
            $this->nombre = $usuario["nombre"];
            $this->ape1 = $usuario["ape1"];
            $this->ape2 = $usuario["ape2"];  
            $this->pass = $usuario["pass"];
            $this->administrador = $usuario["administrador"];
        }

        public static function get_datos_usuarios() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_datos() {
            $datos = [
                "id_usuario" => $this->id,
                "user_name" => $this->user_name,
                "nombre" => $this->nombre,
                "ape1" => $this->ape1,
                "ape2" => $this->ape2,
                "pass" => $this->pass,
                "administrador" => $this->administrador
            ]; 
            return $datos;
        }
        public function borrar_usuario() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario={$this->id}");
            $stmt->execute();
        }
        
        public function actualizar_usuario(){
            $actualizado = false;
            try {
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $stmt = $pdo->prepare("UPDATE usuario 
                                        SET nombre_usuario=:user_name, nombre=:nombre, ape1=:ape1, ape2=:ape2, administrador=:administrador
                                        WHERE id_usuario=:id_usuario");
                $stmt->bindParam(":user_name", $this->user_name);
                $stmt->bindParam(":nombre", $this->nombre);
                $stmt->bindParam(":ape1", $this->ape1);
                $stmt->bindParam(":ape2", $this->ape2);
                $stmt->bindParam(":administrador", $this->administrador);
                $stmt->bindParam(":id_usuario", $this->id);
                $stmt->execute();
                $actualizado = true;
            }
            catch (Exception $e) {
                error_log("Error al actualizar usuario: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $actualizado;
            }
        }

        public function registrar_usuario() {
            $registrado = false;
            try {
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $stmt = $pdo->prepare("SELECT * FROM usuario;");
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
                $repetido = false;
                while ($usuario = $stmt->fetch() && !$repetido) {
                    if ($usuario["nombre_usuario"] == $this->user_name) {
                        $repetido = true;
                    }
                }
                if (!$repetido) {
                    $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, nombre, ape1, ape2, pass, administrador)
                            VALUES (:nombre_usuario, :nombre, :ape1, :ape2, :pass, :administrador);");
                    $stmt->bindParam(":nombre_usuario", $this->user_name);
                    $stmt->bindParam(":nombre", $this->nombre);
                    $stmt->bindParam(":ape1", $this->ape1);
                    $stmt->bindParam(":ape2", $this->ape2);
                    $stmt->bindParam(":pass", $this->pass);
                    $stmt->bindParam(":administrador", $this->administrador);
                    $stmt->execute();
                    $registrado = true;
                }
            }
            catch (Exception $e) {
                error_log("Error al registrar usuario: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $registrado;
            }
        }
        public function autenticar(string $user_name, string $pass) {
            try {
                $autenticado = false;
                $bd = new BBDD();
                $pdo = $bd->getPDO();
                $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre_usuario=:user_name");
                $stmt->bindParam(":user_name", $user_name);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($pass, $usuario["pass"])) {
                    $this->id = $usuario["id_usuario"];
                    $this->user_name = $usuario["nombre_usuario"];
                    $this->nombre = $usuario["nombre"];
                    $this->ape1 = $usuario["ape1"];
                    $this->ape2 = $usuario["ape2"];  
                    $this->pass = $usuario["pass"];
                    $this->administrador = $usuario["administrador"];
                    $autenticado = true;
                }
            }
            catch (Exception $e) {
                error_log("Error al iniciar sesion: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $autenticado;
            }
        }

        public function cambiar_password(string $pass_actual, string $nueva_pass) {
            $actualizada = false;
            try {
                if (password_verify($pass_actual, $this->pass)) {
                    $bd = new BBDD();
                    $pdo = $bd->getPDO();
                    $stmt = $pdo->prepare("UPDATE usuario 
                                            SET pass=:pass
                                            WHERE id_usuario=:id_usuario");
                    $stmt->bindParam(":id_usuario", $this->id);
                    $pass_hasheada = password_hash($nueva_pass, PASSWORD_BCRYPT);
                    $stmt->bindParam(":pass", $pass_hasheada);
                    $stmt->execute();
                    $actualizada = true;
                }
            }
            catch (Exception $e) {
                error_log("Error al cambiar contraseña: " . $e->getMessage(), 3, "../logs/error_log.txt");
            }
            finally {
                unset($bd);
                return $actualizada;
            }
        }
    }
?>