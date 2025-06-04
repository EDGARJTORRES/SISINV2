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
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
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
        background-color: rgba(0, 0, 0, 0.25) !important;
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(4px);
      }
      .swal2-popup {
        background: rgb(255, 255, 255) !important;
        box-shadow: rgba(24, 36, 51, 0.04) 0 2px 4px 0 !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          border-color: #FF0000 transparent transparent transparent !important;
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
      .modal-header{
        background-color: #252422;
      }
    </style>
  </head>
<body >
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
              <nav class="breadcrumb mb-4">
                <a href="../adminMain/">Inicio</a>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Procesos</span>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Asignación de Bienes</span>
              </nav>
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                          ASIGNACIÓN DE BIENES PARA EL SISTEMA DE INVENTARIO
                        </h2>
                    </div>
                </div>
                <div class="card  mb-4"  style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6">
                          <h3 class="card-title">
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                             REGISTRO POR ANEXO CREADO <span class="text-secondary">(ORDENADOS POR FECHA)</span>
                          </h3>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                          <div class="btn-list">
                          <button type="submit" name="action" value="add" onclick="nuevoFormato()" class="btn btn-orange">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                Guardar
                            </button>
                          <button type="reset" class="btn btn-outline-secondary">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                Cancelar
                          </button>
                          </div>
                        </div>
                      </div>
                      <hr class="w-3/5 mx-auto border-t border-gray-300" />
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
                                <button type="button" class="btn btn-info w-100 bg-red  px-2 d-flex align-items-center justify-content-center gap-1" id="buscaObjeto" onclick="buscarBien()">
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
                                    <button type="button" class="btn btn-info w-100 bg-red  px-2 d-flex align-items-center justify-content-center gap-1"  id="btnCamara" onclick="activarCamara()">
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
                                <label class="form-label">DNI Representante:<span style="color:red"> *</span></label>
                                <select class="form-select select2 required" id="pers_dni_combo" name="pers_dni_combo" required>
                                    <option value="" disabled selected>Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Representante:<span style="color:red"> *</span></label>
                                <input type="text" class="form-control" id="pers_nom" name="pers_nom" placeholder="Nombre Representante" required readonly>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="card mb-3"  style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        LISTADO DE ANEXOS
                      </h3>
                    </div>
                    <div class="card-body">
                       <div class="col-12">
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
        </div>  
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalobjgg.php"); ?>
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