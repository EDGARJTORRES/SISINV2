<?php
class Combustible extends Conectar {
    public function get_combustible_detalle() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT comb_id, comb_tipo
                FROM public.tb_combustible
                ORDER BY comb_tipo ASC;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
