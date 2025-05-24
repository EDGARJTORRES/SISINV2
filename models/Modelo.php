<?php
    class Modelo extends Conectar{

        public function insert_marca($marca_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_inventario.tb_marca(marca_nom) VALUES (?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $marca_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_modelo($modelo_id,$modelo_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_modelo
                SET
                modelo_nom = ?
                WHERE
                    modelo_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $modelo_nom);
            $sql->bindValue(2, $modelo_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_modelo($modelo_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_modelo
                SET
                modelo_est = 0
                WHERE
                modelo_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $modelo_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_modelo(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                m.modelo_id, 
                m.modelo_nom, 
                m.modelo_est, 
                m.marca_id,
                ma.marca_nom
            FROM sc_inventario.tb_modelo m
            INNER JOIN sc_inventario.tb_marca ma ON m.marca_id = ma.marca_id
            WHERE m.modelo_est = 1;";
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