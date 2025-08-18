<?php
class Objeto extends Conectar
    {
    public function insert_objeto($obj_nombre, $codigo_cana, $gc_id)
        {
            $conectar = parent::conexion();
            parent::set_names();

            // Buscar si el código ya existe
            $codigo_existente = $this->buscar_cod_cana($codigo_cana);

            if (empty($codigo_existente)) { // Si no se encuentra el código
                $sql = "INSERT INTO sc_inventario.tb_objeto(obj_nombre, codigo_cana, gc_id, est) VALUES (?,?,?,1);";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $obj_nombre);
                $sql->bindValue(2, $codigo_cana);
                $sql->bindValue(3, $gc_id);
                $sql->execute();
                return true; // Indicar que la inserción fue exitosa
            } else {
                return false; // Indicar que el código ya existe
            }
        }


    public function update_objeto($obj_id, $obj_nombre, $codigo_cana)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $codigo_existente = $this->buscar_cod_cana($codigo_cana);
            $objeto_actual = $this->get_objeto_id($obj_id);
            if ($objeto_actual['codigo_cana'] == $codigo_cana || empty($codigo_existente)) {
                $sql = "UPDATE sc_inventario.tb_objeto
                            SET
                            obj_nombre = ?,
                            codigo_cana = ?
                            WHERE
                                obj_id = ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $obj_nombre);
                $sql->bindValue(2, $codigo_cana);
                $sql->bindValue(3, $obj_id);
                $sql->execute();
                return true; 
            } else {
                return false;
            }
        }

    public function insert_registro_bien($fecharegistro, $obj_id, $modelo_id, $bien_numserie, $bien_codbarras, $bien_color, $bien_dim, $procedencia, $val_adq, $doc_adq, $bien_obs, $bien_cuenta) {
        $conectar = parent::conexion();
                    parent::set_names();
        $sql = "INSERT INTO sc_inventario.tb_bien(
                fecharegistro, 
                obj_id, 
                modelo_id, 
                bien_numserie, 
                bien_codbarras, 
                bien_color, 
                bien_dim,
                procedencia,
                val_adq, 
                doc_adq, 
                bien_obs,
                bien_cuenta
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $fecharegistro, PDO::PARAM_STR);
            $stmt->bindValue(2, $obj_id);
            $stmt->bindValue(3, $modelo_id);
            $stmt->bindValue(4, $bien_numserie, PDO::PARAM_STR);
            $stmt->bindValue(5, $bien_codbarras, PDO::PARAM_STR);
            $stmt->bindValue(6, $bien_color, PDO::PARAM_STR);
            $stmt->bindValue(7, $bien_dim, PDO::PARAM_STR);
            $stmt->bindValue(8, $procedencia, PDO::PARAM_STR);
            $stmt->bindValue(9, $val_adq);        
            $stmt->bindValue(10, $doc_adq, PDO::PARAM_STR);
            $stmt->bindValue(11, $bien_obs, PDO::PARAM_STR);
            $stmt->bindValue(12, $bien_cuenta, PDO::PARAM_STR);
            $stmt->execute();
            $bien_id = $conectar->lastInsertId();
            $sqlDetalle = "INSERT INTO sc_inventario.tb_bien_detalle (bien_id) VALUES (?)";
            $stmtDetalle = $conectar->prepare($sqlDetalle);
            $stmtDetalle->bindValue(1, $bien_id, PDO::PARAM_INT);
            $stmtDetalle->execute();
            return $bien_id;
        }
    public function update_registro_bien(
        $bien_id,
        $fecharegistro,
        $obj_id,
        $modelo_id,
        $bien_numserie,
        $bien_codbarras,
        $bien_color,
        $bien_dim,
        $val_adq,
        $doc_adq,
        $bien_obs,
        $bien_cuenta,
        $procedencia
       ) {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE sc_inventario.tb_bien SET
                    fecharegistro = ?,
                    obj_id = ?, 
                    modelo_id = ?,
                    bien_numserie = ?,
                    bien_codbarras = ?,
                    bien_color = ?,
                    bien_dim = ?,
                    val_adq = ?,
                    doc_adq = ?,
                    bien_obs = ?,
                    bien_cuenta = ?,
                    procedencia = ?
                WHERE bien_id = ?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecharegistro, PDO::PARAM_STR);
        $sql->bindValue(2, $obj_id, PDO::PARAM_INT);
        $sql->bindValue(3, $modelo_id, PDO::PARAM_INT);
        $sql->bindValue(4, $bien_numserie, PDO::PARAM_STR);
        $sql->bindValue(5, $bien_codbarras, PDO::PARAM_STR);
        $sql->bindValue(6, $bien_color, PDO::PARAM_STR);
        $sql->bindValue(7, $bien_dim, PDO::PARAM_STR);
        $sql->bindValue(8, $val_adq, PDO::PARAM_STR);
        $sql->bindValue(9, $doc_adq, PDO::PARAM_STR);
        $sql->bindValue(10, $bien_obs, PDO::PARAM_STR);
        $sql->bindValue(11, $bien_cuenta, PDO::PARAM_STR);
        $sql->bindValue(12, $procedencia, PDO::PARAM_STR);
        $sql->bindValue(13, $bien_id, PDO::PARAM_INT);

        $sql->execute();

        return $sql->rowCount(); // Número de registros modificados
     }
    public function delete_objeto($obj_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE sc_inventario.tb_objeto
                    SET
                        est = 0
                    WHERE
                        obj_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $obj_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function verificar_historial_bien($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS total FROM sc_inventario.tb_bien_dependencia WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'] > 0; // true si tiene historial, false si no
        }
    public function delete_bien($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien
                SET bien_est = 'E'
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id);
        $stmt->execute();
        return true;
        }
    public function get_objeto($gc_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM sc_inventario.tb_objeto tob
                WHERE tob.est = 1 and gc_id = ? order by tob.obj_id asc";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $gc_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_bien_repre($pers_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                        tb.bien_codbarras, 
                        td.bien_id, 
                        tp.pers_apelpat || ' ' || tp.pers_apelmat || ', ' || tp.pers_nombre AS nombre_completo, 
                        tob.obj_nombre,  
                        tb.bien_color, 
                        tb.bien_est
                    from sc_inventario.tb_bien_dependencia  td
                    inner join sc_escalafon.tb_persona tp on tp.pers_id = td.repre_id
                    inner join sc_inventario.tb_bien tb on tb.bien_id = td.bien_id
                    left join sc_inventario.tb_objeto tob on tob.obj_id = tb.obj_id
                    where td.repre_id = ? and td.biendepe_est =1 and td.bien_est <> 'I';";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $pers_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

    public function get_objeto_id($obj_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM sc_inventario.tb_objeto WHERE est = 1 AND obj_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $obj_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_objeto_categoria($gc_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM sc_inventario.tb_objeto 
            WHERE est = 1  and  gc_id= ? order by obj_id  asc";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $gc_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_objeto_modelo($marca_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM sc_inventario.tb_modelo
            WHERE modelo_est = 1  and  marca_id = ? order by modelo_nom asc ";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $marca_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_colores()
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tb_color";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_codinterno()
        {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_inventario.tb_bien ORDER BY bien_id DESC LIMIT 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
      }
    public function insert_objeto_usu($objeto_id, $pers_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO sc_inventario.td_objetousu(objetousu_usu, objetousu_objeto, est) VALUES (?, ?, 1) RETURNING objetousu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $objeto_id);
            $stmt->execute();


            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        }
    public function eliminar_objeto_usu($objetousu_id)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE sc_inventario.td_objetousu
                    SET
                        est = 0
                    WHERE
                        objetousu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $objetousu_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    
    public function buscar_cod_cana($codigo_cana)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT *
                FROM sc_inventario.tb_objeto where codigo_cana = ?; ";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $codigo_cana);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function get_color($color_id)
        {
            if (empty($color_id) || !is_numeric($color_id)) {
                return []; // retorna vacío si no es un valor válido
            }
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM public.tb_color WHERE color_id = ? AND color_est = 1;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, (int)$color_id, PDO::PARAM_INT); // fuerza a tipo entero
            $sql->execute();

            return $sql->fetchAll();
        }
    public function buscar_obj_barras($cod_barras)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT tbb.bien_id, tp.pers_dni,  tp.pers_apelpat || ' ' || tp.pers_apelmat || ', ' || tp.pers_nombre AS nombre_completo, tbb.bien_est, tbm.marca_id, tbb.modelo_id , tob.obj_nombre, tbb.bien_codbarras, tbb.fecharegistro, tbb.bien_numserie, tbb.bien_dim, tbb.procedencia, tbb.bien_color,  td.depe_denominacion 
            from sc_inventario.tb_bien tbb
            left join sc_inventario.tb_bien_dependencia tbd on tbb.bien_id = tbd.bien_id
            left join tb_dependencia td on td.depe_id = tbd.depe_id
            left join sc_inventario.tb_objeto tob on tob.obj_id = tbb.obj_id
            left join sc_inventario.tb_modelo tbm on tbm.modelo_id = tbb.modelo_id
            left join sc_escalafon.tb_persona tp on tp.pers_id = tbd.repre_id
            where tbb.bien_codbarras = ? and tbb.bien_est in ('A','N','B','R','M') and tbd.biendepe_est =1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cod_barras);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function buscar_obj_barras_simple($cod_barras)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT tbb.bien_id,tbd.biendepe_est, tp.pers_dni,  tp.pers_apelpat || ' ' || tp.pers_apelmat || ', ' || tp.pers_nombre AS nombre_completo, tbb.bien_est, tbm.marca_id, tbb.modelo_id , tob.obj_nombre, tbb.bien_codbarras, tbb.fecharegistro, tbb.bien_numserie, 
            tbb.procedencia, tbb.bien_dim, tbb.val_adq, tbb.doc_adq,tbb.bien_obs, tbb.bien_color,  td.depe_denominacion , tbm.marca_id,tm.marca_nom,tbb.modelo_id,tbm.modelo_nom
            from sc_inventario.tb_bien tbb
            left join sc_inventario.tb_bien_dependencia tbd on tbb.bien_id = tbd.bien_id
            left join tb_dependencia td on td.depe_id = tbd.depe_id
            left join sc_inventario.tb_objeto tob on tob.obj_id = tbb.obj_id
            left join sc_inventario.tb_modelo tbm on tbm.modelo_id = tbb.modelo_id
            LEFT JOIN sc_inventario.tb_marca tm ON tm.marca_id = tbm.marca_id
            left join sc_escalafon.tb_persona tp on tp.pers_id = tbd.repre_id
            where tbb.bien_codbarras = ? and tbb.bien_est in ('N','B','R','M') order by  tbd.biendepe_est desc limit 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $cod_barras);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    public function buscar_bien_id($bien_id)
     {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT tbb.bien_id,tob.codigo_cana, tbb.bien_est, tbd.bien_est as estadodepe, tbd.biendepe_obs , tbm.marca_id, tma.marca_nom, tbc.clase_nom, tbb.modelo_id, tbm.modelo_nom, tob.obj_nombre, tbb.bien_codbarras,
        tbb.fecharegistro, tbb.bien_numserie, tbb.bien_dim, tbb.bien_color,  td.depe_denominacion, tbb.bien_color,
        tbb.obj_id, tob.gc_id,  tgc.gg_id, tgg.gg_nom
                from sc_inventario.tb_bien tbb 
                left join sc_inventario.tb_objeto tob on tob.obj_id = tbb.obj_id
                left join sc_inventario.tb_grupo_clase tgc on tgc.gc_id = tob.gc_id
                left join sc_inventario.tb_grupogenerico tgg on tgg.gg_id = tgc.gg_id
                left join sc_inventario.tb_clase tbc on tbc.clase_id = tgc.clase_id
                left join sc_inventario.tb_bien_dependencia tbd on tbb.bien_id = tbd.bien_id
                left join tb_dependencia td on td.depe_id = tbd.depe_id
                left join sc_inventario.tb_modelo tbm on tbm.modelo_id = tbb.modelo_id
                left join sc_inventario.tb_marca tma on tma.marca_id = tbm.marca_id
                 where tbb.bien_id = ? and tbb.bien_est in ('A','B','R','M','N') and tbd.biendepe_est = 1
              
		 ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $bien_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
     }
    public function mostrar_bien_id($bien_id)
        {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT 
                tbb.bien_id,
                tob.codigo_cana, 
                tbb.bien_est, 
                tbd.bien_est as estadodepe, 
                tbd.biendepe_obs, 
                tbm.marca_id, 
                tma.marca_nom, 
                tbc.clase_nom, 
                tbb.modelo_id, 
                tbm.modelo_nom, 
                tob.obj_nombre, 
                tbb.bien_codbarras,
                tbb.fecharegistro, 
                tbb.bien_numserie, 
                tbb.bien_dim, 
                tbb.bien_color,  
                td.depe_denominacion, 
                tbb.obj_id, 
                tob.gc_id,  
                tgc.gg_id, 
                tgg.gg_nom,
                tbb.val_adq,
                tbb.doc_adq,
                tbb.bien_obs,
                tbb.bien_cuenta,
                tbb.procedencia
            FROM sc_inventario.tb_bien tbb 
            LEFT JOIN sc_inventario.tb_objeto tob ON tob.obj_id = tbb.obj_id
            LEFT JOIN sc_inventario.tb_grupo_clase tgc ON tgc.gc_id = tob.gc_id
            LEFT JOIN sc_inventario.tb_grupogenerico tgg ON tgg.gg_id = tgc.gg_id
            LEFT JOIN sc_inventario.tb_clase tbc ON tbc.clase_id = tgc.clase_id
            LEFT JOIN sc_inventario.tb_bien_dependencia tbd ON tbb.bien_id = tbd.bien_id
            LEFT JOIN tb_dependencia td ON td.depe_id = tbd.depe_id
            LEFT JOIN sc_inventario.tb_modelo tbm ON tbm.modelo_id = tbb.modelo_id
            LEFT JOIN sc_inventario.tb_marca tma ON tma.marca_id = tbm.marca_id
            WHERE tbb.bien_id = ?
            AND tbb.bien_est IN ('B','R','M','N')";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $bien_id);
            $sql->execute();
            return $sql->fetchAll();
        }
    public function get_todos_objetos()
        {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT 
                    obj_id,
                    codigo_cana,
                    obj_nombre 
                    FROM sc_inventario.tb_objeto 
                    WHERE est = '1' 
                    ORDER BY obj_nombre ASC";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        

}
