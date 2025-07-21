<?php
    class Cuenta extends Conectar{

        public function insert_cuenta($marca_nom){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO sc_inventario.tb_cuenta_contable(cuenta_numero, cuenta_est) VALUES (?, 1);";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $marca_nom);
            $sql->execute();
        }


        public function update_cuenta($cuenta_id,$cuenta_numero){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_cuenta_contable
                SET
                cuenta_numero = ?
                WHERE
                    cuenta_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cuenta_numero);
            $sql->bindValue(2, $cuenta_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_cuenta($cuenta_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_cuenta_contable
                SET
                cuenta_est = 0
                WHERE
                cuenta_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cuenta_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_cuenta(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT cuenta_id, cuenta_numero, cuenta_est
            FROM sc_inventario.tb_cuenta_contable where cuenta_est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_cuenta_id($cuenta_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_cuenta_contable WHERE cuenta_est = 1 AND cuenta_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cuenta_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
    }
?>