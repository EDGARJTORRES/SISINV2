<?php
class DetalleBien extends Conectar {
    public function mostrar_estado($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT bien_est
                FROM sc_inventario.tb_bien
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update_identificacion($bien_id, $ruta, $clase_vehiculo, $vin, $categoria, $anio_fabricacion, $tipo_carroceria, $bien_comb, $version) {
        $conectar = parent::conexion();
        parent::set_names();

        if (!is_array($bien_comb)) {
            $bien_comb = [];
        }
        $bien_comb_pg = count($bien_comb) > 0
            ? '{' . implode(',', array_map('intval', $bien_comb)) . '}'
            : '{}';
        $sql = "UPDATE sc_inventario.tb_bien_detalle 
                SET ruta = ?, 
                    clase_vehiculo = ?, 
                    vin = ?, 
                    categoria = ?, 
                    anio_fabricacion = ?, 
                    tipo_carroceria = ?, 
                    bien_comb = ?::integer[], 
                    version = ?
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ruta);
        $stmt->bindValue(2, $clase_vehiculo !== '' ? (int)$clase_vehiculo : null, PDO::PARAM_INT);
        $stmt->bindValue(3, $vin);
        $stmt->bindValue(4, $categoria);
        $stmt->bindValue(5, $anio_fabricacion !== '' ? (int)$anio_fabricacion : null, PDO::PARAM_INT);
        $stmt->bindValue(6, $tipo_carroceria !== '' ? $tipo_carroceria : null, PDO::PARAM_STR);
        $stmt->bindValue(7, $bien_comb_pg);
        $stmt->bindValue(8, $version);
        $stmt->bindValue(9, (int)$bien_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function update_caracteristicas($bien_id, $nro_motor, $ruedas, $cilindros, $cilindrada, $potencia, $form_rodaje, $ejes) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien_detalle
                SET nro_motor = ?, 
                    ruedas = ?, 
                    cilindros = ?, 
                    cilindrada = ?, 
                    potencia = ?, 
                    form_rodaje = ?, 
                    ejes = ?  
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nro_motor, PDO::PARAM_STR);
        $stmt->bindValue(2, $ruedas, PDO::PARAM_INT);
        $stmt->bindValue(3, $cilindros, PDO::PARAM_INT);
        $stmt->bindValue(4, $cilindrada, PDO::PARAM_STR);
        $stmt->bindValue(5, $potencia, PDO::PARAM_STR);
        $stmt->bindValue(6, $form_rodaje, PDO::PARAM_STR);
        $stmt->bindValue(7, $ejes, PDO::PARAM_INT);
        $stmt->bindValue(8, $bien_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function update_capacidades($bien_id, $pasajero, $asiento, $peso_neto, $carga_util, $peso_bruto) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien_detalle
                SET pasajero = ?, 
                    asiento = ?, 
                    peso_neto = ?, 
                    carga_util = ?, 
                    peso_bruto = ?
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $pasajero, PDO::PARAM_INT);
        $stmt->bindValue(2, $asiento, PDO::PARAM_INT);
        $stmt->bindValue(3, $peso_neto);
        $stmt->bindValue(4, $carga_util);
        $stmt->bindValue(5, $peso_bruto);
        $stmt->bindValue(6, $bien_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function get_identificacion($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    b.bien_id,
                    b.ruta,
                    v.veh_clase_id AS clase_vehiculo_id,
                    v.veh_clase_nom AS clase_vehiculo,
                    b.vin,
                    b.categoria,
                    b.anio_fabricacion,
                    b.tipo_carroceria AS tipo_carroceria_id, 
                    ca.carroceria AS tipo_carroceria,        
                    b.version,
                    array_agg(c.comb_id ORDER BY c.comb_id) AS combustibles
                FROM sc_inventario.tb_bien_detalle b
                LEFT JOIN sc_inventario.tb_vehiculo_clase v ON v.veh_clase_id = b.clase_vehiculo
                LEFT JOIN LATERAL unnest(b.bien_comb) AS bc(comb_id) ON TRUE
                LEFT JOIN public.tb_combustible c  ON c.comb_id = bc.comb_id
                LEFT JOIN public.vista_tipos_carroceria ca ON b.tipo_carroceria = ca.codigo
                WHERE b.bien_id = ?
                GROUP BY 
                    b.bien_id, b.ruta, v.veh_clase_id, v.veh_clase_nom,
                    b.vin, b.categoria, b.anio_fabricacion,
                    b.tipo_carroceria, ca.carroceria, b.version";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_caracteristicas($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT nro_motor, ruedas, cilindros,cilindrada, potencia, form_rodaje,ejes
                FROM sc_inventario.tb_bien_detalle
                WHERE bien_id = ?";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_capacidades($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT  pasajero, asiento ,peso_neto, carga_util, peso_bruto
                FROM sc_inventario.tb_bien_detalle
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }  
}
?>
