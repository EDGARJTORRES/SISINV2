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
                <div class="col-auto d-flex flex-wrap justify-content-end gap-2">
                  <!-- Guardar -->
                  <button type="submit" name="action" value="add" onclick="nuevoFormato()" 
                          title="Guardar asignación del bien patrimonial" 
                          class="button"
                          style="--clr: #00ad54; border-left:1px solid #00ad54;">
                    <span class="button-decor"></span>
                    <div class="button-content">
                      <div class="button__icon">
                        <!-- SVG Guardar -->
                        <svg viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg" width="24">
                          <circle opacity="0.5" cx="23" cy="23" r="23" fill="url(#gradSave)" />
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M34.42 15.93c.382-1.145-.706-2.234-1.851-1.852l-18.568 6.189c-1.186.395-1.362 2-.29 2.644l5.12 3.072a1.464 1.464 0 001.733-.167l5.394-4.854a1.464 1.464 0 011.958 2.177l-5.154 4.638a1.464 1.464 0 00-.276 1.841l3.101 5.17c.644 1.072 2.25.896 2.645-.29L34.42 15.93z"
                            fill="#fff" />
                          <defs>
                            <linearGradient id="gradSave" x1="23" y1="0" x2="23" y2="46" gradientUnits="userSpaceOnUse">
                              <stop stop-color="#fff" stop-opacity="0.71"></stop>
                              <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                            </linearGradient>
                          </defs>
                        </svg>
                      </div>
                      <span class="button__text">Guardar</span>
                    </div>
                  </button>

                  <!-- Cancelar -->
                  <button type="reset" onclick="resetCampos()" 
                          title="Cancelar y limpiar todos los campos del formulario" 
                          class="button"
                          style="--clr: #00c2c5;">
                    <span class="button-decor"></span>
                    <div class="button-content">
                      <div class="button__icon">
                        <!-- SVG Cancelar -->
                        <svg viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg" width="24">
                          <circle opacity="0.5" cx="23" cy="23" r="23" fill="url(#gradCancel)" />
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M35.65 15.354L23 8.05l-12.65 7.303V29.96L23 37.264l12.65-7.304V15.353zm-1.512 3.02l-9.988 4.994v9.912h-2.3v-9.933L12.5 18.36l1.082-2.03 9.435 5.033 10.092-5.046 1.029 2.057z"
                            fill="#fff" />
                          <defs>
                            <linearGradient id="gradCancel" x1="23" y1="0" x2="23" y2="46" gradientUnits="userSpaceOnUse">
                              <stop stop-color="#fff" stop-opacity="0.71"></stop>
                              <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                            </linearGradient>
                          </defs>
                        </svg>
                      </div>
                      <span class="button__text">Cancelar</span>
                    </div>
                  </button>

                  <!-- Bien sin Asignación -->
                  <button onclick="window.location.href='../adminSinAsignacionBien/'" 
                          title="Ir al módulo de bienes sin asignación" 
                          class="button"
                          style="--clr: #7808d0;">
                    <span class="button-decor"></span>
                    <div class="button-content">
                      <div class="button__icon">
                        <!-- SVG Bien sin asignación -->
                        <svg width="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 36 36">
                          <circle fill="url(#gradBien)" r="18" cy="18" cx="18" opacity="0.5"></circle>
                          <path fill="#fff"
                            d="M22.911 8.791c.46-.87-.621-1.734-1.368-1.093L9.293 18.215c-.627.54-.246 1.568.581 1.568h6.93l-3.838 7.248c-.46.87.622 1.734 1.368 1.093l12.25-10.517c.627-.539.246-1.567-.58-1.567h-6.93L22.91 8.79z"
                            clip-rule="evenodd" fill-rule="evenodd" />
                          <defs>
                            <linearGradient id="gradBien" gradientUnits="userSpaceOnUse" y2="36" x2="18" y1="0" x1="18">
                              <stop stop-opacity="0.71" stop-color="#fff"></stop>
                              <stop stop-opacity="0" stop-color="#fff" offset="1"></stop>
                            </linearGradient>
                          </defs>
                        </svg>
                      </div>
                      <span class="button__text">Bien sin Asignación</span>
                    </div>
                  </button>
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
                          <select class="form-select select2" id="area_asignacion_combo" name="area_asignacion_combo"  data-placeholder="Seleccione Destino" style="width: 100%;">
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
                              <div class="col-6">
                              <input type="text" class="form-control" id="cod_bar" name="cod_bar">
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
                              <div class="col-3 d-flex align-items-center">
                                  <button type="button" class="btn btn-outline-dark w-100 px-2 d-flex align-items-center justify-content-center gap-1"  id="btnCamara" onclick="activarCamara()">
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
    <script type="text/javascript" src="color.js"></script>
    <script type="text/javascript" src="alerts.js"></script>
    <script type="text/javascript" src="adminAsignacionBien.js"></script>
    <script type="text/javascript" src="dni.js"></script>
     <script type="text/javascript" src="imprimir.js"></script>
    <script type="text/javascript" src="init.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>