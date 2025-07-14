<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::AltaBienes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
  <link href="../../public/css/Consulta.css" rel="stylesheet"/> 
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-3">
                  <a href="../adminMain/">Inicio</a>
                  <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                  <span class="breadcrumb-item active">Consultar</span>
                  <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                  <span>Bien por Código</span>
                </nav>
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                          CONSULTAR BIEN PATRIMONIAL
                        </h2>
                    </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="card" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="card-status-start bg-primary"></div>
                    <div class="card-header">
                      <h3 class="card-title">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        REGISTROS GENERALES DE FORMATOS
                      </h3>
                    </div>
                    <div class="card-body"> 
                      <div class="row">
                        <div class="col-lg-12">
                        <div class="mb-3">
                          <div class="row">
                            <input type="hidden" name="pers_id" id="pers_id" />
                            <div class="col-12">
                              <label class="form-label">Código de Barras:<span style="color:red"> *</span></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-8">
                              <input type="text" class="form-control" id="cod_bar" name="cod_bar" placeholder="Ingresa el código de barras..." required oninput="limitarADigitos(this)">
                            </div>
                            <div class="col-2 d-flex align-items-center">
                              <button type="button" class="btn btn-info w-100 bg-blue  px-2 d-flex align-items-center justify-content-center gap-1" class="btn btn-info" id="buscaObjeto" onclick="buscarBien()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                  <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                  <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                  <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                  <path d="M18.5 19.5l2.5 2.5" />
                                </svg>
                                <span>BUSCAR</span>
                              </button>
                            </div>
                            <div class="col-2 d-flex align-items-center" > 
                              <button type="button"  class="btn btn-info w-100 bg-blue text-blue-fg" id="btnCamara" onclick="activarCamara()">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-camera-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.5 20h-8.5a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v4" /><path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                ESCANEAR
                                </a>
                              </button>
                          </div>
                        </div>
                        <div class="respuesta mt-3" style="text-align: justify;color: #2a2a2a;font-size: 12px;">
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
    <script type="text/javascript" src="consultar.js"></script>
    <script type="text/javascript" src="camara.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>