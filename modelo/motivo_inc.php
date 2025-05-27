<?php
    require_once("BBDD.php");

    /**
     * Clase que representa un motivo de incapacidad(Motivo_inc), con sus datos básicos
     * y métodos para cargar datos desde la base de datos y obtenerlos.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Motivo_inc {
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
         * Carga los datos del motivo de incapacidad desde la base de datos usando su ID.
         *
         * @param int $id_motivo_inc ID del motivo de incapacidad.
         */
        public function cargar_datos_desde_BBDD($id_motivo_inc) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_inc WHERE id_motivo_inc=:id_motivo_inc");
            $stmt->bindParam(":id_motivo_inc", $id_motivo_inc);
            $stmt->execute();
            $motivo_inc = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $motivo_inc["id_motivo_inc"];
            $this->descripcion = $motivo_inc["descripcion"];
        }

        /**
         * Devuelve un array asociativo con los datos del motivo de incapacidad.
         *
         * @return array Datos con claves "id" y "descripcion".
         */
        public function get_mi(){
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
        public static function get_datos_mi(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_inc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
