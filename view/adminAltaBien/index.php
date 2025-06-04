<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AltaBienes</title>
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <link href="../../public/css/botones.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <style>
      #lock {
        display: none;
      }
      .lock-label {
          width: 45px;
          height: 45px;
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: rgb(80, 80, 80);
          border-radius: 15px;
          cursor: pointer;
          transition: all 0.3s;
      }
      .lock-wrapper {
          width: fit-content;
          height: fit-content;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          transform: rotate(-10deg);
      }
      .shackle {
          background-color: transparent;
          height: 9px;
          width: 14px;
          border-top-right-radius: 10px;
          border-top-left-radius: 10px;
          border-top: 3px solid white;
          border-left: 3px solid white;
          border-right: 3px solid white;
          transition: all 0.3s;
      }
      .lock-body {
          width: 15px;
      }
      #lock:checked+.lock-label .lock-wrapper .shackle {
          transform: rotateY(150deg) translateX(3px);
          transform-origin: right;
      }
      #lock:checked+.lock-label {
          background-color: rgb(167, 71, 245);
      }
      .lock-label:active {
          transform: scale(0.9);
      }
      div.dataTables_filter {
        display: none !important;
      }
     th{
      color: #0054a6 !important;
     }
     .select2-container--default .select2-selection--single .select2-selection__arrow b {
          border-color: #FF0000 transparent transparent transparent !important;
      }
      input[type="date"]::-webkit-calendar-picker-indicator {
          filter: invert(45%) sepia(100%) saturate(2000%) hue-rotate(10deg) brightness(1.2) contrast(1.2) !important;
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
      .modal-header{
        background-color: #252422;
      }
      .steps .step-item {
        color: #6c757d; 
        font-weight: 500;
      }
      .steps .step-item.active {
        color: #f76707; 
        font-weight: 600;
      }
      .error-msg {
        color: red;
        font-size: 0.9em;
        margin-top: 4px;
        display: none;
      }
      .error-msg.active {
        display: block;
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
                <span>Procesos</span>
                <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                <span>Alta de Bien</span>
              </nav>
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                          ALTA DE BIEN PATRIMONIAL
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                      <div class="btn-list">
                        <button class="button2" id="add_button" 
                        onclick=" nuevoBien()">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            REGISTRAR BIEN
                        </button>
                      </div>
                    </div>
                </div>
                <div class="col-12">
                  <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        REGISTRO POR GRUPO GENERICO<span class="text-secondary"> (OBJETOS EN INVENTARIO)</span>
                      </h3>
                      <div class="text-end col-auto ms-auto d-print-none">
                        <span class="d-inline-block rounded-circle bg-purple mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Nuevos" title="Bienes Nuevos"></span> Nuevo
                        <span class="d-inline-block rounded-circle bg-danger mx-1" style="width: 12px; height: 12px;" aria-label="Baja Definitiva" title="Baja Definitiva"></span> Malo
                        <span class="d-inline-block rounded-circle bg-warning mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Regular" title="Bienes Regular"></span>Regular
                        <span class="d-inline-block rounded-circle bg-success mx-1" style="width: 12px; height: 12px;" aria-label="Bienes Bueno" title="Bienes en Proceso"></span> Bueno
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="table-responsive mx-4">
                        <div class="row my-4">
                          <div class="col-lg-3">
                            <label class="form-label" for="filtro_estado">Filtrar por estado:</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-filter"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" /></svg>
                                </span>
                              <select id="filtro_estado" class="form-select" style="width: 75%; padding-left: 40px;">
                                <option value=""> Todos</option>
                                <option value="Nuevo">Nuevo</option>
                                <option value="Bueno">Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <label  class="form-label" for="cantidad_registros">Registros por página:</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                  <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                  </svg>
                                </span>
                                <input type="number" id="cantidad_registros"   style="width: 75%;" class="form-control" min="1" max="100" value="10"> 
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <label  class="form-label" for="cantidad_registros">Buscar Formato:</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                </span>
                                <input type="text" id="buscar_registros" class="form-control"> 
                            </div>
                          </div>
                        </div>
                        <table id="bienes_data"  class="table card-table table-vcenter text-nowrap datatable ">
                          <thead>
                            <tr>
                              <th><span title="Codigo Interno">Cod</span></th>
                              <th><span title="Codigo de Barras">Cod Barras</span></th>
                              <th><span title="Denominacion del bien">Denominacion</span></th>
                              <th><span title="Fecha Registro">Fecha</span></th>
                              <th><span title="Codigo del grupo">Grupo</span></th>
                              <th><span title="Código de la clase">Clase</span></th>
                              <th><span title="Estado del bien"></span>Estado</th>
                              <th><span title="Procedencia del Bien">Proc.</span></th>
                              <th><span title="Valor Adquision del bien">Valor Adq.</span></th>
                              <th></th>
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
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalObjetoCate.php"); ?>
    <script type="text/javascript" src="adminAltaBien.js"></script>
    <script type="text/javascript" src="bienes.js"></script>
    <script type="text/javascript" src="funcionalidad.js"></script>
    <script type="text/javascript" src="modalobjateCate.js"></script>
     <script type="text/javascript" src="validaciones.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
