<?php
    session_start();
    class Conectar {
        protected $dbh;
        protected function Conexion() {
            try {
                $conectar = $this->dbh = new PDO("pgsql:host=localhost;port=5432;dbname=dbsimcix", "soporte", "123456");
                return $conectar;
            } catch (PDOException $e) {
                error_log("¡Error BD!: " . $e->getMessage());
                die("No se pudo conectar a la base de datos.");
            }
        }
        public function set_names() {
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        public static function ruta() {
            return "http://localhost:/SISINV2/";
        }
         
    }
    
?>


