<?php
class DetalleBien extends Conectar {
    public function get_detalle_bien_x_id($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    bien_detalle_id,
                    bien_id,
                    placa,
                    ruta,
                    tipo_movilidad,
                    categoria,
                    anio_fabricacion,
                    peso_neto,
                    carga_util,
                    peso_bruto,
                    ruedas,
                    cilindros,
                    ejes,
                    nro_motor,
                    pasajeros,
                    asientos,
                    carroceria,
                    comb_id
                FROM 
                    sc_inventario.tb_bien_detalle
                WHERE 
                    bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizar_detalle_bien(
        $bien_id, $placa, $ruta, $tipo_movilidad, $categoria, $anio_fabricacion,
        $peso_neto, $carga_util, $peso_bruto, $ruedas, $cilindros, $ejes,
        $nro_motor, $pasajeros, $asientos, $carroceria, $comb_id
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien_detalle
                SET placa=?, ruta=?, tipo_movilidad=?, categoria=?, anio_fabricacion=?, 
                    peso_neto=?, carga_util=?, peso_bruto=?, ruedas=?, cilindros=?, ejes=?, 
                    nro_motor=?, pasajeros=?, asientos=?, carroceria=?, comb_id=?
                WHERE bien_id=?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $placa);
        $stmt->bindValue(2, $ruta);
        $stmt->bindValue(3, $tipo_movilidad);
        $stmt->bindValue(4, $categoria);
        $stmt->bindValue(5, $anio_fabricacion);
        $stmt->bindValue(6, $peso_neto);
        $stmt->bindValue(7, $carga_util);
        $stmt->bindValue(8, $peso_bruto);
        $stmt->bindValue(9, $ruedas);
        $stmt->bindValue(10, $cilindros);
        $stmt->bindValue(11, $ejes);
        $stmt->bindValue(12, $nro_motor);
        $stmt->bindValue(13, $pasajeros);
        $stmt->bindValue(14, $asientos);
        $stmt->bindValue(15, $carroceria);
        $stmt->bindValue(16, $comb_id);
        $stmt->bindValue(17, $bien_id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
?>
