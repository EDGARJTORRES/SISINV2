<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/sinasignacion.css" rel="stylesheet"/>
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
           <span class="breadcrumb-item active">Procesos</span>
            <a href="../adminAsignacionBien/">
              <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
              Asignación de Bienes
            </a>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span>Bienes sin Asignacion</span>
          </nav>
          <div class="row g-2  mb-5 align-items-center">
            <div class="col">
              <button class="Btn" onclick="window.location.href = '../adminAsignacionBien/';">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up-double"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 14l-4 -4l4 -4" /><path d="M8 14l-4 -4l4 -4" /><path d="M9 10h7a4 4 0 1 1 0 8h-1" /></svg>
                Regresar
              </button>
            </div>
            </div>
            <div class="col-12 mb-3">
              <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="card-status-start bg-primary"></div>
                <div class="card-header">
                  <h3 class="card-title">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                      LISTADO DE BIENES SIN ASIGNACION
                  </h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive mx-4">
                    <div class="row my-4">
                      <div class="col-lg-12">
                        <div class="d-flex flex-wrap align-items-center gap-3">
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
                            <div class="input-icon"  style="width: 400px;">
                                <span class="input-icon-addon">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                </span>
                                <input type="text" id="buscar_registros" placeholder="Buscar registro ..." class="form-control"> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <table id="bienes_data"  class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                              <tr>
                              <th><span title="Codigo Interno">Cod</span></th>
                              <th><span title="Codigo de Barras">Cod Barras</span></th>
                              <th><span title="Fecha Registro">Fecha</span></th>
                              <th><span title="Fecha Registro">Nombre Objeto</span></th>
                              <th><span title="Estado del bien"></span>Estado</th>
                              <th><span title="Procedencia del Bien">Proc.</span></th>
                              <th><span title="Valor Adquision del bien">Valor Adq.</span></th>
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
    <script type="text/javascript" src="bienSinAsignacion.js"></script>
</body>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>