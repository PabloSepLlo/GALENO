<?php
    require_once("BBDD.php");

    /**
     * Esta clase permite cargar datos de una procedencia desde la base de datos,
     * obtener sus datos y recuperar la lista completa de procedencias.
     *
     * @author TuNombre
     * @version 1.0
     */

    class Procedencia {
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
         * Carga los datos de la procedencia desde la base de datos usando su ID.
         * 
         * @param int $id_procedencia Identificador de la procedencia.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_procedencia) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM procedencia WHERE id_procedencia=:id_procedencia");
            $stmt->bindParam(":id_procedencia", $id_procedencia);
            $stmt->execute();
            $procedencia = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $procedencia["id_procedencia"];
            $this->descripcion = $procedencia["descripcion"];
        }

        /**
         * Obtiene los datos de la procedencia en formato array.
         * 
         * @return array Array asociativo con 'id' y 'descripcion'.
         */
        public function get_pr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Obtiene todas las procedencias desde la base de datos.
         * 
         * @return array Lista de procedencias como arrays asociativos.
         */
        public static function get_datos_pr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM procedencia");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
