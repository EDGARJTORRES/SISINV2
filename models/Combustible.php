<?php
class Combustible extends Conectar {
    public function get_combustible_detalle(){
         {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT comb_id , comb_nombre 
                    FROM sc_residuos_solidos.tb_combustible
                    ORDER BY comb_nombre ASC;;";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
}
