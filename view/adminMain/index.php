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
   <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <title>MPCH: Inicio</title>
    <style>
      body:not([data-bs-theme="dark"]) .dropdown-item:hover,
      body:not([data-bs-theme="dark"]) .nav-link:hover {
          background-color: rgba(0, 0, 0, 0.03);
          transition: all 0.2s ease-in-out;
      }
      .btn-fixed {width: 100%;}
      .btn3{border: 0.5px solid black;color:black}
      .btn4{border: 0.5px solid black;color:black}
      .btn5{border: 0.5px solid black;color:black}
      .btn6{border: 0.5px solid black;color:black}
      
      .btn3:hover,
      .btn4:hover,
      .btn5:hover,
      .btn6:hover {
         box-shadow: 0px 4px 8px -2px rgba(135, 180, 197, 0.75);
      }
      .resumen-total-hover {
        position: relative;
        display: inline-block;
        list-style: none;
      }

      .detalle-hover {
        display: none;
        position: absolute;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        white-space: nowrap;
        z-index: 10;
        top: 110%; /* debajo del número */
        left: 50%;
        transform: translateX(-50%);
        font-size: 13px;
        list-style: none;
      }

      .resumen-total-hover:hover .detalle-hover {
        display: block;
        list-style: none;
      }
    </style>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2  mb-3 align-items-center">
            <div class="col"> 
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-dark text-white py-3 mb-3" style="border-radius: 0.5rem;">
              <div class="container text-center">
                <h2 class="mb-0">¡Bienvenido al Sistema de Gestión de Inventario!</h2>
                <p class="text-muted">Accede rápidamente a los módulos principales de la aplicación</p>
              </div>
            </div>
            <div class="container position-relative" style="margin-top: -40px; z-index: 10;">
              <div class="card m-3 " style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="row m-3">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-3">
                        <a href="../adminAsignacionBien/" class="btn btn3 btn-fixed position-relative">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-augmented-reality me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M12 12.5l4 -2.5" /><path d="M8 10l4 2.5v4.5l4 -2.5v-4.5l-4 -2.5z" /><path d="M8 10v4.5l4 2.5" /></svg>
                          Asignacion Bienes
                          <span class="badge bg-purple badge-notification badge-blink"></span>
                        </a>
                      </div>
                      <div class="col-3">
                        <a href="../adminDesplazamientoBien/" class="btn btn4 btn-fixed position-relative">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-move me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 9l3 3l-3 3" /><path d="M15 12h6" /><path d="M6 9l-3 3l3 3" /><path d="M3 12h6" /><path d="M9 18l3 3l3 -3" /><path d="M12 15v6" /><path d="M15 6l-3 -3l-3 3" /><path d="M12 3v6" /></svg>
                          Desplazamiento Bienes
                          <span class="badge bg-red badge-notification badge-blink"></span>
                        </a>
                      </div>
                      <div class="col-3">
                        <a href="../adminAltaBien/" class="btn btn5 btn-fixed position-relative">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-device-imac-plus me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6"/><path d="M19 16v6"/></svg>
                          Alta de Bienes
                          <span class="badge bg-orange badge-notification badge-blink"></span>
                        </a>
                      </div>
                      <div class="col-3">
                        <a href="../adminMntDependencias/" class="btn  btn6 btn-fixed position-relative">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-ipad-minus me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v10" /><path d="M9 18h3" /><path d="M16 19h6" /></svg>
                          Baja de Bienes
                          <span class="badge bg-black badge-notification badge-blink"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="ribbon ribbon-top bg-yellow">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.94 13.045a9 9 0 1 0 -8.953 7.955" /><path d="M3.6 9h16.8" /><path d="M3.6 15h9.4" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a16.991 16.991 0 0 1 2.529 10.294" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-yellow">TOTAL DE BIENES</h3>
                      <div class="row text-center">
                        <div class="col-lg-4">
                          <img style ="height:60px;" src="../../static/gif/computadora.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-8" style=" align-content: center;">
                            <h2 id="lbltotabien"></h2>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3 ">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="ribbon ribbon-top bg-green">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-cashapp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-success">TOTAL VALOR ADQUISION</h3>
                      <div class="row text-center">
                        <div class="col-lg-4">
                          <img style ="height:60px;" src="../../static/gif/ordenador-portatil.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-8" style=" align-content: center;">
                            <h4 id="lbltotal_adq"></h4>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="ribbon ribbon-top bg-red">
                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title text-danger">ULTIMO BIEN REGISTRADO</h3>
                    <div class="row text-center">
                        <div class="col-lg-4">
                          <img style ="height:60px;" src="../../static/gif/vlogger.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-8" style=" align-content: center;">
                            <h6 id="lblultimo"></h6>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 mb-3">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="ribbon ribbon-top bg-blue">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
                  </div>
                  <div class="card-body">
                      <h3 class="card-title text-blue">ULTIMA BAJA DE BIEN</h3>
                      <div class="row text-center">
                        <div class="col-lg-4">
                          <img style ="height:60px;" src="../../static/gif/presentacion.gif" alt="Cargando..." />
                        </div>
                        <div class="col-lg-8"  style=" align-content: center;">
                            <h6 id="lblultimabaja"></h6>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>    
            <div class="row">
              <div class="col-lg-5  mb-3">
                <div class="row">
                  <div class="col-12 mb-3">
                    <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                      <div class="ribbon ribbon-top bg-purple">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-scale"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 20l10 0" /><path d="M6 6l6 -1l6 1" /><path d="M12 3l0 17" /><path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0" /><path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0" /></svg>
                      </div>
                      <div class="card-body">
                          <h3 class="card-title text-purple ">BIENES REGISTRADOS <span class="text-secondary"> (EVALUANDO SU ESTADO)</span> </h3>
                        <div class="row text-center">
                          <div id="grafico_estados_bienes" style="height: 250px;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 mb-3">
                    <div class="card border-0" style="box-shadow: rgba(116, 142, 152, 0.75) 0px 4px 16px -8px;">
                      <div class="ribbon ribbon-top bg-pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="icon icon-tabler icon-tabler-report-money">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                          <circle cx="12" cy="12" r="9" />
                          <path d="M9 10h6" />
                          <path d="M9 14h6" />
                          <path d="M12 9v6" />
                        </svg>
                      </div>
                      <div class="card-body">
                        <h3 class="card-title text-pink">BALANCE PATRIMONIAL:<span class="text-secondary">  (ADQUISION VS BAJA)</span></h3>
                        <div id="grafico_valor_bienes" style="height: 320px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-lg-7">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="ribbon ribbon-top bg-secondary">
                     <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20h14" /></svg>
                  </div>
                  <div class="card-body">
                   <h3 class="card-title text-purple ">BIENES REGISTRADOS<span class="text-secondary"> (EVALUANDO SU DEPENDENCIA)</span> </h3>
                    <div class="row text-center">
                      <div id="grafico_objetos_dependencia" style="height: 666px;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>    
        </div>
      </div>  
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
   <script type="text/javascript" src="adminMain.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>