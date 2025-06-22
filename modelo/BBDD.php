<?php
    class BBDD {
        private ?PDO $pdo;
        function __construct(){
            $server = "localhost";
            $user = "root";
            $pass = "";
            $dsn = "mysql:host=$server;dbname=base_pacientes";
            try {
                $this->pdo = new PDO($dsn, $user, $pass);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
                exit();
            }
        }
        function __destruct(){
            $this->pdo = null;
        }
        public function getPDO(){
            return $this->pdo;
        }
    }
?>