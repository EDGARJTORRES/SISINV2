<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::DesplazamientoBienes</title>
  <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
  <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
  <link href="../../public/css/loader.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
  <link href="../../public/css/desplazamiento.css" rel="stylesheet"/>
  <link href="../../public/css/botones.css" rel="stylesheet"/>
  <link href="../../public/css/alta.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
  <body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <nav class="breadcrumb mb-3">
            <a href="../adminMain/">Inicio</a>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span class="breadcrumb-item active">Procesos</span>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span>Dezplazamiento de Bienes</span>
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
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M18.364 5.636l-12.728 12.728" /></svg>
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
                    CREAR DESPLAZAMIENTO
                </button>
              </div>
            </div>
          </div>
          <div class="card border-0 mb-4" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
            <div class="card-status-start bg-primary"></div>
            <div class="card-header">
              <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-title">
                      <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                      REGISTRO POR ANEXOS CREADOS <span class="text-secondary">(ORDENADOS POR FECHA)</span>
                    </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="col-12">
                <div class="row mx-2">
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <input type="hidden" name="pers_origen_id" id="pers_origen_id" />
                      <input type="hidden" name="pers_destino_id" id="pers_destino_id" />
                      <label class="form-label">Área / Dependencia Origen:<span  style="color:red"> *</span></label>
                      <select class="form-control select2" style="max-width: 100%;" id="area_origen_combo" name="area_origen_combo" data-placeholder=" - SELECCIONE DEPENDENCIA ORIGEN - " required>
                        <!-- Aquí puedes agregar opciones del select -->
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">DNI Representante Origen:<span  style="color:red"> *</span></label>
                      <select class="form-select select2" id="usuario_combo_origen" name="pers_id" data-placeholder="Seleccione representante de origen" style="width: 100%;">
                      <option value="" disabled selected>Seleccione</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="form-label">Área / Dependencia Destino:<span style="color:red"> *</span></label>
                      <select class="form-control select2" data-placeholder=" - SELECCIONE DEPENDENCIA DESTINO - " style="max-width: 100%;" id="area_destino_combo" name="area_destino_combo" required>
                        <!-- Aquí puedes agregar opciones del select -->
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">DNI Representante Destino:<span  style="color:red"> *</span></label>
                       <select class="form-select select2" id="usuario_combo_destino" name="pers_id" data-placeholder="Seleccione representante  de destino" style="width: 100%;">
                      <option value="" disabled selected>Seleccione</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mx-2">
                  <div class="col-md-12">
                    <div class="form-group mb-3">
                      <label class="form-label">Documento  que autoriza el traslado:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="doc_traslado" name="doc_traslado" placeholder=" Documento de traslado" required >
                    </div> 
                  </div> 
                </div>
                <div class="table-responsive m-3">
                  <div class="row">
                    <div class="col-6 col-md-6 col-lg-10 mb-3">
                      <div class="input-group">
                        <!-- Campo de texto -->
                        <span class="input-group-text bg-white border-end-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                          </svg>
                        </span>
                        <input type="text" id="buscar_registros" class="form-control border-start-0"
                          placeholder="Buscar registro de bienes . . .">

                        <!-- Botón del buscador -->
                        <button type="button" class="btn btn-primary text-white" onclick="buscarRegistros()">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                          </svg>
                        </button>
                      </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2 mb-3">
                      <button class="btn btn-6 btn-outline-secundary w-100" onclick="limpiarFiltros()">
                        <svg xmlns="http://www.w3.org/2000/svg"   style="color: rgba(55, 57, 59, 1);"
                            width="24" height="24" viewBox="0 0 24 24"  
                            fill="none" stroke="currentColor" stroke-width="2"  
                            stroke-linecap="round" stroke-linejoin="round"  
                            class="icon icon-tabler icons-tabler-outline icon-tabler-eraser">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                          <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" />
                          <path d="M18 13.3l-6.3 -6.3" />
                        </svg>
                        <span style="color: rgba(55, 57, 59, 1);">Limpiar Filtros</span>
                      </button>
                    </div>
                  </div>  
                  <table id="obj_formato"  class="table card-table table-vcenter text-nowrap datatable">
                  <thead>
                    <tr>
                      <th style="text-align: center;">Código de Barras</th>
                      <th style="text-align: center;">Objeto denominación</th>
                      <th style="text-align: center;">Color</th>
                      <th style="text-align: center;">Estado</th>
                      <th style="text-align: center;">Comentario</th>
                      <th style="text-align: center;">Ver</th>
                      <th style="text-align: center;"></th>
                    </tr>
                  </thead>
                  <tbody style="text-align: center;">
                    <!-- Aquí puedes agregar las filas de la tabla dinámicamente -->
                  </tbody>
                </table>
                </div>
              </div><!-- d-flex -->
            </div><!-- card -->
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
            <h3 class="titulo">Generando Dezplazamiento...</h3>
          </div>
      </div>
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="util.js"></script>                       
    <script type="text/javascript" src="init.js"></script>             
    <script type="text/javascript" src="adminAsignacionBien.js"></script> 
    <script type="text/javascript" src="formato_crud.js"></script>       
    <script type="text/javascript" src="imprimir.js"></script>         
  </body>
  </html>
<?php
} else {
  /* Si no a iniciado sesion se redireccionada a la ventana principal */
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>