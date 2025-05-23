<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AsignacionBienes</title>
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <style>
      div.dataTables_filter {
      display: none !important;
    }
    th{
    color: #0054a6 !important;
    }
    th, td {
      max-width: 170px !important;     
      white-space: normal;      
      word-break: break-word;   
      overflow-wrap: break-word; 
      vertical-align: middle;  
    }
    .swal2-container {
      background: rgba(255, 255, 255, 0.05) !important;
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
    .swal2-popup {
      background: rgb(255, 255, 255) !important;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.27) !important;
    }
      .tabler-loader {
        animation: spin 1s linear infinite;
        width: 24px;
        height: 24px;
        stroke-width: 2;
        stroke: currentColor;
      }

      @keyframes spin {
        100% { transform: rotate(360deg); }
      }
    </style>
  </head>
<body >
    <?php require_once("../html/mainProfile2.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                          FORMATO ASIGNACIÓN DE BIENES EN USO
                        </div>
                        <h2 class="page-title">
                          ASIGNACION DE BIENES PARA EL SISTEMA DE INVENTARIO
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" type="button" class="btn btn-outline-dark d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#">
                         <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M18.364 5.636l-12.728 12.728" /></svg>
                               Cancelar
                            </a>
                        </div>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalObjetoCate">
                           <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                            Guardar Formato
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        Registro por Anexos creado <span class="text-secondary">(Ordenados por fecha)</span>
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                            <select class="form-select select2" id="area_asignacion_combo" name="area_asignacion_combo"  data-placeholder="Seleccione Destino" style="width: 100%;">
                            <option value="" disabled selected>Seleccione</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <div class="row">
                              <div class="col-12">
                                <label class="form-label">Código de Barras:<span style="color:red"> *</span></label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-6">
                                <input type="text" class="form-control" id="cod_bar" name="cod_bar">
                              </div>
                              <div class="col-3 d-flex align-items-center">
                                <button type="button" class="btn btn-info w-100 bg-blue  px-2 d-flex align-items-center justify-content-center gap-1" id="buscaObjeto" onclick="buscarBien()">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                    <path d="M18.5 19.5l2.5 2.5" />
                                  </svg>
                                  <span>Buscar</span>
                                </button>
                              </div>
                               <div class="col-3 d-flex align-items-center">
                                  <button type="button" class="btn btn-info w-100 bg-blue  px-2 d-flex align-items-center justify-content-center gap-1"  id="btnCamara" onclick="activarCamara()">
                                     <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-camera-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.5 20h-8.5a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v4" /><path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                  <span> Escanear</span>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                                <input type="number" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                                <input type="text" id="pers_nom" name="pers_nom" disabled="" class="form-control">
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>   
                <div class="col-12">
                  <div class="card">
                    <div class="table-responsive m-4">
                      <table id="obj_formato"  class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                          <tr>
                            <th>Codigo de Barras</th>
                            <th>Objeto denominación</th>
                            <th>Color</th>
                            <th>Estado</th>
                            <th>Comentario</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>  
    </div>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalobjgg.php"); ?>
    <?php require_once("modalObjetoCate.php"); ?>
    <?php require_once("modalFormato.php"); ?>
    <script type="text/javascript" src="adminAsignacionBien.js"></script>
    <script type="text/javascript" src="formato.js"></script>
    <script type="text/javascript" src="asignacion.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>