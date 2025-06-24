<?php
class Documento extends Conectar {
    public function get_documentos_firmados() {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT 
                    d.doc_id,
                    d.doc_tipo,
                    dp.depe_denominacion,
                    d.doc_desc,
                    d.fecha_carga,
                    d.doc_ruta,
                    d.pers_id,
                    p.pers_dni,
                    p.pers_apelpat || ' ' || p.pers_apelmat || ', ' || p.pers_nombre AS nombre_completo
                FROM sc_inventario.tb_documento d
                INNER JOIN public.tb_dependencia dp ON d.depe_id = dp.depe_id
                LEFT JOIN sc_escalafon.tb_persona p ON d.pers_id = p.pers_id
                WHERE d.doc_est = 1
                ORDER BY d.fecha_carga DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }
}
