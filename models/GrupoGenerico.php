<?php
    class GrupoGenerico extends Conectar{

        public function insert_grupogenerico($gg_nom, $gg_cod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_inventario.tb_grupogenerico(gg_nom, gg_cod) VALUES (?,?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_nom);
            $sql->bindValue(2, $gg_cod);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_grupogenerico($gg_id,$gg_nom, $gg_cod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_grupogenerico
                SET
                gg_nom = ?,
                gg_cod = ?
                WHERE
                    gg_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_nom);
            $sql->bindValue(2, $gg_cod);
            $sql->bindValue(3, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_clase_modal($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_clase
                            WHERE clase_est = 1
                            AND clase_id not in (select clase_id from sc_inventario.tb_grupo_clase where gg_id=? AND est=1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_gg_clase($gg_id, $clase_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.tb_grupo_clase(clase_id, gg_id, est) VALUES (?, ?, 1) RETURNING gc_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $clase_id);
            $stmt->bindValue(2, $gg_id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function delete_grupogenerico($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_grupogenerico
                SET
                gg_est = 0
                WHERE
                gg_id = ?";
            $stmt=$conectar->prepare($sql);
            $stmt->execute([$gg_id]);
        }

        public function get_grupogenerico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT *
            FROM sc_inventario.tb_grupogenerico where gg_est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_grupogenerico_bienes(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tbb.bien_id, tob.obj_nombre, tbb.fecharegistro, tbb.bien_codbarras, tbb.bien_id, tbb.bien_est, tc.clase_cod, gg.gg_cod 
            from sc_inventario.tb_bien tbb
            left  join sc_inventario.tb_objeto tob on tob.obj_id = tbb.obj_id
            left  join sc_inventario.tb_grupo_clase gc on gc.gc_id = tob.gc_id
            inner join sc_inventario.tb_clase tc on gc.clase_id = tc.clase_id
            inner join sc_inventario.tb_grupogenerico gg on gc.gg_id = gg.gg_id 
            where tbb.bien_est in ('A','N','B','R','M')";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_grupogenerico_id($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_grupogenerico WHERE gg_est = 1 AND gg_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_grupogenerico_usu($gg_id, $pers_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.td_grupogenericousu(grupogenericousu_usu, grupogenericousu_grupogenerico, gg_est) VALUES (?, ?, 1) RETURNING grupogenericousu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $gg_id);
            $stmt->execute();
        
           
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function eliminar_grupogenerico_usu($grupogenericousu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.td_grupogenericousu
                SET
                    gg_est = 0
                WHERE
                    grupogenericousu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupogenericousu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
      
        

        
    }
?>