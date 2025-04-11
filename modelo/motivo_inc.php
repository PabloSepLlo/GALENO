<?php
    require_once("BBDD.php");
    class Motivo_inc {
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
        public function cargar_datos_desde_BBDD($id_motivo_inc) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_inc WHERE id_motivo_inc=:id_motivo_inc");
            $stmt->bindParam(":id_motivo_inc", $id_motivo_inc);
            $stmt->execute();
            $motivo_inc = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $motivo_inc["id_motivo_inc"];
            $this->descripcion = $motivo_inc["descripcion"];
        }
        public function get_mi(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_mi(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_inc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>