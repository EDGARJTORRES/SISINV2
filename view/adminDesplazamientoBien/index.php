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
       .modal-header{
        background-color: #252422;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          border-color: #FF0000 transparent transparent transparent !important;
      }
    </style>
  </head>
<body data-bs-theme="light">
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-4">
                  <a href="../adminMain/">Inicio</a>
                  <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                  <span>Procesos</span>
                  <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                  <span>Dezplazamiento de Bienes</span>
                </nav>
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                          DESPLAZAMIENTO DE BIENES PARA EL SISTEMA DE INVENTARIO
                        </h2>
                    </div>
                </div>
                <div class="card  mb-4" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <form method="post"  id="desplazamiento_form">
                    <div class="modal-body">
                        <input type="hidden" name="pers_origen_id" id="pers_origen_id" />
                        <input type="hidden" name="pers_destino_id" id="pers_destino_id" />
                        <div class="card-body">
                           <div class="row">
                            <div class="col-lg-6">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                                    REGISTRO POR ANEXOS CREADOS <span class="text-secondary">(ORDENADOS POR FECHA)</span>
                                </h3>
                            </div>
                            <div class="col-auto ms-auto d-print-none">
                                <div class="btn-list">
                                  <button type="submit" name="action" value="add" class="btn btn-orange">
                                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                      Guardar
                                  </button>
                                  <button type="reset" class="btn btn-outline-secondary"    data-bs-dismiss="modal">
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
                                    <label class="form-label">Área Origen:<span  style="color:red"> *</span></label>
                                    <select class="form-select select2" id="area_origen_combo" name="area_origen_combo"data-placeholder="Seleccione Origen" style="width: 100%;">
                                      <option value="" disabled selected>Seleccione Origen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                                <select class="form-select select2" id="area_destino_combo" name="area_destino_combo" data-placeholder="Seleccione Destino" style="width: 100%;">
                                  <option value="" disabled selected>Seleccione</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                                <select class="form-select select2 required" id="pers_origen_dni"  name="pers_origen_dni" required>
                                <option value="" disabled selected>Seleccione</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                                <select class="form-select select2 required" id="pers_destino_dni" name="pers_destino_dni" required>
                                <option value="" disabled selected>Seleccione</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="mb-3">
                                  <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                                  <input type="text" id="pers_origen_nom" name="pers_origen_nom" disabled=""  class="form-control">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                                <input type="text" disabled=""  id="pers_destino_nom" name="pers_destino_nom"  class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </form>
                </div>
                <div class="col-12 mb-3">
                  <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                       LISTADO DE ANEXOS
                      </h3>
                    </div>
                    <div class="table-responsive m-4">
                      <table id="area_data"  class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                          <tr>
                            <th>Codigo de Barras</th>
                            <th>Objeto denominación</th>
                            <th>Color</th>
                            <th>Estado</th>
                            <th>Comentario</th>
                            <th>ver</th>
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
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <script type="text/javascript" src="desplazamiento.js"></script>
</body>
</html>
<?php
} else {
  /* Si no a iniciado sesion se redireccionada a la ventana principal */
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>