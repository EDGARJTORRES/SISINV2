<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="../../public/css/botones.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/alerta.css" rel="stylesheet"/>
    <title>MPCH::MantGenerales</title>
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
      .error-msg {
        color: red;
        font-size: 0.9em;
        margin-top: 4px;
        display: none;
      }
      .error-msg.active {
        display: block;
      }
      .modal-header{
        background-color: #252422;
      }
      div.dt-button-background {
        display: none !important;
      }
       #marca_data {
        border-collapse: collapse;
      }

      /* Encabezado con borde inferior */
      #marca_data thead th {
        background-color: #f8f9fa;
        border-top: 1px solid rgb(192, 192, 192);
        border-bottom: 1px solid rgb(192, 192, 192);
        border-left: 1px solid rgb(192, 192, 192);
        border-right: 1px solid rgb(192, 192, 192);
        vertical-align: middle;
        text-align: center;
      }

      /* Celdas del cuerpo: solo bordes laterales */
      #marca_data tbody td {
        border-top: none !important; /* asegúrate que no se herede */
        border-bottom: none;
        border-left: 1px solid rgb(192, 192, 192);
        border-right: 1px solid rgb(192, 192, 192);
        vertical-align: middle;
        text-align: center;
      }
    </style>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <nav class="breadcrumb mb-4">
            <a href="../adminMain/">Inicio</a>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span class="breadcrumb-item active">Mantenimientos Generales</span>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span>Marca</span>
          </nav>
          <div class="row g-2  mb-5 align-items-center">
            <div class="col-12">
                <h2 class="page-title">
                    MANTENIMIENTOS GENERALES
                </h2>
              </div>
            </div>
            <div class="col-12 mb-3">
              <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="card-header">
                  <h3 class="card-title">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                      LISTADO DE REGISTROS DE MARCA
                  </h3>
                  <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                      <button class="button2" id="add_button"
                       onclick = "nuevamarca()">
                         <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                          NUEVO REGISTRO
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive mx-4">
                     <div class="row my-4">
                       <div class="col-lg-12">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                          <div class="d-flex align-items-center gap-2 mx-6">
                            <button type="button" class="btn bg-black text-light" id="eliminar_marcas">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                              </svg>
                              Eliminar
                            </button>
                          </div>
                          <div class="d-flex align-items-center gap-2">
                            <div class="input-icon" id="contenedor-excel"> 
                            </div>
                          </div>
                          <div class="d-flex align-items-center gap-2 mx-3">
                            <label for="cantidad_registros" class="form-label mb-0">Mostrar:</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                  </svg>
                                </span>
                                <input type="number" id="cantidad_registros"   style="width: 90px;" class="form-control" min="1" max="25" value="10"> 
                              </div>
                            <label>Registros</label>  
                          </div>
                          <div class="d-flex align-items-center gap-4">
                            <div class="input-icon"  style="width: 350px;">
                                <span class="input-icon-addon">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                </span>
                                <input type="text" id="buscar_registros" placeholder="Buscar registro . . ." class="form-control"> 
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3 mx-6 mt-4">
                          <span id="contador_seleccionados" class="fw-normal text-dark">
                            Se encontraron
                            <span class="px-3 py-1 rounded-4 bg-primary text-white fw-bold mx-1" id="contador_valor">0</span>
                            elementos
                          </span>
                        </div>
                       </div>
                     </div>
                      <table id="marca_data"  class="table card-table table-vcenter text-nowrap datatable" style="width: 90%;">
                          <thead>
                              <tr>
                                <th><input type="checkbox" id="marca_id_all"> </th>
                                <th>MARCA</th>
                                <th>EDITAR</th>
                                <th>ELIMINAR</th>
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
    <div id="alerta-carga" class=" alerta-top-end alert-container"  style="display: none;">
      <div class="success-alert">
        <div class="content-left">
          <div class="icon-bg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-check">
              <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"></path>
            </svg>
          </div>
          <div class="text-content">
            <p class="title">Cargando Marcas... :)</p>
            <p class="description">Espere mientras se obtienen los datos.</p>
          </div>

        </div>
      </div>
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalMarca.php"); ?>
    <script type="text/javascript" src="marca.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>