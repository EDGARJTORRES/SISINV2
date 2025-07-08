<?php
class Bien extends Conectar {

    // Contador de bienes por estado, excluyendo los inactivos y erróneos
    public function get_contador_bien_estado() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    bien_est AS estado,
                    COUNT(*) AS cantidad
                FROM 
                    sc_inventario.tb_bien
                WHERE 
                    bien_est NOT IN ('I', 'E')
                GROUP BY 
                    bien_est
                ORDER BY 
                    bien_est;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Último bien registrado
    public function get_ultimo_bien() {
        $conectar = parent::conexion(); 
        parent::set_names();
        $sql = "SELECT o.obj_nombre
                FROM sc_inventario.tb_bien b
                INNER JOIN sc_inventario.tb_objeto o ON b.obj_id = o.obj_id
                WHERE b.bien_est NOT IN ('I', 'E')
                ORDER BY b.fechacrea DESC
                LIMIT 1;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Total del valor de adquisición (solo bienes válidos)
    public function get_total_y_variacion_adquisicion() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    SUM(val_adq::numeric) AS total_actual
                FROM 
                    sc_inventario.tb_bien
                WHERE 
                    bien_est NOT IN ('I', 'E');";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Total de bienes (excluyendo 'I' y 'E')
    public function get_total_bien() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    COUNT(*) AS total_bienes
                FROM 
                    sc_inventario.tb_bien
                WHERE 
                    bien_est NOT IN ('I', 'E');";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bienes sin dependencia, excluyendo inactivos y erróneos
    public function get_bienes_sin_dependencia() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT b.*, o.obj_nombre
                FROM sc_inventario.tb_bien AS b
                LEFT JOIN sc_inventario.tb_bien_dependencia AS bd ON b.bien_id = bd.bien_id
                LEFT JOIN sc_inventario.tb_objeto AS o ON b.obj_id = o.obj_id
                WHERE bd.bien_id IS NULL
                AND b.bien_est NOT IN ('I', 'E');";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Valores de adquisición total y baja, separando correctamente
    public function get_valores_adquisicion_y_baja() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    (SELECT COALESCE(SUM(val_adq)::numeric, 0)
                     FROM sc_inventario.tb_bien 
                     WHERE bien_est NOT IN ('I', 'E')) AS total_adquisicion,

                    (SELECT COALESCE(SUM(b.val_adq)::numeric, 0)
                     FROM sc_inventario.tb_bien b
                     WHERE b.bien_est = 'I'
                     AND EXISTS (
                        SELECT 1 
                        FROM sc_inventario.tb_bien_dependencia bd
                        WHERE bd.bien_id = b.bien_id
                        AND bd.biendepe_est = 1
                    )) AS total_baja;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Eliminación total (para registros erróneos)
    public function delete_bien_erroneo($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien
                SET bien_est = 'E'
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Baja de bien (con historial, etc.)
    public function dar_baja_bien($bien_id) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_bien
                SET bien_est = 'I'
                WHERE bien_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $bien_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
