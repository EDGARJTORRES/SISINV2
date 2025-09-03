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
    public function update_identificacion($bien_id, $ruta, $tipo_servicio, $vin, $categoria, $anio_fabricacion, $carroceria, $bien_comb,$version) {
        $conectar = parent::conexion();
        parent::set_names();
        if (is_array($bien_comb)) {
            $bien_comb = '{' . implode(',', $bien_comb) . '}';
        }
        $sql = "UPDATE sc_inventario.tb_bien_detalle 
                SET ruta = ?, 
                    tipo_servicio = ?, 
                    vin = ?, 
                    categoria = ?, 
                    anio_fabricacion = ?, 
                    carroceria = ?,
                    bien_comb = ?,
                    version = ?
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ruta);
        $stmt->bindValue(2, $tipo_servicio, PDO::PARAM_INT); // aseguramos que sea un número
        $stmt->bindValue(3, $vin);
        $stmt->bindValue(4, $categoria);
        $stmt->bindValue(5, $anio_fabricacion, PDO::PARAM_INT);
        $stmt->bindValue(6, $carroceria);
        $stmt->bindValue(7, $bien_comb);
        $stmt->bindValue(8, $version); 
        $stmt->bindValue(9, $bien_id, PDO::PARAM_INT);
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
                    m.move_id AS tipo_servicio_id,
                    m.move_descripcion AS tipo_servicio,
                    b.vin,
                    b.categoria,
                    b.anio_fabricacion,
                    b.carroceria,
                    b.version,
                    array_agg(c.comb_nombre) AS combustibles
                FROM sc_inventario.tb_bien_detalle b
                LEFT JOIN sc_transporte.tb_modalidad_vehiculo m 
                    ON b.tipo_servicio = m.move_id
                JOIN LATERAL unnest(b.bien_comb) AS bc(comb_id) ON TRUE
                INNER JOIN sc_residuos_solidos.tb_combustible c 
                    ON c.comb_id = bc.comb_id
                WHERE b.bien_id = ?
                GROUP BY 
                    b.bien_id, b.ruta, m.move_id, m.move_descripcion,
                    b.vin, b.categoria, b.anio_fabricacion,
                    b.carroceria, b.version";
        
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
