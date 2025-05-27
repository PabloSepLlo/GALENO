<?php
    require_once("BBDD.php");

    /**
     * Clase Destino
     * 
     * Gestiona los datos relacionados con los destinos de ingreso o derivación del paciente.
     * Permite cargar un destino específico o recuperar todos los registros almacenados.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Destino {

        private int $id;
        private string $descripcion;

        function __construct() {
            $this->id = 0;
            $this->descripcion = "";
        }

        function __destruct() {
            $this->id = 0;
            $this->descripcion = "";
        }

        /**
         * Carga los datos de un destino específico desde la base de datos.
         *
         * @param int $id_destino ID del destino a cargar.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_destino) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM destino WHERE id_destino=:id_destino");
            $stmt->bindParam(":id_destino", $id_destino);
            $stmt->execute();
            $destino = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $destino["id_destino"];
            $this->descripcion = $destino["descripcion"];
        }

        /**
         * Devuelve los datos del destino como un array asociativo.
         *
         * @return array Datos del destino (id y descripción).
         */
        public function get_de() {
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Obtiene todos los registros de destino desde la base de datos.
         *
         * @return array Lista de destinos registrados.
         */
        public static function get_datos_de() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM destino");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
