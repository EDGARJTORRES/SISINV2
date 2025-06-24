<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/botones.css" rel="stylesheet" />
    <link href="../../public/css/alerta.css" rel="stylesheet"/>
    <title>MPCH::AsignacionBienes</title>
    <style>
      div.dataTables_filter {
        display: none !important;
      }
      body:not([data-bs-theme="dark"]) .dropdown-item:hover,
      body:not([data-bs-theme="dark"]) .nav-link:hover {
          background-color: rgba(0, 0, 0, 0.03);
          transition: all 0.2s ease-in-out;
      }
       th{
        color: #0054a6 !important;
      }
      .swal2-container {
        background-color: rgba(0, 0, 0, 0.25) !important;
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(4px);
      }
      .swal2-popup {
        background: rgb(255, 255, 255) !important;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px !important;
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
      .list-group-item:hover {
        background-color: #f0f0f5;
        transition: background-color 0.2s ease-in-out;
        cursor: pointer;
      }
      #lista-items {
        max-height: 470px;
        overflow-y: auto;
        border-right: 1px solid #e0e0e0;
        scrollbar-width: none;        
        -ms-overflow-style: none;      
      }

      #lista-items::-webkit-scrollbar {
        display: none;                 
      }
      #dependencia_data,
      #dependencias_objetos {
        border-collapse: collapse;
      }

      /* Encabezado con bordes */
      #dependencia_data thead th,
      #dependencias_objetos thead th {
        background-color: #f8f9fa;
        border-top: 1px solid rgb(192, 192, 192);
        border-bottom: 1px solid rgb(192, 192, 192);
        border-left: 1px solid rgb(192, 192, 192);
        border-right: 1px solid rgb(192, 192, 192);
        vertical-align: middle;
        text-align: center;
        font-size: 10px;
      }

      /* Cuerpo de la tabla: solo bordes laterales */
      #dependencia_data tbody td,
      #dependencias_objetos tbody td {
        border-top: none !important;
        border-bottom: none;
        border-left: 1px solid rgb(192, 192, 192);
        border-right: 1px solid rgb(192, 192, 192);
        vertical-align: middle;
        text-align: center;
        font-size: 10px;
      }

      /* Estilo para contenido de celdas */
      #dependencia_data td,
      #dependencias_objetos td {
        white-space: normal !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
      }
      #slider_rango .noUi-connect {
      background: #0d6efd; /* azul Bootstrap */
      }
      #slider_rango .noUi-handle {
        border: none;
        background: #0054a6;
        box-shadow: none;
      }
      #slider_rango {
        height: 10px;
      }
      </style>
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
                <span>Baja de Bien</span>
              </nav>
              <div class="row g-2  mb-5 align-items-center">
                  <div class="col">
                      <h2 class="page-title">
                        BAJA DE BIEN PATRIMONIAL
                      </h2>
                  </div>
                  <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                      <button class="button2" id="add_button" onclick="nuevobaja()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" />
                            <path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" />
                            <path d="M16 19h6" /><path d="M19 16v6" />
                        </svg>
                              Registrar Baja
                      </button>
                    </div>
                  </div>
              </div>
                <div class="row mb-3">
                  <!-- Columna izquierda: Información y filtros -->
                  <div class="col-md-4">
                    
                    <!-- Card: Descripción -->
                    <div class="card border-0 mb-3" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                      <div class="card-status-start bg-primary"></div>
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fa-solid fa-circle-info text-primary me-2"></i>PROCESO DE BAJA
                        </h3>
                      </div>
                      <div class="card-body">
                        <p class="text-justify" style="font-size: 13px; line-height: 2.5;">
                          La <strong>baja patrimonial</strong> retira del inventario los bienes deteriorados, extraviados o inservibles. Verifique el estado antes de continuar, haga clic <a href="../adminAltaBien/" class="text-primary fw-semibold text-decoration-underline">aquí</a>.
                        </p>
                      </div>
                    </div>
                    <div class="card border-0"  style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                      <div class="card-status-start bg-primary"></div>
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fa-solid fa-filter text-primary me-2"></i> FILTROS
                        </h3>
                      </div>
                      <div class="card-body">
                        <div class="my-2">
                          <label for="slider_rango" class="form-label">
                            Filtrar por cantidad de bienes: <span style="color:red">*</span>
                          </label>
                          <div id="slider_rango" class="m-4"></div>
                          <div class="d-flex justify-content-between mx-4 mt-2">
                            <span><strong>Mín:</strong> <span id="min_valor">1</span></span>
                            <span><strong>Máx:</strong> <span id="max_valor">100</span></span>
                          </div>
                        </div>
                        <div class="my-2">
                          <label class="form-label">Buscar Área:<span style="color:red"> *</span></label>
                           <select class="form-select" id="filtro_dependencia" style="width: 100%;">
                            <option value="">Seleccione un área</option>
                            <!-- Opciones dinámicas con JS -->
                           </select>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-12 d-grid mt-3">
                            <button class="btn btn-sm btn-secondary" onclick="limpiarFiltros()">
                              <i class="fa-solid fa-eraser m-2"></i> LIMPIAR FILTROS
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fa-solid fa-table-list me-2 text-primary"></i>
                          REGISTRO POR DEPENDENCIA <span class="text-secondary">(BIENES DADOS DE BAJA)</span>
                        </h3>
                      </div>
                      <div class="table-responsive m-4">
                        <div class="d-flex align-items-center gap-2">
                          <div class="input-icon" id="contenedor-excel"> 
                          </div>
                        </div>
                        <div class="d-flex align-items-center gap-4 my-4 mx-3">
                          <div class="input-icon"  style="width: 100%;">
                              <span class="input-icon-addon">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                              </span>
                              <input type="text" id="buscar_dependencia" placeholder="Buscar registro . . ." class="form-control"> 
                          </div>
                        </div>
                        <table id="dependencias_objetos"class="table card-table table-vcenter text-nowrap datatable" style="width: 95%;">
                          <thead>
                            <tr>
                              <th>Área</th> 
                              <th>Jefe de Área</th>  
                              <th>Total de Bienes</th>
                              <th>Ver</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Cuerpo dinámico con JS -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>  
    </div>
    <div id="alerta-carga" class="alerta-top-end alert-container" style="display: none;">
      <div class="success-alert">
        <div class="content-left">
          <div class="icon-bg">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
          </div>
          <div class="text-content">
            <p class="title">Cargando Bienes Patrimoniales... :)</p>
            <p class="description">Espere mientras se obtienen los datos.</p>
          </div>
        </div>
      </div>
    </div>
     <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalBaja.php"); ?>
    <?php require_once("modalHistorial.php"); ?>
    <script type="text/javascript" src="adminMntDedendencias.js"></script>
    <script type="text/javascript" src="dependencias.js"></script>
    <script type="text/javascript" src="historial.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>