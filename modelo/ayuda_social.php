<?php
    require_once("BBDD.php");
    class Ayuda_social {
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
        public function cargar_datos_desde_BBDD($id_ayuda_social) {
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ayuda_social WHERE id_ayuda_social=:id_ayuda_social");
            $stmt->bindParam(":id_ayuda_social", $id_ayuda_social);
            $stmt->execute();
            $ayuda_social = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $ayuda_social["id_ayuda_social"];
            $this->descripcion = $ayuda_social["descripcion"];
        }
        public function get_as(){
            return [
                "id" => $this->id,
                "descripcion" => $this->descripcion,
            ];
        }
        public static function get_datos_as(){
            $bd = new BBDD();
            $pdo = $bd->getPDO();
            $stmt = $pdo->prepare("SELECT * FROM ayuda_social");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>