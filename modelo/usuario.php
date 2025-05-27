<?php
    /**
     * Esta clase permite cargar, modificar, registrar, autenticar y borrar usuarios,
     * así como cambiar la contraseña.
     * 
     * @author TuNombre
     * @version 1.0
     */

    require_once("BBDD.php");

    class Usuario {
        private ?int $id;
        private string $user_name;
        private string $nombre;
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

        /**
         * Carga los datos del usuario (sin id y administrador) y encripta la contraseña.
         *
         * @param string $user_name Nombre de usuario.
         * @param string $nombre Nombre real.
         * @param string $ape1 Primer apellido.
         * @param string $ape2 Segundo apellido.
         * @param string $pass Contraseña en texto plano.
         * @return void
         */
        public function cargar_datos($user_name, $nombre, $ape1, $ape2, $pass){
            $this->user_name = $user_name;
            $this->nombre = $nombre;
            $this->ape1 = $ape1;
            $this->ape2 = $ape2;  
            $this->pass = password_hash($pass, PASSWORD_BCRYPT);
        }

        /**
         * Carga datos para edición del usuario (incluyendo id y administrador).
         *
         * @param int $id Identificador del usuario.
         * @param string $user_name Nombre de usuario.
         * @param string $nombre Nombre real.
         * @param string $ape1 Primer apellido.
         * @param string $ape2 Segundo apellido.
         * @param string $administrador Indicador si es administrador ("SI" o "NO").
         * @return void
         */
        public function cargar_datos_para_edicion($id, $user_name, $nombre, $ape1, $ape2, $administrador){
            $this->id = $id;
            $this->user_name = $user_name;
            $this->nombre = $nombre;
            $this->ape1 = $ape1;
            $this->ape2 = $ape2;  
            $this->administrador = $administrador;  
        }

        /**
         * Carga los datos del usuario desde la base de datos usando su ID.
         *
         * @param int $id_usuario Identificador del usuario.
         * @return void
         */
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

        /**
         * Obtiene todos los usuarios de la base de datos.
         *
         * @return array Lista de usuarios.
         */
        public static function get_datos_usuarios() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Obtiene los datos del usuario actual como array asociativo.
         *
         * @return array Datos del usuario.
         */
        public function get_datos() {
            return [
                "id_usuario" => $this->id,
                "user_name" => $this->user_name,
                "nombre" => $this->nombre,
                "ape1" => $this->ape1,
                "ape2" => $this->ape2,
                "pass" => $this->pass,
                "administrador" => $this->administrador
            ]; 
        }

        /**
         * Borra el usuario de la base de datos.
         *
         * @return void
         */
        public function borrar_usuario() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario={$this->id}");
            $stmt->execute();
        }

        /**
         * Actualiza los datos del usuario en la base de datos.
         *
         * @return bool True si la actualización fue exitosa, false en caso contrario.
         */
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

        /**
         * Registra un nuevo usuario en la base de datos si no existe uno con el mismo nombre de usuario.
         *
         * @return bool True si se registró correctamente, false si el usuario ya existe o hubo un error.
         */
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

        /**
         * Autentica un usuario verificando el nombre y la contraseña.
         *
         * @param string $user_name Nombre de usuario.
         * @param string $pass Contraseña en texto plano.
         * @return bool True si la autenticación es correcta, false si falla.
         */
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

        /**
         * Cambia la contraseña del usuario si la contraseña actual es correcta.
         *
         * @param string $pass_actual Contraseña actual en texto plano.
         * @param string $nueva_pass Nueva contraseña en texto plano.
         * @return bool True si la contraseña se actualizó correctamente, false si falla.
         */
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
