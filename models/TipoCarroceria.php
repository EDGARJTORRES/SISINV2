<?php
class TipoCarroceria extends Conectar {
    public function listar_carrocerias() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT DISTINCT 
                    codigo,
                    carroceria
                FROM public.vista_tipos_carroceria
                ORDER BY carroceria ASC;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listar_categorias_por_carroceria($codigo) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT DISTINCT 
                    categoria
                FROM public.vista_tipos_carroceria
                WHERE codigo = ?
                ORDER BY categoria ASC;";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $codigo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
