<?php
    require_once 'Consultas_paciente.php';


    class InformeService {

        function __construct() {
            $this->consultas = new Consultas_paciente();
        }

        public function generar_informe($fecha_inicio, $fecha_fin) {
            
        }
    }
?>