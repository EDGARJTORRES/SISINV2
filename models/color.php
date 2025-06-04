<?php
class Color extends Conectar
{
    public function insert_color($color_nom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tb_color(color_nom,color_est) VALUES (?,1);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $color_nom);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_color($color_id, $color_nom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tb_color
                SET
                    color_nom = ?,
                WHERE
                    color_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $color_nom);
        $sql->bindValue(3, $color_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function delete_color($color_id){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tb_color
                SET
                    color_est = 0
                WHERE
                    color_id = ?";
        $stmt=$conectar->prepare($sql);
        $stmt->execute([$color_id]);
    }

    public function get_color()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tb_color WHERE color_est = 1 order by color_id asc";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_color_id($color_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tb_color WHERE color_est = 1 AND color_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $color_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
