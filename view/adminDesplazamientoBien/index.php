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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body:not([data-bs-theme="dark"]) .dropdown-item:hover,
    body:not([data-bs-theme="dark"]) .nav-link:hover {
        background-color: rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
    }
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
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px !important;
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
      /*lista de botones*/
    .button {
      text-decoration: none;
      line-height: 1;
      overflow: hidden;
      position: relative;
      box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;
      background-color: #fff;
      color: #121212;
      border: none;
      cursor: pointer;
    }
    .button-decor {
      position: absolute;
      inset: 0;
      background-color: var(--clr);
      transform: translateX(-100%);
      transition: transform 0.3s;
      z-index: 0;
    }
    .button-content {
      display: flex;
      align-items: center;
      font-weight: 600;
      position: relative;
      overflow: hidden;
      
    }
     .button__icon {
      width: 48px;
      height: 40px;
      background-color: var(--clr);
      display: grid;
      place-items: center;
    }
    .button__text {
      display: inline-block;
      transition: color 0.2s;
      padding: 2px 0.5rem 2px;
      padding-left: 0.75rem;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
    .button:hover .button__text {
      color: #fff;
    }

    .button:hover .button-decor {
      transform: translate(0);
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
            <span>Dezplazamiento de Bienes</span>
          </nav>
          <div class="row g-2  mb-3 align-items-center">
              <div class="col-lg-8">
                <h2 class="page-title"> DESPLAZAMIENTO DE BIENES PARA EL SISTEMA DE INVENTARIO
              </div> 
              <div class="col-auto ms-auto d-print-none">
                <button type="submit" name="action" value="add" onclick="nuevoFormato()" class="button" style="--clr: #00ad54; border-left:1px solid #00ad54;">
                  <span class="button-decor"></span>
                  <div class="button-content">
                    <div class="button__icon">
                      <svg
                        viewBox="0 0 46 46"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                      >
                        <g clip-path="url(#icon-insights-cat_svg__clip0_1051_21081)">
                          <circle
                            opacity="0.5"
                            cx="23"
                            cy="23"
                            r="23"
                            fill="url(#icon-insights-cat_svg__paint0_linear_1051_21081)"
                          ></circle>
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M34.42 15.93c.382-1.145-.706-2.234-1.851-1.852l-18.568 6.189c-1.186.395-1.362 2-.29 2.644l5.12 3.072a1.464 1.464 0 001.733-.167l5.394-4.854a1.464 1.464 0 011.958 2.177l-5.154 4.638a1.464 1.464 0 00-.276 1.841l3.101 5.17c.644 1.072 2.25.896 2.645-.29L34.42 15.93z"
                            fill="#fff"
                          ></path>
                        </g>
                        <defs>
                          <linearGradient
                            id="icon-insights-cat_svg__paint0_linear_1051_21081"
                            x1="23"
                            y1="0"
                            x2="23"
                            y2="46"
                            gradientUnits="userSpaceOnUse"
                          >
                            <stop stop-color="#fff" stop-opacity="0.71"></stop>
                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                          </linearGradient>
                          <clipPath id="icon-insights-cat_svg__clip0_1051_21081">
                            <path fill="#fff" d="M0 0h46v46H0z"></path>
                          </clipPath>
                        </defs>
                      </svg>
                    </div>
                    <span class="button__text">Guardar</span>
                  </div>
                </button>
                <button type="reset" onclick="resetCampos()" class="button mx-2" style="--clr: #00c2c5;">
                  <span class="button-decor"></span>
                  <div class="button-content">
                    <div class="button__icon">
                      <svg
                        viewBox="0 0 46 46"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                      >
                        <g clip-path="url(#icon-blockchain-cat_svg__clip0_701_19339)">
                          <circle
                            opacity="0.5"
                            cx="23"
                            cy="23"
                            r="23"
                            fill="url(#icon-blockchain-cat_svg__paint0_linear_701_19339)"
                          ></circle>
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M35.65 15.354L23 8.05l-12.65 7.303V29.96L23 37.264l12.65-7.304V15.353zm-1.512 3.02l-9.988 4.994v9.912h-2.3v-9.933L12.5 18.36l1.082-2.03 9.435 5.033 10.092-5.046 1.029 2.057z"
                            fill="#fff"
                          ></path>
                        </g>
                        <defs>
                          <linearGradient
                            id="icon-blockchain-cat_svg__paint0_linear_701_19339"
                            x1="23"
                            y1="0"
                            x2="23"
                            y2="46"
                            gradientUnits="userSpaceOnUse"
                          >
                            <stop stop-color="#fff" stop-opacity="0.71"></stop>
                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                          </linearGradient>
                          <clipPath id="icon-blockchain-cat_svg__clip0_701_19339">
                            <path fill="#fff" d="M0 0h46v46H0z"></path>
                          </clipPath>
                        </defs>
                      </svg>
                    </div>
                    <span class="button__text">Cancelar</span>
                  </div>
                </button>
              </div>
            </h2>
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
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <input type="hidden" name="pers_origen_id" id="pers_origen_id" />
                      <input type="hidden" name="pers_destino_id" id="pers_destino_id" />
                      <label class="form-label">Área Origen:<span  style="color:red"> *</span></label>
                      <select class="form-control select2" style="max-width: 100%;" id="area_origen_combo" name="area_origen_combo" required>
                        <!-- Aquí puedes agregar opciones del select -->
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="pers_origen_dni" name="pers_origen_dni" placeholder="Ingresa el DNI del representante del bien..." required oninput="limitarADigitosDNI(this)">
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="pers_origen_nom" name="pers_origen_nom" placeholder="Nombre Representante" required readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="form-label">Área Destino:<span style="color:red"> *</span></label>
                      <select class="form-control select2" style="max-width: 100%;" id="area_destino_combo" name="area_destino_combo" required>
                        <!-- Aquí puedes agregar opciones del select -->
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">DNI Representante:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="pers_destino_dni" name="pers_destino_dni" placeholder="Ingresa el DNI del representante del bien..." required oninput="limitarADigitosDNIdestino(this)">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Nombre del Representante:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="pers_destino_nom" name="pers_destino_nom" placeholder="Nombre Representante" required readonly>
                    </div>

                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group mb-3">
                      <label class="form-label">Documento  que autoriza el traslado:<span  style="color:red"> *</span></label>
                      <input type="text" class="form-control" id="doc_traslado" name="doc_traslado" placeholder=" Documento de traslado" required >
                    </div> 
                  </div> 
                </div>  
                <div class="table-responsive m-4">
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
    <?php require_once("../html/mainjs.php"); ?>
    <script type="text/javascript" src="util.js"></script>              
    <script type="text/javascript" src="dni.js"></script>                
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