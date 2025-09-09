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
            $sql="SELECT td.depe_id, td.depe_denominacion || ' - ' || tblm.lomu_denominacion || ' - ' || td.depe_direccion AS denominacion_concatenada
            FROM tb_dependencia td
            INNER JOIN sc_escalafon.tb_local_municipal tblm ON td.lomu_id = tblm.lomu_id
			where td.nior_id in(1,2,3,4,5)
            AND  td.depe_estado= 'A'
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
        public function contadorBienesPorDependencia() {
            $conectar = parent::conexion();
            $sql = "SELECT
                        d.depe_denominacion,
                        COUNT(DISTINCT bd.bien_id) AS cantidad
                    FROM
                        public.tb_dependencia d
                    JOIN 
                        sc_inventario.tb_bien_dependencia bd ON d.depe_id = bd.depe_id
                    WHERE 
                        bd.bien_est NOT IN ('I', 'E')
                    AND 
                        bd.biendepe_est = 1
                    AND 
                        d.depe_estado = 'A'
                    GROUP BY 
                        d.depe_id, d.depe_denominacion
                    ORDER BY 
                        d.depe_denominacion;";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function listarCantidadBienesPorDependencia() {
            $conectar = parent::conexion();
            $sql = "SELECT DISTINCT
                        d.depe_id,
                        d.depe_denominacion,
                        COUNT(bd.bien_id) AS cantidad_bienes
                    FROM 
                        public.tb_dependencia d
                    JOIN 
                        sc_inventario.tb_bien_dependencia bd ON d.depe_id = bd.depe_id
                    WHERE 
                        bd.bien_est NOT IN ('I', 'E')
                    AND  
                        d.depe_estado = 'A'
                    AND 
                        bd.biendepe_est = 1
                    GROUP BY 
                        d.depe_id, d.depe_denominacion
                    ORDER BY 
                        d.depe_denominacion;";
            
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function listarBienesPorDependencia($depe_id) {
            $conectar = parent::conexion();
            $sql = "SELECT DISTINCT
                        b.bien_id,
                        tp.pers_apelpat || ' ' || tp.pers_apelmat || ', ' || tp.pers_nombre AS nombre_completo, 
                        b.bien_codbarras,
                        o.obj_nombre, 
                        (
                            SELECT string_agg(c.color_nom, ', ')
                            FROM public.tb_color c
                            WHERE c.color_id = ANY(b.bien_color)
                        ) AS bien_color,
                        b.bien_dim,
                        b.val_adq,
                        b.doc_adq
                    FROM 
                        sc_inventario.tb_bien_dependencia bd
                    INNER JOIN 
                        sc_inventario.tb_bien b ON b.bien_id = bd.bien_id
                    INNER JOIN 
                        sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                    INNER JOIN
                        public.tb_dependencia d ON d.depe_id = bd.depe_id
                    LEFT JOIN 
                        sc_escalafon.tb_persona tp on tp.pers_id = bd.repre_id
                    WHERE 
                        bd.depe_id = ?        
                    AND bd.bien_est NOT IN ('I', 'E')     
                    AND bd.biendepe_est = 1
                    AND d.depe_estado = 'A';";

            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $depe_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function listarBienesPorDependencia2($depe_id) {
            $conectar = parent::conexion();
            $sql = "SELECT DISTINCT
                        b.bien_id,
                        b.bien_codbarras,
                        o.obj_nombre, 
                        tp.pers_apelpat || ' ' || tp.pers_apelmat || ', ' || tp.pers_nombre AS nombre_completo,
                        b.val_adq,
                        b.doc_adq,
                        b.bien_est
                    FROM 
                        sc_inventario.tb_bien_dependencia bd
                    INNER JOIN 
                        sc_inventario.tb_bien b ON b.bien_id = bd.bien_id
                    INNER JOIN 
                        sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                    INNER JOIN 
                        public.tb_dependencia d ON d.depe_id = bd.depe_id
                    LEFT JOIN 
                        sc_escalafon.tb_persona tp on tp.pers_id = bd.repre_id
                    WHERE 
                        bd.depe_id = ?
                        AND bd.bien_est NOT IN ('I', 'E')
                        AND bd.biendepe_est = 1
                        AND d.depe_estado = 'A';";

            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $depe_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function darDeBajaBien($bien_id, $motivo_baja) {
            $conectar = parent::conexion();
            parent::set_names();
            try {
                $conectar->beginTransaction();

                $sql1 = "UPDATE sc_inventario.tb_bien_dependencia 
                        SET bien_est = 'I', motivo_baja = ?, fecha_baja = CURRENT_DATE
                        WHERE bien_id = ?";
                $stmt1 = $conectar->prepare($sql1);
                $stmt1->bindValue(1, $motivo_baja);
                $stmt1->bindValue(2, $bien_id);
                $stmt1->execute();
                $sql2 = "UPDATE sc_inventario.tb_bien 
                        SET bien_est = 'I'
                        WHERE bien_id = ?";
                $stmt2 = $conectar->prepare($sql2);
                $stmt2->bindValue(1, $bien_id);
                $stmt2->execute();
                $conectar->commit();
                return true;
            } catch (Exception $e) {
                $conectar->rollBack();
                return false;
            }
        }
        public function restaurarBien($bien_id) {
            $conectar = parent::conexion();
            parent::set_names();
            try {
                $conectar->beginTransaction();

                $sql = "SELECT bien_est_anterior FROM sc_inventario.tb_bien WHERE bien_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $bien_id);
                $stmt->execute();
                $estadoAnterior = $stmt->fetchColumn();

                if (!$estadoAnterior) {
                    $conectar->rollBack();
                    return false;
                }

                $sql1 = "UPDATE sc_inventario.tb_bien
                        SET bien_est = ?, bien_est_anterior = NULL
                        WHERE bien_id = ?";
                $stmt1 = $conectar->prepare($sql1);
                $stmt1->bindValue(1, $estadoAnterior);
                $stmt1->bindValue(2, $bien_id);
                $stmt1->execute();

                $sql2 = "UPDATE sc_inventario.tb_bien_dependencia
                        SET bien_est = ?
                        WHERE bien_id = ?";
                $stmt2 = $conectar->prepare($sql2);
                $stmt2->bindValue(1, $estadoAnterior);
                $stmt2->bindValue(2, $bien_id);
                $stmt2->execute();

                $conectar->commit();
                return true;
            } catch (Exception $e) {
                $conectar->rollBack();
                return false;
            }
        }
        public function listarBienesBaja() {
            $conectar = parent::conexion();
            $sql = "SELECT
                        d.depe_id,
                        d.depe_denominacion AS area,
                        d.depe_representante AS representante,
                        COUNT(DISTINCT bd.bien_id) AS cantidad_bienes
                    FROM
                        sc_inventario.tb_bien_dependencia bd
                    JOIN
                        public.tb_dependencia d ON bd.depe_id = d.depe_id
                    WHERE
                        bd.bien_est = 'I'
                    AND
                        bd.biendepe_est = 1
                    GROUP BY
                        d.depe_id, d.depe_denominacion, d.depe_representante
                    ORDER BY
                        d.depe_denominacion;";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerUltimoBienDeBaja() {
            $conectar = parent::conexion();
            try {
                $sql = "SELECT 
                            b.bien_id,
                            o.obj_nombre,
                            bd.fecha_baja,
                            bd.bien_est
                        FROM sc_inventario.tb_bien_dependencia bd
                        INNER JOIN sc_inventario.tb_bien b ON bd.bien_id = b.bien_id
                        INNER JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                        WHERE bd.fecha_baja IS NOT NULL
                        AND bd.biendepe_est = 1
                        and bd.bien_est='I'
                        ORDER BY bd.fecha_baja DESC
                        LIMIT 1";

                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                // Manejo de error (puedes loguear el error si lo deseas)
                return false;
            }
        }
        public function obtener_areas_con_baja(){
             $conectar = parent::conexion();
              $sql = "SELECT DISTINCT d.depe_id, d.depe_denominacion
                        FROM sc_inventario.tb_bien_dependencia bd
                        JOIN public.tb_dependencia d ON bd.depe_id = d.depe_id
                        WHERE bd.bien_est = 'I'
                        AND bd.biendepe_est = 1
                        ORDER BY d.depe_denominacion
                ";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function listarBienesDadosDeBajaPorDependencia($depe_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT
                b.bien_id,               
                bd.fecha_baja,
                b.bien_codbarras,
                COALESCE(o.obj_nombre, '---') AS obj_nombre,
                COALESCE(ma.marca_nom, '---') AS marca_nom,
                COALESCE(mo.modelo_nom, '---') AS modelo_nom,
                b.bien_numserie,
                b.procedencia,
                bd.motivo_baja
            FROM
                sc_inventario.tb_bien_dependencia bd
            JOIN public.tb_dependencia d ON bd.depe_id = d.depe_id
            JOIN sc_inventario.tb_bien b ON bd.bien_id = b.bien_id
            LEFT JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
            LEFT JOIN sc_escalafon.tb_persona p ON bd.pers_id = p.pers_id
            LEFT JOIN sc_inventario.tb_modelo mo ON b.modelo_id = mo.modelo_id
            LEFT JOIN sc_inventario.tb_marca ma ON mo.marca_id = ma.marca_id
            WHERE bd.bien_est = 'I' AND bd.biendepe_est = 1 AND d.depe_id = ?
            ORDER BY bd.fecha_baja DESC;";

            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $depe_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerBienBajaPorId($bien_id) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT
                    b.bien_id,
                    b.fecharegistro,
                    p.pers_apelpat || ' ' || p.pers_apelmat || ', ' || p.pers_nombre AS nombre_completo,
                    bd.fecha_baja,
                    bd.motivo_baja,
                    b.bien_color,
                    tc.cuenta_numero,
                    b.bien_codbarras,
                    b.bien_obs,
                    bd.repre_id,
                    b.bien_numserie,
                    b.procedencia,
                    bd.biendepe_obs,
                    b.bien_dim,
                    o.codigo_cana,
                    bd.bien_est,
                    REPLACE(REPLACE(b.val_adq::text, 'S/', ''), ',', '')::numeric AS val_adq,
                    b.fechacrea,
                    COALESCE(o.obj_nombre, '---') AS obj_nombre,
                    COALESCE(ma.marca_nom, '---') AS marca_nom,
                    COALESCE(mo.modelo_nom, '---') AS modelo_nom,
                    COALESCE(gg.vida_util, 10) AS vida_util,
                    f.form_id,
                    f.form_fechacrea AS fecha_asignacion,
                    COALESCE(string_agg(DISTINCT c.color_nom, ', '), '---') AS colores
                FROM
                    sc_inventario.tb_bien_dependencia bd
                JOIN sc_inventario.tb_bien b ON bd.bien_id = b.bien_id
                LEFT JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                LEFT JOIN sc_inventario.tb_grupo_clase gc ON o.gc_id = gc.gc_id
                LEFT JOIN sc_inventario.tb_grupogenerico gg ON gc.gg_id = gg.gg_id
                LEFT JOIN sc_escalafon.tb_persona p ON bd.repre_id = p.pers_id
                LEFT JOIN sc_inventario.tb_cuenta_contable tc ON b.bien_cuenta = tc.cuenta_id
                LEFT JOIN LATERAL unnest(b.bien_color) AS bc(color_id) ON TRUE
                LEFT JOIN public.tb_color c ON c.color_id = bc.color_id
                LEFT JOIN sc_inventario.tb_modelo mo ON b.modelo_id = mo.modelo_id
                LEFT JOIN sc_inventario.tb_marca ma ON mo.marca_id = ma.marca_id
                LEFT JOIN sc_inventario.tb_formato f ON bd.form_id = f.form_id
                WHERE
                    b.bien_id = ?
                    AND bd.bien_est = 'I'
                    AND bd.biendepe_est = 1
                GROUP BY
                    b.bien_id, b.fecharegistro, p.pers_apelpat, p.pers_apelmat, p.pers_nombre,
                    bd.fecha_baja, bd.motivo_baja, b.bien_color, b.bien_cuenta, b.bien_codbarras,
                    b.bien_obs, bd.repre_id, b.bien_numserie, b.procedencia, bd.biendepe_obs,            tc.cuenta_numero, b.bien_dim , o.codigo_cana, bd.bien_est, b.val_adq, b.fechacrea, o.obj_nombre,
                    ma.marca_nom, mo.modelo_nom, gg.vida_util, f.form_id, f.form_fechacrea;";

            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $bien_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function lista_historial_movimiento($codigo = '') {
            $conectar = parent::conexion();
            parent::set_names();
            if (!empty($codigo)) {
                $sql = "SELECT  
                            o.obj_nombre,
                            b.bien_codbarras,
                            d.depe_denominacion,
                            p.pers_apelpat || ' ' || p.pers_apelmat || ', ' || p.pers_nombre AS nombre_completo,
                            f.form_fechacrea
                        FROM sc_inventario.tb_bien_dependencia bd
                        LEFT JOIN sc_inventario.tb_bien b ON bd.bien_id = b.bien_id
                        LEFT JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                        LEFT JOIN public.tb_dependencia d ON d.depe_id = bd.depe_id
                        LEFT JOIN sc_escalafon.tb_persona p ON p.pers_id = bd.repre_id
                        LEFT JOIN sc_inventario.tb_formato f on f.form_id = bd.form_id
                        WHERE b.bien_codbarras = :codigo
                        ORDER BY f.form_fechacrea DESC";
                $stmt = $conectar->prepare($sql);
                $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
            } else {
                $sql = "SELECT DISTINCT ON (b.bien_codbarras)
                            o.obj_nombre,
                            b.bien_codbarras
                        FROM sc_inventario.tb_bien_dependencia bd
                        LEFT JOIN sc_inventario.tb_bien b ON bd.bien_id = b.bien_id
                        LEFT JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                        LEFT JOIN sc_inventario.tb_formato f on f.form_id = bd.form_id
                        ORDER BY b.bien_codbarras, f.form_fechacrea DESC";
                $stmt = $conectar->prepare($sql);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


    }
?>