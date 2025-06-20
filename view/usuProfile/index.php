<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::AltaBienes</title>
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <form class="card" method="POST">
    <div style="position: relative; height: 180px; overflow: hidden;">
        <!-- Imagen de fondo con blur -->
        <div style="
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('../../static/illustrations/fondo2.jpg');
            background-size: cover;
            background-position: center;
            filter:2px;
            transform: scale(1.1);
            z-index: 1;">
        </div>

        <!-- Contenido sobre la imagen -->
        <div class="container-xl d-flex align-items-center" style="
            position: relative;
            z-index: 2;
            height: 100%;
            padding-left: 50px;">
            
            <!-- Cuadro izquierdo con la foto -->
            <div class="d-flex align-items-center">
            <img id="foto_perfil_actual" src="../../static/illustrations/perfil.jpeg" alt="Foto perfil"
                class="shadow" width="140" height="140">
            <div class="ms-4 text-white">
            <h2 class="mb-1 fw-bold" id="nombre_usuario"></h2>
            <h4 id="correo_usuario" class="mb-1 fw-bold"></h4>
            </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header">
          <div class="container">
            <div class="row align-items-center">
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
              <div class="col">
                <ul class="timeline">
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M4 4l11.733 16h4.267l-11.733 -16z"></path>
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"></path>
                      </svg>
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
                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
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
                      <!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <h4>Database backup completed!</h4>
                        <p class="text-secondary">Download the <a href="#">latest backup</a>.</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/brand-facebook -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path>
                      </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <h4>+290 Page Likes</h4>
                        <p class="text-secondary">This is great, keep it up!</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/user-plus -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                        <path d="M16 19h6"></path>
                        <path d="M19 16v6"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                      </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <h4>+3 Friend Requests</h4>
                        <div class="avatar-list mt-3">
                          <span class="avatar avatar-2" style="background-image: url(./static/avatars/000m.jpg)"><span class="badge bg-success"></span> </span>
                          <span class="avatar avatar-2" style="background-image: url(./static/avatars/052f.jpg)"><span class="badge bg-success"></span> </span>
                          <span class="avatar avatar-2" style="background-image: url(./static/avatars/002m.jpg)"><span class="badge bg-success"></span> </span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/photo -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M15 8h.01"></path>
                        <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                        <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                      </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <h4>+3 New photos</h4>
                        <div class="mt-3">
                          <div class="row g-2">
                            <div class="col-4">
                              <!-- Photo -->
                              <img src="./static/photos/blue-sofa-with-pillows-in-a-designer-living-room-interior.jpg" class="rounded" alt="Blue sofa with pillows in a designer living room interior">
                            </div>
                            <div class="col-4">
                              <!-- Photo -->
                              <img src="./static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg" class="rounded" alt="Home office desk with Macbook, iPhone, calendar, watch &amp; organizer">
                            </div>
                            <div class="col-4">
                              <!-- Photo -->
                              <img src="./static/photos/young-woman-working-in-a-cafe.jpg" class="rounded" alt="Young woman working in a cafe">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                      </svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <h4>System updated to v2.02</h4>
                        <p class="text-secondary">Check the complete changelog at the <a href="#">activity page</a>.</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div> 

    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2  mb-5 align-items-center">
                    <div class="col">
                        <div class="page-pretitle mb-3">
                            Perfil
                        </div>
                        <h2 class="page-title">
                           Informacion de Datos Generales
                        </h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row row-cards">
                        <div class="col-12">
                                <div class="card-body">
                                    <div class="row row-cards">
                                       <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Nombres</label>
                                                    <input type="text" class="form-control" disabled=""  name="usu_nom" id="usu_nom" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Apellido Paterno</label>
                                                    <input type="text" class="form-control" disabled="" name="usu_apep" id="usu_apep" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Materno</label>
                                                    <input type="text" class="form-control" disabled="" name="usu_apem" id="usu_apem">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mb-5">
                                                    <label class="form-label">Correo</label>
                                                    <input type="text" class="form-control" disabled=""  name="usu_corr" id="usu_corr">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" name="usu_pass" id="usu_pass"  disabled="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Telefono</label>
                                                    <input type="text" class="form-control" disabled="" name="telefono" id="telefono">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Rol</label>
                                                    <input type="text" class="form-control" disabled="" name="tipo_rol"  id="tipo_rol">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-5">
                                                    <label class="form-label">Sexo</label>
                                                    <input type="text" class="form-control" disabled="" name="usu_sex"  id="usu_sex">
                                                </div>           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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