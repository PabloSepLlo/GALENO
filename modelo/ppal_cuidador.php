<?php
    require_once("BBDD.php");
    /**
     *
     * Esta clase permite cargar datos de un cuidador principal desde la base de datos,
     * obtener sus datos y recuperar la lista completa de cuidadores.
     *
     * @author TuNombre
     * @version 1.0
     */
    class Ppal_cuidador {
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
         * Carga los datos del cuidador principal desde la base de datos usando su ID.
         * 
         * @param int $id_ppal_cuidador Identificador del cuidador principal.
         * @return void
         */
        public function cargar_datos_desde_BBDD($id_ppal_cuidador) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ppal_cuidador WHERE id_ppal_cuidador=:id_ppal_cuidador");
            $stmt->bindParam(":id_ppal_cuidador", $id_ppal_cuidador);
            $stmt->execute();
            $ppal_cuidador = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $ppal_cuidador["id_ppal_cuidador"];
            $this->descripcion = $ppal_cuidador["descripcion"];
        }

        /**
         * Obtiene los datos del cuidador principal en formato array.
         * 
         * @return array Array asociativo con 'id' y 'descripcion'.
         */
        public function get_pc(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }

        /**
         * Obtiene todos los cuidadores principales desde la base de datos.
         * 
         * @return array Lista de cuidadores principales como arrays asociativos.
         */
        public static function get_datos_pc(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ppal_cuidador");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
