<?php
    require_once("BBDD.php");

    /**
     * Clase Centro_salud
     * 
     * Gestiona los datos relacionados con un centro de salud.
     * Permite cargar información individual o listar todos los centros disponibles en la base de datos.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Centro_salud {

        private int $id;
        private string $codigo_centro;

        function __construct() {
            $this->id = 0;
            $this->codigo_centro = "";
        }

        function __destruct() {
            $this->id = 0;
            $this->codigo_centro = "";
        }

        /**
         * Carga los datos de un centro de salud específico desde la base de datos.
         *
         * @param int $id_centro_salud ID del centro de salud a cargar.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_centro_salud) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM centro_salud WHERE id_centro_salud=:id_centro_salud");
            $stmt->bindParam(":id_centro_salud", $id_centro_salud);
            $stmt->execute();
            $centro_salud = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $centro_salud["id_centro_salud"];
            $this->codigo_centro = $centro_salud["codigo_centro"];
        }

        /**
         * Devuelve los datos del centro de salud en forma de array asociativo.
         *
         * @return array Datos del centro de salud.
         */
        public function get_cs() {
            return [
                "id" => $this->id,
                "codigo_centro" => $this->codigo_centro,
            ];
        }

        /**
         * Obtiene una lista de todos los centros de salud registrados.
         *
         * @return array Lista completa de centros de salud.
         */
        public static function get_datos_cs() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM centro_salud");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
