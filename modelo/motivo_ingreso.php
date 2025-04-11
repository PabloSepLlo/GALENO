<?php
    require_once("BBDD.php");
    class Motivo_ingreso {
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
        public function cargar_datos_desde_BBDD($id_motivo_ingreso) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_ingreso WHERE id_motivo_ingreso=:id_motivo_ingreso");
            $stmt->bindParam(":id_motivo_ingreso", $id_motivo_ingreso);
            $stmt->execute();
            $motivo_ingreso = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $motivo_ingreso["id_motivo_ingreso"];
            $this->descripcion = $motivo_ingreso["descripcion"];
        }
        public function get_migr(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_migr(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM motivo_ingreso");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>