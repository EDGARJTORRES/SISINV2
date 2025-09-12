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

        $ruta             = ($ruta === "") ? null : $ruta;
        $clase_vehiculo   = ($clase_vehiculo === "") ? null : (int)$clase_vehiculo;
        $vin              = ($vin === "") ? null : $vin;
        $categoria        = ($categoria === "") ? null : $categoria;
        $anio_fabricacion = ($anio_fabricacion === "") ? null : (int)$anio_fabricacion;
        $tipo_carroceria  = ($tipo_carroceria === "") ? null : $tipo_carroceria;
        $version          = ($version === "") ? null : $version;

        if (!is_array($bien_comb)) {
            $bien_comb = [];
        }
        $bien_comb_pg = count($bien_comb) > 0
            ? '{' . implode(',', array_map('intval', $bien_comb)) . '}'
            : null;

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
        $stmt->bindValue(1, $ruta,             is_null($ruta)             ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(2, $clase_vehiculo,   is_null($clase_vehiculo)   ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(3, $vin,              is_null($vin)              ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(4, $categoria,        is_null($categoria)        ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(5, $anio_fabricacion, is_null($anio_fabricacion) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(6, $tipo_carroceria,  is_null($tipo_carroceria)  ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(7, $bien_comb_pg,     is_null($bien_comb_pg)     ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(8, $version,          is_null($version)          ? PDO::PARAM_NULL : PDO::PARAM_STR);
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
        $nro_motor   = ($nro_motor === "") ? null : $nro_motor;
        $ruedas      = ($ruedas === "") ? null : (int)$ruedas;
        $cilindros   = ($cilindros === "") ? null : (int)$cilindros;
        $cilindrada  = ($cilindrada === "") ? null : $cilindrada;
        $potencia    = ($potencia === "") ? null : $potencia;
        $form_rodaje = ($form_rodaje === "") ? null : $form_rodaje;
        $ejes        = ($ejes === "") ? null : (int)$ejes;
        $stmt->bindValue(1, $nro_motor,   is_null($nro_motor)   ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(2, $ruedas,      is_null($ruedas)      ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(3, $cilindros,   is_null($cilindros)   ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(4, $cilindrada,  is_null($cilindrada)  ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(5, $potencia,    is_null($potencia)    ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(6, $form_rodaje, is_null($form_rodaje) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(7, $ejes,        is_null($ejes)        ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(8, $bien_id,     PDO::PARAM_INT);
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
        $pasajero   = ($pasajero === "") ? null : (int)$pasajero;
        $asiento    = ($asiento === "") ? null : (int)$asiento;
        $peso_neto  = ($peso_neto === "") ? null : $peso_neto;
        $carga_util = ($carga_util === "") ? null : $carga_util;
        $peso_bruto = ($peso_bruto === "") ? null : $peso_bruto;
        $stmt->bindValue(1, $pasajero,   is_null($pasajero) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(2, $asiento,    is_null($asiento)  ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(3, $peso_neto,  is_null($peso_neto) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(4, $carga_util, is_null($carga_util) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(5, $peso_bruto, is_null($peso_bruto) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(6, $bien_id,    PDO::PARAM_INT);
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
