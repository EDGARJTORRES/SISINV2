<?php
class Modelo extends Conectar {

    public function insert_modelo($modelo_nom, $marca_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO sc_inventario.tb_modelo (modelo_nom, marca_id) VALUES (?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $modelo_nom);
        $stmt->bindValue(2, $marca_id);
        $result = $stmt->execute();
        return $result; 
    }

    public function update_modelo($modelo_id, $modelo_nom, $marca_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_modelo
                SET modelo_nom = ?, marca_id = ?
                WHERE modelo_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $modelo_nom);
        $stmt->bindValue(2, $marca_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $modelo_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result; // true si fue exitoso
    }

    public function delete_modelo($modelo_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_modelo
                SET modelo_est = 0
                WHERE modelo_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $modelo_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result; // true si fue exitoso
    }

    public function get_modelo() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    m.modelo_id, 
                    m.modelo_nom, 
                    m.modelo_est, 
                    m.marca_id,
                    ma.marca_nom
                FROM sc_inventario.tb_modelo m
                INNER JOIN sc_inventario.tb_marca ma ON m.marca_id = ma.marca_id
                WHERE m.modelo_est = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_modelo_id($modelo_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    m.modelo_id,
                    m.modelo_nom,
                    m.marca_id,
                    c.marca_nom
                FROM sc_inventario.tb_modelo m
                JOIN sc_inventario.tb_marca c ON m.marca_id = c.marca_id
                WHERE m.modelo_id = ?
                LIMIT 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $modelo_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
