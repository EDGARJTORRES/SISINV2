<?php
class ClaseVehiculo extends Conectar{
    public function  listar_clase_vehiculo(){
         {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    veh_clase_id,
                    veh_clase_nom
                    FROM sc_inventario.tb_vehiculo_clase
                    where veh_clase_est='A';";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
}
