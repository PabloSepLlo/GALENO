<?php
    require_once("BBDD.php");
    class Convivencia {
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
        public function get_c(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_c(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM convivencia");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>