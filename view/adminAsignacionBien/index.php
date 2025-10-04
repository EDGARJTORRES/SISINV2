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
  <link href="../../public/css/loader.css" rel="stylesheet"/>
  <link href="../../public/css/asignacionBien.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
  <link href="../../public/css/sinasignacion.css" rel="stylesheet"/>
  <link href="../../public/css/loader.css" rel="stylesheet"/>
  <link href="../../public/css/alta.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  </head>
<body >
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
              <nav class="breadcrumb mb-3">
                <a href="../adminMain/">Inicio</a>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span class="breadcrumb-item active">Procesos</span>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Asignación de Bienes</span>
              </nav>
              <div class="row g-2 mb-3 align-items-center">
                <div class="col">
                  <h2 class="page-title mb-0">
                    ASIGNACIÓN DE BIENES PARA EL SISTEMA DE INVENTARIO
                  </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list"> 
                    <button class="btn btn-6 btn-light btn-izquierdo" type="reset" onclick="resetCampos()" 
                          title="Cancelar y limpiar todos los campos del formulario" 
                          class="button">
                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-details"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 5h8" /><path d="M13 9h5" /><path d="M13 15h8" /><path d="M13 19h5" /><path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /></svg>
                        CANCELAR
                    </button>
                  </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                    <button class="btn btn-6 btn-primary btn-derecho" value="add" 
                          onclick="nuevoFormato()" 
                          title="Guardar asignación del bien patrimonial" 
                          class="button">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                        CREAR ASIGNACIÓN
                    </button>
                  </div>
                </div>
              </div>
              <div class="card border-0  mb-4"  style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="card-status-start bg-primary"></div>
                <div class="card-header">
                  <div class="row">
                      <div class="col-lg-12">
                        <h3 class="card-title">
                            <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                            REGISTRO POR ANEXO CREADO <span class="text-secondary">(ORDENADOS POR FECHA)</span>
                        </h3>
                      </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6">
                          <div class="mb-3">
                          <label class="form-label">Área / Dependencia Destino:<span style="color:red"> *</span></label>
                          <select class="form-select select2" id="area_asignacion_combo" name="area_asignacion_combo"  data-placeholder="- Seleccione Destino -" style="width: 100%;">
                          <option value="" disabled selected>Seleccione</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="mb-3">
                          <div class="row">
                              <div class="col-12">
                              <input type="hidden" name="pers_id" id="pers_id" />
                              <label class="form-label">Código de Barras:<span style="color:red"> *</span></label>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-5">
                              <input type="text" class="form-control" id="cod_bar" name="cod_bar" placeholder="Ingresa el código de barras...">
                              </div>
                              <div class="col-3 d-flex align-items-center">
                              <button type="button" class="btn btn-dark w-100 px-2 d-flex align-items-center justify-content-center gap-1" id="buscaObjeto" onclick="buscarBien()">
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
                              <div class="col-4 d-flex align-items-center">
                                <button type="button" class="btn btn-outline-dark w-100 px-2 d-flex align-items-center justify-content-center gap-1"  id="add_button"  onclick="bien_sin_asignacion()"
                                         title="Ir al módulo de bienes sin asignación" >
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-camera-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.5 20h-8.5a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v4" /><path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                  <span>Bienes Nuevos</span>
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
                              <input type="text" class="form-control" id="pers_dni" name="pers_dni" placeholder="Ingresa el DNI del representante del bien..." required oninput="limitarADigitosDNI(this)">
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
                <div class="card mb-3 border-0"  style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header">
                    <h3 class="card-title">
                      <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
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
    <div id="page">
      <div id="container">
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div id="ring"></div>
          <div style="display: flex; z-index:1000; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
            <img src="../../static/illustrations/logo_mpch.png" height="90" width="90" alt="Municipal logo " />
              <h3></h3>
            <h3 class="titulo">Generando Asignacion...</h3>
          </div>
      </div>
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainJs.php"); ?>
    <?php require_once("modal_bienes_sin_asignacion.php"); ?>
    <script type="text/javascript" src="color.js"></script>
    <script type="text/javascript" src="alerts.js"></script>
    <script type="text/javascript" src="adminAsignacionBien.js"></script>
    <script type="text/javascript" src="bienSinAsignacion.js"></script>
    <script type="text/javascript" src="dni.js"></script>
    <script type="text/javascript" src="imprimir.js"></script>
    <script type="text/javascript" src="init.js"></script>
    <script type="text/javascript" src="modal.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>