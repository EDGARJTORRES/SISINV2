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
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                           FORMATO ASIGNACIÓN DE BIENES EN USO 
                        </div>
                        <h2 class="page-title" style="color:white;">
                          DESPLAZAMIENTO DE BIENES PARA EL SISTEMA DE INVENTARIO
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                          <a href="#" class="btn btn-outline-light d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalObjetoCate">
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
                                <label class="form-label">Área Origen:<span  style="color:red"> *</span></label>
                                <select class="form-select select2" id="area_or_id" name="area_or_id" data-placeholder="Seleccione Origen" style="width: 100%;">
                                  <option value="" disabled selected>Seleccione Origen</option>
                                  <option value="j">AREA DE EJECUCION PRESUPUESTAL - SEDE ADMINISTRATIVA</option>
                                  <option value="k">AREA DE DESARROLLO DE CAPACIDADES - SEDE ADMINISTRATIVA</option>
                                  <option value="l">AREA DE COOPERACION TECNICA INTERNACIONAL - SEDE ADMINISTRATIVA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                            <select class="form-select select2" id="area_de_id" name="area_de_id" data-placeholder="Seleccione Destino" style="width: 100%;">
                              <option value="" disabled selected>Seleccione</option>
                              <option value="j">AREA DE EJECUCION PRESUPUESTAL - SEDE ADMINISTRATIVA</option>
                              <option value="k">AREA DE DESARROLLO DE CAPACIDADES - SEDE ADMINISTRATIVA</option>
                              <option value="l">AREA DE COOPERACION TECNICA INTERNACIONAL - SEDE ADMINISTRATIVA</option>
                            </select>
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
                            <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                            <input type="number" min="0" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-3">
                              <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                              <input type="text" disabled=""  class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-3">
                            <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                            <input type="text" disabled=""  class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>   
                <div class="col-12">
                  <div class="card">
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
    <?php require_once("../html/mainjs.php"); ?>
 <script>
    $(document).ready(function() {
      $('#area_or_id').select2({
        theme: 'bootstrap4',
        width: '100%'
      });
      $('#area_de_id').select2({
        theme: 'bootstrap4',
        width: '100%'
      });
    });
  </script>
</body>
</html>
<?php
  } else {
    /* Si no a iniciado sesion se redireccionada a la ventana principal */
    header("Location:" . Conectar::ruta() . "view/404/");
  }
?>