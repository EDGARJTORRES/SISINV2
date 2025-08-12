<?php
require_once("../config/conexion.php");
require_once("../models/Documento.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$documento = new Documento();
switch ($_GET["op"]) {
    case "guardaryeditar":
        if (isset($_FILES['archivo_pdf']['name']) && !empty($_FILES['archivo_pdf']['name'])) {
            $nombre_archivo = $_FILES['archivo_pdf']['name'];
            $temp_archivo = $_FILES['archivo_pdf']['tmp_name'];

            $ruta_destino = "../doc/" . $nombre_archivo;
            $ruta_db = "doc/" . $nombre_archivo; // Esto se guarda en doc_ruta

            if (!move_uploaded_file($temp_archivo, $ruta_destino)) {
                echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo subir el archivo']);
                exit();
            }
        } else {
          
            $ruta_db = $_POST['doc_ruta'];
        }

        if (empty($_POST["doc_id"])) {
            $documento->insert_documento(
                $_POST["doc_tipo"],
                $_POST["depe_id"],
                $_POST["doc_desc"],
                $ruta_db,
                $_POST["pers_id"]
            );
        } else {
            $documento->update_documento(
                $_POST["doc_id"],
                $_POST["doc_tipo"],
                $_POST["depe_id"],
                $_POST["doc_desc"],
                $ruta_db,
                $_POST["pers_id"]
            );
        }

        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;


    case "mostrar":
        $row = $documento->get_documento_por_id($_POST["doc_id"]);
        if (is_array($row)) {
            $output["doc_id"]   = $row["doc_id"];
            $output["doc_tipo"] = $row["doc_tipo"];
            $output["depe_id"]  = $row["depe_id"];
            $output["doc_desc"] = $row["doc_desc"];
            $output["doc_ruta"] = $row["doc_ruta"];
            $output["pers_id"]  = $row["pers_id"];
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $documento->delete_documento($_POST["doc_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "get_documentos_firmados":
        $datos = $documento->get_documentos_firmados();
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = htmlspecialchars($row["doc_tipo"]);
            $sub_array[] = htmlspecialchars($row["depe_info"]);
            $sub_array[] = ucwords(strtolower(htmlspecialchars($row["nombre_completo"])));
            $sub_array[] = htmlspecialchars($row["doc_desc"]);
            $sub_array[] = '<span class="badge bg-blue-lt">' . date("d/m/Y H:i", strtotime($row["fecha_carga"])) . '</span>';
            $ruta = ltrim($row["doc_ruta"], "/");
            $doc_id = intval($row["doc_id"]);

            // Acciones: Editar y Eliminar con íconos
            $acciones = '
            <div class="dropdown">
                <a class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    Acciones
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" onclick="verDocumento(\'' . $row["doc_ruta"] . '\')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                        Ver Documento
                    </a>
                    <a class="dropdown-item" href="#" onclick="editarDocumento(' . $doc_id . ')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        Editar
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="eliminarDocumento(' . $doc_id . ')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-backspace mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" /></svg>
                        Eliminar
                    </a>
                </div>
            </div>';

            $sub_array[] = $acciones;
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results);
        break;
}
