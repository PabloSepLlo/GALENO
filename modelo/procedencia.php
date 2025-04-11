<?php
    require_once("BBDD.php");
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
        public function get_pr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_pr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM procedencia");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>