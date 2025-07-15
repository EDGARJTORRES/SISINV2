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
    <link href="../../public/css/iconos.css" rel="stylesheet"/>
    <link href="../../public/css/clase.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>MPCH::MantGenerales</title>
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
            <span>Clases</span>
          </nav>
          <div class="row g-2  mb-5 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    MANTENIMIENTOS GENERALES
                </h2>
              </div>
            </div>
            <div class="row">
              <div class="col-4 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header d-flex justify-content-center align-items-center">
                    <h4 class="card-title">
                      <svg class="text-primary"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-check me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M6 4v4" /><path d="M6 12v8" /><path d="M13.823 15.176a2 2 0 1 0 -2.638 2.651" /><path d="M12 4v10" /><path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M18 4v1" /><path d="M18 9v5" /><path d="M15 19l2 2l4 -4" /></svg>
                      GRUPO DE CLASES
                    </h4>
                  </div>
                  <div class="card-body text-center">
                    <p class="text-muted mb-3">
                      Crea y organiza nuevos grupos de clases para una mejor gestión de bienes.
                    </p>
                    <button class="button2" id="add_button" onclick="nuevaclase()">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-device-imac-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" />
                        <path d="M3 13h13.5" />
                        <path d="M8 21h4.5" />
                        <path d="M10 17l-.5 4" />
                        <path d="M16 19h6" />
                        <path d="M19 16v6" />
                      </svg>
                      Nuevo Registro
                    </button>
                  </div>
                </div>
                <div class="card border-0 mt-3" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;" id="card_ultima_accion">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-body">
                    <h6 class="text-muted mb-2">Última acción</h6>
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="fw-bold" id="accion_texto">-</span>
                      <span class="text-muted small" id="accion_tiempo">-</span>
                    </div>
                  </div>
                </div>
                <div class="card border-0 shadow-sm mt-3">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-body">
                    <div class="my-2">
                      <label for="slider_rango" class="form-label">
                        Filtrar por rango de codigo:<span style="color:red"> *</span>
                      </label>
                      <div id="slider_rango" class="m-4"></div>
                      <div class="d-flex justify-content-between mx-4 mt-2">
                        <span><strong>Mín:</strong> <span id="min_valor">1</span></span>
                        <span><strong>Máx:</strong> <span id="max_valor">100</span></span>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-12 d-grid mt-3">
                        <button class="btn btn-6" onclick="limpiarFiltros()">
                          <i class="fa-solid fa-eraser m-2"></i> LIMPIAR FILTROS
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-8 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header">
                    <h3 class="card-title">
                      <svg class="text-primary"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        LISTADO DE REGISTROS DE CLASES
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive mx-4">
                      <div class="row my-3">
                        <div class="col-lg-12">
                          <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="d-flex align-items-center">
                              <button type="button" class="btn bg-black text-light" id="eliminar_gc">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                  <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                </svg>
                                Eliminar
                              </button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mx-4">
                              <div class="input-icon" id="contenedor-excel"> 
                              </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
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
                          </div>
                          <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                            <span id="contador_seleccionados" class="fw-normal text-dark">
                              Se encontraron
                              <span class="px-3 py-1 rounded-4 bg-primary text-white fw-bold mx-1" id="contador_valor">0</span>
                              elementos
                            </span>
                            <div class="d-flex align-items-center gap-4">
                              <div class="input-icon"  style="width: 410px;">
                                  <span class="input-icon-addon">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                  </span>
                                  <input type="text" id="buscar_registros" placeholder="Buscar registro  . . ." class="form-control"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <table id="clase_data"  class="table card-table table-vcenter text-nowrap datatable" style="width: 99%;">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="clase_id_all"> </th>
                                    <th>COD</th>
                                    <th>CLASE</th>
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
            <p class="title">Cargando Clases... :)</p>
            <p class="description">Espere mientras se obtienen los datos.</p>
          </div>
        </div>
      </div>
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <?php require_once("modalClase.php"); ?>
    <script type="text/javascript" src="alerts.js"></script>
    <script type="text/javascript" src="eliminacioncheckbox.js"></script>
    <script type="text/javascript" src="acciones.js"></script>
    <script type="text/javascript" src="datatable.js"></script>
    <script type="text/javascript" src="crud.js"></script>
    <script type="text/javascript" src="init.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>