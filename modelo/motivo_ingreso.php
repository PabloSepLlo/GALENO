<?php
    require_once("BBDD.php");

    /**
     * Clase que representa un motivo de ingreso con sus propiedades y métodos
     * para cargar datos desde la base de datos y obtenerlos.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Motivo_ingreso {
        private int $id;
        private string $descripcion;

        function __construct(){
            $this->id = 0;
            $this->descripcion = "";
        }

        function __destruct(){
            $this->id = 0;
            $this->descripcion = "";
        }

        /**
         * Carga los datos del motivo de ingreso desde la base de datos usando su ID.
         *
         * @param int $id_motivo_ingreso ID del motivo de ingreso.
         */
        public function cargar_datos_desde_BBDD($id_motivo_ingreso) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_ingreso WHERE id_motivo_ingreso=:id_motivo_ingreso");
            $stmt->bindParam(":id_motivo_ingreso", $id_motivo_ingreso);
            $stmt->execute();
            $motivo_ingreso = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $motivo_ingreso["id_motivo_ingreso"];
            $this->descripcion = $motivo_ingreso["descripcion"];
        }

        /**
         * Devuelve un array asociativo con los datos del motivo de ingreso.
         *
         * @return array Datos con claves "id" y "descripcion".
         */
        public function get_migr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Método estático que devuelve todos los motivos de ingreso de la base de datos.
         *
         * @return array Lista de motivos de ingreso como arrays asociativos.
         */
        public static function get_datos_migr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_ingreso");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
