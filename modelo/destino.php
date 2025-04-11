<?php
    require_once("BBDD.php");
    class Destino {
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
        public function cargar_datos_desde_BBDD($id_destino) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM destino WHERE id_destino=:id_destino");
            $stmt->bindParam(":id_destino", $id_destino);
            $stmt->execute();
            $destino = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $destino["id_destino"];
            $this->descripcion = $destino["descripcion"];
        }
        public function get_de(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_de(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM destino");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>