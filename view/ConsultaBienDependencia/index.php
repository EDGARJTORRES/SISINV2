<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::Consultas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
  <link href="../../public/css/alerta.css" rel="stylesheet"/>
  <link href="../../public/css/consultadependencia.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper mb-5">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <nav class="breadcrumb mb-3">
            <a href="../adminMain/">Inicio</a>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span class="breadcrumb-item active">Consultar</span>
            <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
            <span>Bien por Dependencia</span>
          </nav>
          <div class="row g-2  mb-3 align-items-center">
              <div class="col">
                  <h2 class="page-title">
                    CONSULTAR BIEN PATRIMONIAL POR DEPENDENCIA
                  </h2>
              </div>
          </div>
          <div class="col-12">
            <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;"> 
              <div class="card-status-start bg-primary"></div>
              <div class="card-header">
                <h3 class="card-title">
                  <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-tree mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6h11" /><path d="M12 12h8" /><path d="M15 18h5" /><path d="M5 6v.01" /><path d="M8 12v.01" /><path d="M11 18v.01" /></svg>
                  LISTADO DE DEPENDENCIAS
                </h3>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="list-group list-group-flush" id="lista-items">
                  </div>
                </div>
                <div class="col-md-8">
                  <div id="contenido-detalle" class="p-3 position-relative text-center">
                    <h4 id="mensaje-inicial" class="mb-2">
                      <div class="hr-text text-primary title">Seleccione una dependencia</div>
                    </h4>
                    <p id="subtitulo-inicial" class="text-secondary">
                      Utilice el panel de navegación ubicado a la izquierda para explorar las diferentes dependencias. 
                      Una vez que seleccione una opción, la información correspondiente se mostrará en este espacio.
                    </p>
                    <div id="detalle-contenido" class="position-relative">
                      <div class="d-flex justify-content-center my-4">
                        <img id="cargando-detalle" 
                            src="../../public/logo_mpch2.png" 
                            alt="Cargando..." 
                            class="img-fluid"
                            style="max-width: 280px; height: auto; opacity: 0.2;">
                      </div>
                    </div>
                  </div>
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
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="biendependencia.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>