<?php
    class Dependencia extends Conectar{
        public function insert_registro_objeto($fecharegistro, $depe_id,$obj_id, $marca_id, $objdepe_numserie, $objdepe_codbarras){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO sc_inventario.tb_objeto_dependencia(
                fecharegistro, depe_id, obj_id, marca_id, objdepe_numserie, objdepe_codbarras)
                    VALUES (?, ?, ?, ?, ?, ?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $fecharegistro);
            $sql->bindValue(2, $depe_id);
            $sql->bindValue(3, $obj_id);
            $sql->bindValue(4, $marca_id);
            $sql->bindValue(5, $objdepe_numserie);
            $sql->bindValue(6, $objdepe_codbarras);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_registro_objeto($objdepe_id,  $fecharegistro, $depe_id,$obj_id, $marca_id, $objdepe_numserie, $objdepe_codbarras){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_objeto_dependencia
                SET
                fecharegistro = ?,
                depe_id = ?, 
                obj_id = ?,
                marca_id = ? ,
                objdepe_numserie = ? ,
                objdepe_codbarras = ?
                WHERE
                    objdepe_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $fecharegistro);
            $sql->bindValue(2, $depe_id);
            $sql->bindValue(3, $obj_id);
            $sql->bindValue(4, $marca_id);
            $sql->bindValue(5, $objdepe_numserie);
            $sql->bindValue(6, $objdepe_codbarras);
            $sql->bindValue(7, $objdepe_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_dependencia($bien_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_bien
                SET
                    bien_est = 0
                WHERE
                bien_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $bien_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_dependencia_datos(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT td.depe_id, td.depe_denominacion || ' - ' || tblm.lomu_denominacion AS denominacion_concatenada
            FROM tb_dependencia td
            INNER JOIN sc_escalafon.tb_local_municipal tblm ON td.lomu_id = tblm.lomu_id
			where td.nior_id in(1,2,3,4,5)
            ORDER BY td.depe_denominacion DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_dependencia_tipo_mov($mov_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT td.depe_id, td.depe_denominacion, count(obv.mov_id)
            FROM sc_inventario.tb_objeto_mov obv
            inner join sc_inventario.tb_objeto_dependencia obd on obv.objdepe_id = obd.objdepe_id
			inner join public.tb_dependencia td on td.depe_id = obd.depe_id
            where obv.mov_id = ? and obv.est = 1
            group by td.depe_denominacion, td.depe_id";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $mov_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
     
        public function get_dependencia_objetos($depe_id,$gc_id){
            $conectar= parent::conexion();
            parent::set_names();

            if($gc_id === '0'){
                $sql="SELECT * from sc_inventario.tb_objeto_dependencia obd
                inner join public.tb_dependencia td on td.depe_id = obd.depe_id
                left join sc_inventario.tb_objeto tob on obd.obj_id = tob.obj_id
                where td.depe_id = ?";
                 $sql=$conectar->prepare($sql);
                 $sql->bindValue(1, $depe_id);
                 $sql->execute();
                
            }else{
                $sql="SELECT * from sc_inventario.tb_objeto_dependencia obd
                inner join public.tb_dependencia td on td.depe_id = obd.depe_id
                left join sc_inventario.tb_objeto tob on obd.obj_id = tob.obj_id
                where td.depe_id = ? and tob.gc_id =?";
                 $sql=$conectar->prepare($sql);
                 $sql->bindValue(1, $depe_id);
                 $sql->bindValue(2, $gc_id);
                 $sql->execute();
            }
           
            return $resultado=$sql->fetchAll();
        }

       
        public function get_dependencia_objetos_id($objdepe_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * from sc_inventario.tb_objeto_dependencia obd
            inner join public.tb_dependencia td on td.depe_id = obd.depe_id
			inner join sc_inventario.tb_objeto tob on obd.obj_id = tob.obj_id
			where obd.objdepe_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $objdepe_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_dependencia_usu($dependencia_id, $pers_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.td_dependenciausu(dependenciausu_usu, dependenciausu_dependencia, est) VALUES (?, ?, 1) RETURNING dependenciausu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $dependencia_id);
            $stmt->execute();
        
           
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function contadorObjetosPorDependencia() {
            $conectar = parent::conexion();
            $sql = "
                SELECT
                    d.depe_denominacion,
                    COUNT(bd.biendepe_id) AS cantidad
                FROM
                    sc_inventario.tb_bien_dependencia bd
                JOIN
                    public.tb_dependencia d ON bd.depe_id = d.depe_id
                GROUP BY
                    d.depe_denominacion
                ORDER BY
                    cantidad DESC
            ";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>