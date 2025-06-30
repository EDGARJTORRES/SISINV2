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
    public function insert_documento($doc_tipo, $depe_id, $doc_desc, $doc_ruta, $pers_id) {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO sc_inventario.tb_documento (doc_tipo, depe_id, doc_desc, doc_ruta, pers_id, doc_est, fecha_carga)
                VALUES (?, ?, ?, ?, ?, 1, NOW())";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$doc_tipo, $depe_id, $doc_desc, $doc_ruta, $pers_id]);
    }
    public function update_documento($doc_id, $doc_tipo, $depe_id, $doc_desc, $doc_ruta, $pers_id) {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_documento
                SET doc_tipo = ?, depe_id = ?, doc_desc = ?, doc_ruta = ?, pers_id = ?
                WHERE doc_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$doc_tipo, $depe_id, $doc_desc, $doc_ruta, $pers_id, $doc_id]);
    }
    public function delete_documento($doc_id) {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_documento
                SET doc_est = 0
                WHERE doc_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$doc_id]);
    }
    public function get_documento_por_id($doc_id) {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT 
                    doc_id, doc_tipo, depe_id, doc_desc, doc_ruta, pers_id
                FROM sc_inventario.tb_documento
                WHERE doc_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$doc_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}
