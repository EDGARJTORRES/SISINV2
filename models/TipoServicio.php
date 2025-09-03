<?php
class TipoServicio extends Conectar{
    public function  listar_tipo_servicio(){
         {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    move_id,
                    move_descripcion 
                    FROM sc_transporte.tb_modalidad_vehiculo
                    where move_estado='A';";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
}
