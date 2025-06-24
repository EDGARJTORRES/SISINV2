<?php
class Clase extends Conectar
{

    public function insert_clase($clase_nom, $clase_cod)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO sc_inventario.tb_clase(clase_nom,clase_cod,clase_est) VALUES (?,?,1);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $clase_nom);
        $sql->bindValue(2, $clase_cod);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_clase($clase_id, $clase_nom, $clase_cod)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_clase
                SET
                    clase_nom = ?,
                    clase_cod =?
                WHERE
                    clase_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $clase_nom);
        $sql->bindValue(2, $clase_cod);
        $sql->bindValue(3, $clase_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function delete_clase($clase_id){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_clase
                SET
                    clase_est = 0
                WHERE
                    clase_id = ?";
        $stmt=$conectar->prepare($sql);
        $stmt->execute([$clase_id]);
    }

    public function get_clase()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_inventario.tb_clase WHERE clase_est = 1 order by clase_id asc";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_clase_combo($gg_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_inventario.tb_grupo_clase tgc
            inner join sc_inventario.tb_clase tbc on tbc.clase_id = tgc.clase_id
            where gg_id = ? and est = 1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $gg_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_clase_id($clase_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM sc_inventario.tb_clase WHERE clase_est = 1 AND clase_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $clase_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insert_clase_usu($clase_id, $pers_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO sc_inventario.td_claseusu(claseusu_usu, claseusu_clase, clase_est) VALUES (?, ?, 1) RETURNING claseusu_id";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $pers_id);
        $stmt->bindValue(2, $clase_id);
        $stmt->execute();


        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }
    public function eliminar_clase_usu($claseusu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.td_claseusu
                SET
                    clase_est = 0
                WHERE
                    claseusu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $claseusu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function quitarclase($gc_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE sc_inventario.tb_grupo_clase
                SET
                    est = 0
                WHERE
                gc_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $gc_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
