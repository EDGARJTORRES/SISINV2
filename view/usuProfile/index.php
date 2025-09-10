<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::PERFIL</title>
  <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
  <link href="../../public/css/inicio.css" rel="stylesheet"/>
</head>
<body>
  <?php require_once("../html/mainProfile.php"); ?>
  <div class="page-wrapper">
    <div class="page-header">
      <div class="container">
        <div style="position: relative; height: 150px; overflow: hidden;">
            <div style="position: absolute;top: 0; left: 0; right: 0; bottom: 0;background-image: url('../../static/illustrations/fondo2.jpg');background-size: cover;background-position: center;filter:2px;transform: scale(1.1);z-index: 1;">
            </div>
            <div class="container-xl d-flex align-items-center" style="position: relative;z-index: 2;height: 100%;padding-left: 50px;">
                <div class="d-flex align-items-center">
                  <img id="foto_perfil_actual" src="../../static/illustrations/perfil.jpeg" alt="Foto perfil"
                    class="shadow" width="110" height="110" style="border: 2px solid white; object-fit: cover;">
                  <div class="ms-4 text-white">
                    <h2 class="mb-1 fw-bold" id="nombre_usuario"></h2>
                    <h4 id="correo_usuario" class="mb-1 fw-bold"></h4>
                  </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-4 mb-1">
          <div class="col-auto">
            <span class="avatar avatar-lg" style="background-image: url(../../static/illustrations/perfil.jpeg)"> </span>
          </div>
          <div class="col">
            <h1 class="fw-bold m-0">Informacion de Datos Generales</h1>
            <div class="my-2 text-muted" >Resumen personal y de contacto del trabajador registrado en el sistema.</div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="row g-3">
          <div class="col-lg-6">
            <ul class="timeline">
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>Datos completos </h4>
                    <p class="text-secondary" id="nombre_usuario2"></p>
                  </div>
                </div>
              </li>
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-gmail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 20h3a1 1 0 0 0 1 -1v-14a1 1 0 0 0 -1 -1h-3v16z" /><path d="M5 20h3v-16h-3a1 1 0 0 0 -1 1v14a1 1 0 0 0 1 1z" /><path d="M16 4l-4 4l-4 -4" /><path d="M4 6.5l8 7.5l8 -7.5" /></svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>Correo Electronico</h4>
                    <p class="text-secondary" id="correo_usuario2"></p>
                  </div>
                </div>
              </li>
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chess-rook"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 16l-1.447 .724a1 1 0 0 0 -.553 .894v2.382h12v-2.382a1 1 0 0 0 -.553 -.894l-1.447 -.724h-8z" /><path d="M8 16l1 -9h6l1 9" /><path d="M6 4l.5 3h11l.5 -3" /><path d="M10 4v3" /><path d="M14 4v3" /></svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>Rol</h4>
                    <p class="text-secondary" name="tipo_rol" id="tipo_rol"></p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-lg-6">
            <ul class="timeline">
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>Telefono</h4>
                    <p class="text-secondary" name="telefono" id="telefono"></p>
                  </div>
                </div>
              </li>
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-gender-bigender"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M19 3l-5 5" /><path d="M15 3h4v4" /><path d="M11 16v6" /><path d="M8 19h6" /></svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>Sexo</h4>
                    <p class="text-secondary" id="usu_sex"></p>
                  </div>
                </div>
              </li>
              <li class="timeline-event">
                <div class="timeline-event-icon bg-facebook-lt">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                    <path d="M5 12l5 5l10 -10"></path>
                  </svg>
                </div>
                <div class="card timeline-event-card">
                  <div class="card-body">
                    <h4>DNI</h4>
                    <p class="text-secondary" id="dni"></p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("../html/footer.php"); ?>
  <?php require_once '../html/MainJs.php';?>  
  <script type="text/javascript" src="usuperfil.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>