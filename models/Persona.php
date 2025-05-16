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



}
