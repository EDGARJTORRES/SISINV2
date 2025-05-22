<?php
class Bien extends Conectar{
    public function get_contador_bien_estado() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    bien_est AS estado,
                    COUNT(*) AS cantidad
                FROM 
                    sc_inventario.tb_bien
                GROUP BY 
                    bien_est
                ORDER BY 
                    bien_est;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_ultimo_bien(){
    $conectar = parent::conexion(); 
    parent::set_names();
    $sql = 
            "SELECT o.obj_nombre
        FROM sc_inventario.tb_bien b
        JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
        ORDER BY b.fecharegistro DESC
        LIMIT 1;";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    }

}
