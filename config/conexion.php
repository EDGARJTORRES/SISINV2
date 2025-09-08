<?php
    session_start();
    class Conectar {
        /* 
        protected $dbh;
        protected function conexion() {
            try {
                $conectar = $this->dbh = new PDO("pgsql:host=10.10.10.16;dbname=db_simcix", "postgres", "Mpch*2023*");
                $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conectar->exec("SET NAMES 'utf8'");
                return $conectar;
            } catch (Exception $e) {
                print "¡Error BD!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        public function set_names() {
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        public static function ruta() {
        return "http://10.10.10.16/SISINV2/";
        }
        */ 
        
        protected $dbh;
        protected function conexion() {
            try {
                $this->dbh = new PDO("pgsql:host=10.10.10.16;port=5432;dbname=db_simcix", "postgres", "Mpch*2023*");
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->dbh->exec("SET NAMES 'utf8'");
                return $this->dbh;
            } catch (PDOException $e) {
                error_log("¡Error BD!: " . $e->getMessage());
                die("No se pudo conectar a la base de datos.");
            }
        }
        public function set_names() {
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        public static function ruta() {
            return "http://localhost/SISINV2/";
        }
         
        
        /* 
        Protected $dbh;
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
        */ 
        
    }
    
?>


