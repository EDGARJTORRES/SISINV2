<?php
class Formato extends Conectar
{
    public function asigna_bienes($bien_id, $form_id, $depe_id, $biendepe_obs, $bien_color, $bien_est, $pers_id, $repre_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO sc_inventario.tb_bien_dependencia(bien_id,form_id,depe_id,biendepe_obs, bien_color, bien_est, pers_id,repre_id  ) 
        VALUES (?,?,?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $bien_id);
        $sql->bindValue(2, $form_id);
        $sql->bindValue(3, $depe_id);
        $sql->bindValue(4, $biendepe_obs);
        $sql->bindValue(5, $bien_color);
        $sql->bindValue(6, $bien_est);
        $sql->bindValue(7, $pers_id);
        $sql->bindValue(8, $repre_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function crear_formato($tif_id, $pers_id, $depe_emisor, $depe_receptor, $form_repre_emisor, $form_repre_receptor, $form_depe_deno_emisor, $form_depe_deno_receptor, $form_dni_repre_emisor, $form_dni_repre_receptor, $form_repre_emisor_nom, $form_repre_receptor_nom)
    {
        $conectar = parent::conexion();
        parent::set_names();

        /*  // Maneja depe_receptor si está vacío
        if ($depe_emisor === '') {
            $depe_emisor = null;
        } */

        $sql = "INSERT INTO sc_inventario.tb_formato(tif_id, pers_id, depe_emisor, depe_receptor, form_repre_emisor, form_repre_receptor, form_depe_deno_emisor, 
        form_depe_deno_receptor, form_dni_repre_emisor, form_dni_repre_receptor, form_repre_emisor_nom, form_repre_receptor_nom) 
        VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tif_id);
        $sql->bindValue(2, $pers_id);
        $sql->bindValue(3, $depe_emisor, PDO::PARAM_NULL);
        $sql->bindValue(4, $depe_receptor);
        $sql->bindValue(5, $form_repre_emisor, PDO::PARAM_NULL);
        $sql->bindValue(6, $form_repre_receptor);
        $sql->bindValue(7, $form_depe_deno_emisor, PDO::PARAM_NULL);
        $sql->bindValue(8, $form_depe_deno_receptor);
        $sql->bindValue(9, $form_dni_repre_emisor, PDO::PARAM_NULL);
        $sql->bindValue(10, $form_dni_repre_receptor);
        $sql->bindValue(11, $form_repre_emisor_nom, PDO::PARAM_NULL);
        $sql->bindValue(12, $form_repre_receptor_nom);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function crear_formato_desplaza($tif_id, $pers_id, $depe_emisor, $depe_receptor, $form_repre_emisor, $form_repre_receptor, $form_depe_deno_emisor, $form_depe_deno_receptor, $form_dni_repre_emisor, $form_dni_repre_receptor, $form_repre_emisor_nom, $form_repre_receptor_nom,
    $doc_traslado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        /*  // Maneja depe_receptor si está vacío
        if ($depe_emisor === '') {
            $depe_emisor = null;
        } */

        $sql = "INSERT INTO sc_inventario.tb_formato(tif_id, pers_id, depe_emisor, depe_receptor, form_repre_emisor, form_repre_receptor, form_depe_deno_emisor, 
        form_depe_deno_receptor, form_dni_repre_emisor, form_dni_repre_receptor, form_repre_emisor_nom, form_repre_receptor_nom,
        doc_traslado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tif_id);
        $sql->bindValue(2, $pers_id);
        $sql->bindValue(3, $depe_emisor);
        $sql->bindValue(4, $depe_receptor);
        $sql->bindValue(5, $form_repre_emisor);
        $sql->bindValue(6, $form_repre_receptor);
        $sql->bindValue(7, $form_depe_deno_emisor);
        $sql->bindValue(8, $form_depe_deno_receptor);
        $sql->bindValue(9, $form_dni_repre_emisor);
        $sql->bindValue(10, $form_dni_repre_receptor);
        $sql->bindValue(11, $form_repre_emisor_nom);
        $sql->bindValue(12, $form_repre_receptor_nom);
        $sql->bindValue(13, $doc_traslado);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function ultimo_formatid()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT form_id
        FROM sc_inventario.tb_formato order by form_id desc limit 1 ;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_dependenciadatos($depe_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT depe_id, depe_denominacion, depe_superior, nior_id
        from tb_dependencia where depe_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $depe_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_repe_datos($pers_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
        pers_id,
        pers_dni,
        CONCAT(pers_nombre, ' ', pers_apelpat, ' ', pers_apelmat) AS nombre_completo
    FROM 
        sc_escalafon.tb_persona
    WHERE 
        pers_id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $pers_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function actualizarbien($bien_id, $bien_est)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien
                SET bien_est=?
        WHERE bien_id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $bien_est);
        $sql->bindValue(2, $bien_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function delete_formato($form_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_formato
                SET
                    form_est = 0
                WHERE
                    form_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $form_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function deleteBienDepe($bien_id)
    {
        // Obtener la dependencia del bien
        $bienDepeData = $this->getBienDepe($bien_id);

        // Verificar si hay datos de la dependencia del bien
        if (!$bienDepeData) {
            return false; // No se encontró ninguna dependencia activa para el bien
        }

        // Obtener la conexión a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar el estado de la dependencia del bien
        $sql = "UPDATE sc_inventario.tb_bien_dependencia 
                SET biendepe_est = 0
                WHERE biendepe_id = ?";

        // Preparar y ejecutar la consulta
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bienDepeData[0]['biendepe_id']);
        $stmt->execute();

        // Verificar si la actualización fue exitosa
        return $stmt->rowCount() > 0;
    }

    public function getBienDepe($bien_id)
    {
        // Obtener la conexión a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para obtener la dependencia del bien
        $sql = "SELECT biendepe_id, fechacrea, form_id, bien_id
                FROM sc_inventario.tb_bien_dependencia
                WHERE bien_id = ? AND biendepe_est = 1
                ORDER BY fechacrea DESC
                LIMIT 1";

        // Preparar y ejecutar la consulta
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id);
        $stmt->execute();

        // Retornar los resultados de la consulta
        return $stmt->fetchAll();
    }


    public function get_formato()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select count(tbp.biendepe_id), esper.pers_nombre, tbp.form_id, tbf.form_fechacrea, tbft.tif_nom, 
        tdepe1.depe_denominacion as receptor,tdepe2.depe_denominacion as emisor
        from sc_inventario.tb_bien_dependencia tbp 
        inner join sc_inventario.tb_formato tbf on tbf.form_id= tbp.form_id
        AND tbf.form_est = 1
		left join tb_dependencia tdepe1 on tdepe1.depe_id = tbf.depe_receptor
		left join tb_dependencia tdepe2 on tdepe2.depe_id = tbf.depe_emisor
        inner join sc_inventario.tb_tipoformato tbft on tbft.tif_id= tbf.tif_id
        inner join  sc_escalafon.tb_persona esper ON esper.pers_id = tbf.pers_id
        group by tbp.form_id, tbf.form_fechacrea, tbft.tif_nom,tbf.depe_emisor,
		tbf.depe_receptor,esper.pers_nombre, tdepe1.depe_denominacion,tdepe2.depe_denominacion  
    ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_formato_id($form_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select tbp.biendepe_id, tbp.bien_id, tbp.form_id, tbf.form_fechacrea, 
		tbft.tif_nom, tbft.tif_id, tbf.depe_emisor, tbf.depe_receptor, tbf.form_repre_emisor, tbf.form_repre_receptor, tbf.form_depe_deno_emisor,
		tbf.form_depe_deno_receptor, tbf.form_dni_repre_emisor, tbf.form_dni_repre_receptor,
		tbf.form_repre_emisor_nom, tbf.form_repre_receptor_nom ,tbf.doc_traslado
        from sc_inventario.tb_bien_dependencia tbp 
        inner join sc_inventario.tb_formato tbf on tbf.form_id= tbp.form_id
        inner join sc_inventario.tb_tipoformato tbft on tbft.tif_id= tbf.tif_id
		where tbp.form_id = ?
        ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $form_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_total_bienes($form_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT count(biendepe_id) FROM sc_inventario.tb_bien_dependencia where form_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $form_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_tipoForm()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT *
        FROM sc_inventario.tb_tipoformato;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function buscar_obj_barras($cod_barras)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT bien_id
        FROM sc_inventario.tb_bien
        where bien_codbarras= ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cod_barras);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_form_id($form_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_inventario.tb_formato WHERE form_est = 1 AND form_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $form_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
