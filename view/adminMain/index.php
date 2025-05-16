<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php require_once("../html/mainHead.php"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2  mb-5 align-items-center">
            <div class="col">
                <div class="page-pretitle mb-3">
                    Inicio
                </div>
                <h2 class="page-title" style="color:white;">
                  DASHORBOARD
                </h2>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="row mb-3">
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card ">
                  <div class="ribbon ribbon-top bg-yellow">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.94 13.045a9 9 0 1 0 -8.953 7.955" /><path d="M3.6 9h16.8" /><path d="M3.6 15h9.4" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a16.991 16.991 0 0 1 2.529 10.294" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-yellow">Ordenes Giradas</h3>
                      <div class="row text-center">
                        <div class="col-lg-6">
                          <img style ="height:60px;" src="../../static/gif/computadora.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-6">
                            <h1 id="lblactivo" style="font-size: 3rem;"></h1>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3 ">
                <div class="card ">
                  <div class="ribbon ribbon-top bg-green">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-cashapp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-success">Ordenes Pagadas</h3>
                      <div class="row text-center">
                        <div class="col-lg-6">
                          <img style ="height:60px;" src="../../static/gif/ordenador-portatil.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-6">
                            <h1 id="lblmantenimiento" style="font-size: 3rem;"></h1>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card">
                  <div class="ribbon ribbon-top bg-red">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title text-danger">Ordenes Completadas</h3>
                    <div class="row text-center">
                        <div class="col-lg-6">
                          <img style ="height:60px;" src="../../static/gif/vlogger.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-6">
                            <h4 id="lblultimo"></h4>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card ">
                  <div class="ribbon ribbon-top bg-blue">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-blue">Ordenes Improcedentes</h3>
                      <div class="row text-center">
                        <div class="col-lg-6">
                          <img style ="height:60px;" src="../../static/gif/presentacion.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-6">
                            <h1 id="lbltotal" style="font-size: 3rem;"></h1>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>  
            <div class="row">
              <div class="col-lg-8  mb-3">
                <div class="row">
                  <div class="col-12 mb-3">
                    <div class="card">
                      <div class="ribbon ribbon-top bg-azure">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-scale"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 20l10 0" /><path d="M6 6l6 -1l6 1" /><path d="M12 3l0 17" /><path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0" /><path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0" /></svg>
                      </div>
                      <div class="card-body">
                        <h3 class="card-title text-info">Montos Comparativos Pendientes, Pagados y Completados</h3>
                        <h4 class="card-subtitle text-secondary">Resumen de los montos establecidos en cada orden de giro evaluando su estado.</h4>
                        <div class="row text-center">
                          <div id="grafico_categoria" style="height: 200px;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12  mb-3">
                    <div class="card">
                      <div class="ribbon ribbon-top bg-purple">
                       <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                      </div>
                      <div class="card-body">
                        <h3 class="card-title text-purple">Nuevos Registros por Usuario</h3>
                        <h4 class="card-subtitle text-secondary">
                          <h4 class="card-subtitle text-secondary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                          miércoles, 14 de mayo de 2025
                        </h4>
                        <div class="table-responsive m-4">
                          <table id="equipo_data" class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                              <tr>
                                <th>Usuario</th>
                                <th>Total de Órdenes</th>
                                <th>Órdenes del Día Anterior</th>
                                <th>Órdenes Hoy</th>
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
              <div class="col-lg-4">
                <div class="card">
                  <div class="ribbon ribbon-top bg-secondary">
                     <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20h14" /></svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title text-secondary">Estado de las Tasas</h3>
                    <h4 class="card-subtitle text-secondary">Resumen del estado de las tasas de manera independiente.</h4>
                    <div class="row text-center">
                      <div id="grafico_area" style="height: 400px;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>    
        </div>
      </div>  
    </div>
   <script src="https://code.highcharts.com/highcharts.js"></script>
   <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <?php require_once("../html/mainjs.php"); ?>
   <script type="text/javascript" src="usuhome.js"></script>
</body>
</html>
<?php
} else {
  /* Si no a iniciado sesion se redireccionada a la ventana principal */
  header("Location:" . Conectar::ruta() . "views/404/");
}
?>