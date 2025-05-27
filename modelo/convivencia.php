<?php
    require_once("BBDD.php");

    /**
     * Clase Convivencia
     * 
     * Gestiona los datos asociados a tipos de convivencia.
     * Permite cargar información individual y obtener todos los registros desde la base de datos.
     * 
     * @author Pablo
     * @version 1.0
     */
    class Convivencia {

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
         * Carga los datos de una convivencia específica desde la base de datos.
         *
         * @param int $id_convivencia ID de la convivencia a cargar.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_convivencia) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM convivencia WHERE id_convivencia=:id_convivencia");
            $stmt->bindParam(":id_convivencia", $id_convivencia);
            $stmt->execute();
            $convivencia = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $convivencia["id_convivencia"];
            $this->descripcion = $convivencia["descripcion"];
        }

        /**
         * Devuelve los datos de la convivencia como un array asociativo.
         *
         * @return array Datos de la convivencia (id y descripción).
         */
        public function get_c() {
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Obtiene todos los registros de convivencia desde la base de datos.
         *
         * @return array Lista de tipos de convivencia.
         */
        public static function get_datos_c() {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM convivencia");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
