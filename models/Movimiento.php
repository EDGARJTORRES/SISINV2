<?php
    class Movimiento extends Conectar{

        public function insert_movimiento($mov_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_inventario.tb_movimiento(mov_nom,mov_est) VALUES (?,1);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $mov_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_movimiento($mov_id,$mov_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_movimiento
                SET
                    mov_nom = ?
                WHERE
                    mov_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $mov_nom);
            $sql->bindValue(2, $mov_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_movimiento($mov_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_movimiento
                SET
                    mov_est = 0
                WHERE
                    mov_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $mov_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_movimiento(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_movimiento WHERE mov_est = 1 order by mov_id asc";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_movimiento_id($mov_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_movimiento WHERE mov_est = 1 AND mov_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $mov_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_movimiento_usu($movimiento_id, $pers_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.td_movimientousu(movimientousu_usu, movimientousu_movimiento, mov_est) VALUES (?, ?, 1) RETURNING movimientousu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $movimiento_id);
            $stmt->execute();
        
           
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function eliminar_movimiento_usu($movimientousu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.td_movimientousu
                SET
                    mov_est = 0
                WHERE
                    movimientousu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $movimientousu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
      
        

        
    }
?>