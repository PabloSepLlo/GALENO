<?php
    require_once("BBDD.php");
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
        public function get_tr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_tr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM tratamiento");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>