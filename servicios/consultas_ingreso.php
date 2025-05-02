<?php
    require_once("../modelo/BBDD.php");
    
    class Consultas_ingreso {
        function __construct (){
            $bbdd = new BBDD();
            $this->pdo = $bbdd->getPDO();
        }        
        public function get_n_ingreso() {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) AS n_ingreso 
                FROM ingreso
                WHERE fecha_ingreso BETWEEN :inicio AND :fin
            ");
        }

    }
?>