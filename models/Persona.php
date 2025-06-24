<?php
class Persona extends Conectar
{
    public function get_persona_dni($pers_dni)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
        pers_id,
        pers_dni,
        pers_apelpat || ' ' || pers_apelmat || ', ' || pers_nombre AS nombre_completo
    FROM 
        sc_escalafon.tb_persona
    WHERE 
        pers_dni = ? ;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $pers_dni);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_all_dnis() {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT pers_id, pers_dni ,pers_nombre , pers_apelpat,pers_apelmat FROM sc_escalafon.tb_persona ORDER BY pers_dni ASC;";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function obtenerDatosGenerales($pers_id) {
    $conectar = parent::conexion();
    $sql = "SELECT 
                pers_id,
                pers_dni,
                pers_ruc,
                pers_apelpat,
                pers_apelmat,
                pers_nombre,
                pers_emailp,
                pers_emailm,
                pers_clave,
                pers_telefijo,
                pers_celu01,
                pers_estado_civil,
                pers_sexo,
                pers_grupo,
                pers_foto
            FROM sc_escalafon.tb_persona
            WHERE pers_id = ?";
    
    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $pers_id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si existe una foto, prepende el encabezado base64
    if ($data && !empty($data['pers_foto'])) {
        $data['pers_foto'] = 'data:image/jpeg;base64,' . $data['pers_foto'];
    }

    return $data;
    
    }
    public function get_personas_combo() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    pers_id,
                    pers_dni,
                    pers_apelpat || ' ' || pers_apelmat || ', ' || pers_nombre AS nombre_completo
                FROM 
                    sc_escalafon.tb_persona
                ORDER BY pers_apelpat, pers_apelmat, pers_nombre ASC";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
