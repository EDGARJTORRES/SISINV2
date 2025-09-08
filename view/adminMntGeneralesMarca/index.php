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
  <link href="../../public/css/marca.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
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
            <span>Marca</span>
          </nav>
          <div class="row g-2  mb-5 align-items-center">
            <div class="col-12">
                <h2 class="page-title">
                    MANTENIMIENTOS GENERALES
                </h2>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header d-flex justify-content-center align-items-center">
                    <h4 class="card-title">
                       <svg  class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tags me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 8v4.172a2 2 0 0 0 .586 1.414l5.71 5.71a2.41 2.41 0 0 0 3.408 0l3.592 -3.592a2.41 2.41 0 0 0 0 -3.408l-5.71 -5.71a2 2 0 0 0 -1.414 -.586h-4.172a2 2 0 0 0 -2 2z" /><path d="M18 19l1.592 -1.592a4.82 4.82 0 0 0 0 -6.816l-4.592 -4.592" /><path d="M7 10h-.01" /></svg>
                      GESTIÓN DE MARCAS
                    </h4>
                  </div>
                  <div class="card-body text-center">
                    <p class="text-muted mb-3">
                      Crea y organiza nuevos marcas para una mejor gestión de bienes.
                    </p>
                    <button class="button2" id="add_button" onclick = "nuevamarca()">
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
              </div>
              <div class="ol-12 col-md-8 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header">
                    <h3 class="card-title">
                      <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        LISTADO DE REGISTROS DE MARCA
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive mx-4">
                      <div class="row my-3">
                        <div class="col-lg-12">
                          <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                              <button type="button" class="btn bg-black text-light" id="eliminar_marcas">
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
                                  <input type="text" id="buscar_registros" placeholder="Buscar registro . . ." class="form-control"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <table id="marca_data"  class="table card-table table-vcenter text-nowrap datatable" style="width: 99%;">
                            <thead>
                                <tr>
                                  <th><input type="checkbox" id="marca_id_all"> </th>
                                  <th>MARCA</th>
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
    <script type="text/javascript" src="acciones.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>