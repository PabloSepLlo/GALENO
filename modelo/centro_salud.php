<?php
    require_once("BBDD.php");
    class Centro_salud {
        private int $id;
        private string $codigo_centro;

        function __construct(){
            $this->id = 0;
            $this->codigo_centro = "";
        }
        function __destruct(){
            $this->id = 0;
            $this->codigo_centro = "";
        }
        public function cargar_datos_desde_BBDD($id_centro_salud) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM centro_salud WHERE id_centro_salud=:id_centro_salud");
            $stmt->bindParam(":id_centro_salud", $id_centro_salud);
            $stmt->execute();
            $centro_salud = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $centro_salud["id_centro_salud"];
            $this->codigo_centro = $centro_salud["codigo_centro"];
        }
        public function get_cs(){
            return [
                "id" => $this->id,
                "codigo_centro" => $this->codigo_centro,
            ];
        }
        public static function get_datos_cs(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM centro_salud");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>