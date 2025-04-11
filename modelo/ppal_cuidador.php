<?php
    require_once("BBDD.php");
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
        public function get_pc(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_pc(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ppal_cuidador");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>