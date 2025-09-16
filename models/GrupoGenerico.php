<?php
    class GrupoGenerico extends Conectar{
        public function insert_grupogenerico($gg_nom, $gg_cod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO sc_inventario.tb_grupogenerico(gg_nom, gg_cod) VALUES (?,?);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_nom);
            $sql->bindValue(2, $gg_cod);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function update_grupogenerico($gg_id,$gg_nom, $gg_cod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_grupogenerico
                SET
                gg_nom = ?,
                gg_cod = ?
                WHERE
                    gg_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_nom);
            $sql->bindValue(2, $gg_cod);
            $sql->bindValue(3, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_clase_modal($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_clase
                            WHERE clase_est = 1
                            AND clase_id not in (select clase_id from sc_inventario.tb_grupo_clase where gg_id=? AND est=1)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_gg_clase($gg_id, $clase_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.tb_grupo_clase(clase_id, gg_id, est) VALUES (?, ?, 1) RETURNING gc_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $clase_id);
            $stmt->bindValue(2, $gg_id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function delete_grupogenerico($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.tb_grupogenerico
                SET
                gg_est = 0
                WHERE
                gg_id = ?";
            $stmt=$conectar->prepare($sql);
            $stmt->execute([$gg_id]);
        }
        public function get_grupogenerico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT *
            FROM sc_inventario.tb_grupogenerico where gg_est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_grupogenerico_bienes_paginado($start, $length, $search = '') {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "
                SELECT 
                    tbb.bien_id, 
                    tob.obj_nombre, 
                    tbb.fecharegistro, 
                    tbb.bien_codbarras, 
                    tbb.bien_est,
                    tcc.cuenta_numero, 
                    tbb.val_adq, 
                    tc.clase_cod, 
                    gg.gg_cod
                FROM sc_inventario.tb_bien tbb
                LEFT JOIN sc_inventario.tb_objeto tob ON tob.obj_id = tbb.obj_id
                LEFT JOIN sc_inventario.tb_grupo_clase gc ON gc.gc_id = tob.gc_id
                INNER JOIN sc_inventario.tb_clase tc ON gc.clase_id = tc.clase_id
                INNER JOIN sc_inventario.tb_grupogenerico gg ON gc.gg_id = gg.gg_id
                LEFT JOIN sc_inventario.tb_bien_dependencia tbd ON tbb.bien_id = tbd.bien_id
                LEFT JOIN sc_inventario.tb_cuenta_contable tcc ON tcc.cuenta_id = tbb.bien_cuenta
                WHERE tbb.bien_est NOT IN ('I', 'E')
            ";

            // BÃºsqueda
            if (!empty($search)) {
                $sql .= " AND (
                    LOWER(tob.obj_nombre) LIKE LOWER(:search) OR
                    LOWER(tbb.bien_codbarras) LIKE LOWER(:search) OR
                    LOWER(tc.clase_cod) LIKE LOWER(:search) OR
                    LOWER(gg.gg_cod) LIKE LOWER(:search)
                )";
            }

            $sql .= " ORDER BY tbb.bien_id DESC LIMIT :length OFFSET :start";
            $stmt = $conectar->prepare($sql);

            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            $stmt->bindValue(':length', intval($length), PDO::PARAM_INT);
            $stmt->bindValue(':start', intval($start), PDO::PARAM_INT);

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Construir data como array para DataTables
            $data = array();
            foreach ($results as $row) {
                $sub_array = array();
                $sub_array[] = $row["bien_id"];
                $sub_array[] = '
                    <label class="checkbox-wrapper-46">
                        <input type="checkbox" class="inp-cbx gb-checkbox" data-id="' . htmlspecialchars($row["bien_id"]) . '" value="' . htmlspecialchars($row["bien_id"]) . '" />
                        <span class="cbx">
                            <span><svg viewBox="0 0 12 10" height="10px" width="12px"><polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span>
                            <span></span>
                        </span>
                    </label>';
                $sub_array[] = '<span class="badge bg-cyan text-cyan-fg selectable copiar-codbarras" data-codigo="' . $row["bien_codbarras"] . '">' . $row["bien_codbarras"] . '</span>';
                $sub_array[] = $row["obj_nombre"];
                $sub_array[] = date("Y-m-d", strtotime($row["fecharegistro"]));
                $sub_array[] = $row["gg_cod"];
                $sub_array[] = $row["clase_cod"];

                $estado = strtolower($row["bien_est"]);
                switch ($estado) {
                    case 'n': $badge_class = 'bg-purple-lt'; $estado_text = 'Nuevo'; break;
                    case 'r': $badge_class = 'bg-orange-lt'; $estado_text = 'Regular'; break;
                    case 'm': $badge_class = 'bg-red-lt'; $estado_text = 'Malo'; break;
                    case 'b': $badge_class = 'bg-green-lt'; $estado_text = 'Bueno'; break;
                    default:  $badge_class = 'bg-secondary-lt'; $estado_text = 'Inactivo';
                }
                $sub_array[] = '<span class="d-inline-block ' . $badge_class . ' text-white text-center px-0 py-0 rounded-pill" style="min-width: 70px;">' . $estado_text . '</span>';

                $sub_array[] = $row["cuenta_numero"]; 
                $sub_array[] = $row["val_adq"]; 

                $sub_array[] = '
                    <td class="text-end">
                        <div class="dropdown">
                            <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Acciones</a>
                            <div class="dropdown-menu dropdown-menu-end">
                               <a href="#" class="dropdown-item" onclick="imprimirBien(' . $row['bien_id'] . ')">
  				<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer mx-1 text-success" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
  				   <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
				   <path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" />
 				   <path d="M6 18h12" />
 				   <path d="M6 14h12" />
 				   <path d="M9 18v3h6v-3" />
 				   <path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" />
 				 </svg>
  				Imprimir
			      </a>
			      <a href="#" class="dropdown-item " onclick="editarBien(' . $row['bien_id'] . ')">
  				<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit mx-1 text-warning" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
 				   <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
				   <path d="M9 7h-2a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-2" />
  				   <path d="M16.5 6.5l-9 9" />
  				   <path d="M18 7l-1.5 -1.5" />
  				</svg>
 				 Editar
			       </a>
			       <a href="#" class="dropdown-item text-danger" onclick="eliminarBien(' . $row['bien_id'] . ')">
  				<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash mx-1 text-danger" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   				  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
   				  <path d="M4 7h16" />
  				  <path d="M10 11v6" />
 				  <path d="M14 11v6" />
 				  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
  				</svg>
                                  Eliminar
			        </a>
                            </div>
                        </div>
                    </td>';
                
                $data[] = $sub_array;
            }

            return $data;
        }

        public function get_total_bienes() {
            $conectar = parent::conexion();
            parent::set_names();
            $stmt = $conectar->prepare("SELECT COUNT(*) FROM sc_inventario.tb_bien WHERE bien_est NOT IN ('I','E')");
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        public function get_total_bienes_filtrado($search = '') {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "SELECT COUNT(*) 
                    FROM sc_inventario.tb_bien tbb
                    LEFT JOIN sc_inventario.tb_objeto tob ON tob.obj_id = tbb.obj_id
                    LEFT JOIN sc_inventario.tb_grupo_clase gc ON gc.gc_id = tob.gc_id
                    INNER JOIN sc_inventario.tb_clase tc ON gc.clase_id = tc.clase_id
                    INNER JOIN sc_inventario.tb_grupogenerico gg ON gc.gg_id = gg.gg_id
                    WHERE tbb.bien_est NOT IN ('I','E')";

            if (!empty($search)) {
                $sql .= " AND (
                    LOWER(tob.obj_nombre) LIKE LOWER(:search) OR
                    LOWER(tbb.bien_codbarras) LIKE LOWER(:search) OR
                    LOWER(tc.clase_cod) LIKE LOWER(:search) OR
                    LOWER(gg.gg_cod) LIKE LOWER(:search)
                )";
            }

            $stmt = $conectar->prepare($sql);
            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchColumn();
        }


        public function get_grupogenerico_id($gg_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM sc_inventario.tb_grupogenerico WHERE gg_est = 1 AND gg_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $gg_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function insert_grupogenerico_usu($gg_id, $pers_id) {
            $conectar = parent::conexion();
            parent::set_names();            
            $sql = "INSERT INTO sc_inventario.td_grupogenericousu(grupogenericousu_usu, grupogenericousu_grupogenerico, gg_est) VALUES (?, ?, 1) RETURNING grupogenericousu_id";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $pers_id);
            $stmt->bindValue(2, $gg_id);
            $stmt->execute();
        
           
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $resultado;
        }
        public function eliminar_grupogenerico_usu($grupogenericousu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE sc_inventario.td_grupogenericousu
                SET
                    gg_est = 0
                WHERE
                    grupogenericousu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $grupogenericousu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }      
    }
?>