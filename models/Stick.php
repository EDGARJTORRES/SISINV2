<?php
    class Stick extends Conectar {
        public function get_nro_imprimir($bien_id) {
            try {
                $conectar = parent::conexion();
                parent::set_names();
                $sql = "SELECT 
                            b.bien_codbarras,
                            o.obj_nombre 
                        FROM sc_inventario.tb_bien b 
                        LEFT JOIN sc_inventario.tb_objeto o ON o.obj_id = b.obj_id
                        where bien_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $bien_id);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Error en la consulta: " . $e->getMessage();
                return null; 
            }
        }
        public function get_nro_patrimonial($obj_id) {
            try {
                $conectar = parent::conexion();
                parent::set_names();
                $sql = "SELECT codigo_cana FROM sc_inventario.tb_objeto  where obj_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $obj_id);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Error en la consulta: " . $e->getMessage();
                return null; 
            }
        }
        public function get_last_id() {
            try {
                $conectar = parent::conexion();
                parent::set_names();
                $sql = "SELECT * FROM sc_inventario.tb_objeto_dependencia  order by objdepe_id desc limit 1";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Error en la consulta: " . $e->getMessage();
                return null; 
            }
        }
        public function get_nros_imprimir_grupo($depe_id) {
            try {
                $conectar = parent::conexion();
                parent::set_names();
                $sql = "SELECT objdepe_codbarras FROM sc_inventario.tb_objeto_dependencia  tod
                inner join sc_inventario.tb_dependencia_ubicacion tdu on tdu.depeubi_id = tod.depeubi_id
               inner join public.tb_dependencia td on td.depe_id = tdu.depe_id
               where depe_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $depe_id);
                $stmt->execute();
                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo "Error en la consulta: " . $e->getMessage();
                return null; 
            }
        }

    }
    
?>