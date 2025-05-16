<?php
    class Marca extends Conectar{

        public function insert_marca($marca_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_inventario.tb_marca(marca_nom) VALUES (?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marca_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_marca($marca_id,$marca_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_marca
                SET
                marca_nom = ?
                WHERE
                    marca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marca_nom);
            $sql->bindValue(2, $marca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_marca($marca_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_marca
                SET
                marca_est = 0
                WHERE
                marca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_marca(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT marca_id, marca_nom, marca_est
            FROM sc_inventario.tb_marca where marca_est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_marca_id($marca_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_marca WHERE marca_est = 1 AND marca_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marca_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_marca_usu($marca_id, $pers_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.td_marcausu(marcausu_usu, marcausu_marca, marca_est) VALUES (?, ?, 1) RETURNING marcausu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $marca_id);
            $stmt->execute();
        
           
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function eliminar_marca_usu($marcausu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.td_marcausu
                SET
                    marca_est = 0
                WHERE
                    marcausu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marcausu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
      
        

        
    }
?>