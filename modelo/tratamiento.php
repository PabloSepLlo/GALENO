<?php
    require_once("BBDD.php");
    /**
     *
     * Esta clase permite cargar datos de un tratamiento desde la base de datos,
     * obtener sus datos y recuperar la lista completa de tratamientos.
     * 
     * @author TuNombre
     * @version 1.0
     */

    class Tratamiento {
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
         * Carga los datos del tratamiento desde la base de datos usando su ID.
         * 
         * @param int $id_tratamiento Identificador del tratamiento.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_tratamiento) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM tratamiento WHERE id_tratamiento=:id_tratamiento");
            $stmt->bindParam(":id_tratamiento", $id_tratamiento);
            $stmt->execute();
            $tratamiento = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $tratamiento["id_tratamiento"];
            $this->descripcion = $tratamiento["descripcion"];
        }

        /**
         * Obtiene los datos del tratamiento en formato array.
         * 
         * @return array Array asociativo con 'id' y 'descripcion'.
         */
        public function get_tr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Obtiene todos los tratamientos desde la base de datos.
         * 
         * @return array Lista de tratamientos como arrays asociativos.
         */
        public static function get_datos_tr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM tratamiento");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
