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
        public static function validar_pass(string $password): bool {
            if (strlen($password) < 8) {
                return false;
            }
            if (!preg_match('/[A-Z]/', $password)) {
                return false;
            }
            if (!preg_match('/[a-z]/', $password)) {
                return false;
            }
            if (!preg_match('/[0-9]/', $password)) {
                return false;
            }
            if (!preg_match('/[\W_]/', $password)) {
                return false;
            }
            return true;
        }
    }
?>