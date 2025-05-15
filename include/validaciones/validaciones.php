<?php
    class Validaciones {
        /**
         * Valida NHC (string numérico de 6-7 dígitos)
         * @param string $nhc
         * @return bool
         */
        public static function validar_NHC(?string $nhc) {
            return preg_match('/^[0-9]{6,8}$/', $nhc);
        }
    }
?>