<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require_once("../html/mainHead.php"); ?>
  <title>MPCH::DetalleBienes</title>
  <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
  <link href="../../public/css/botones.css" rel="stylesheet"/>
  <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
  <link href="../../public/css/alerta2.css" rel="stylesheet"/>
  <link href="../../public/css/loading.css" rel="stylesheet"/>
  <link href="../../public/css/iconos.css" rel="stylesheet"/>
  <link href="../../public/css/detallebien.css" rel="stylesheet"/>
  <link href="../../public/css/inicio.css" rel="stylesheet"/>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper mb-5">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-2">
                    <a href="../adminMain/">Inicio</a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span class="breadcrumb-item active">Procesos</span>
                    <a href="../adminAltaBien/">
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    Alta de Bienes
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span>Detalle de Bien Patrimonial</span>
                </nav>
                <div class="row align-items-center mb-2">
                    <div class="col-auto">
                        <a href="../adminAltaBien/" class="btn btn-ghost-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Volver
                        </a>
                    </div>
                    <div class="col">
                        <h2 class="page-title" style="border-left: 1px solid #000; padding-left: 8px;">
                            DETALLE DE ALTA DE BIEN PATRIMONIAL
                        </h2>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-0" style="box-shadow: 15px 15px 30px #bebebe;">
                            <div class="card-status-start bg-primary"></div>
                            <div class="ribbon bg-dark" id="ribbon-estado"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg></div>
                            <div class="row m-4 align-items-center">
                                <div class="col-lg-9 d-flex flex-column">
                                    <label for="combo_vehiculo" class="form-label mb-1">
                                        Vehículo: <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group flex-grow-1">
                                        <select class="form-select select2" id="combo_vehiculo" name="combo_vehiculo">
                                        </select>
                                        <button class="btn btn-primary" type="button" id="btnBuscarPlaca">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-world-search mx-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M21 12a9 9 0 1 0 -9 9" />
                                                <path d="M3.6 9h16.8" />
                                                <path d="M3.6 15h7.9" />
                                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                                <path d="M12.5 3a16.984 16.984 0 0 1 2.574 8.62" />
                                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path d="M20.2 20.2l1.8 1.8" />
                                            </svg> Buscar Placa
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-2 d-flex flex-column align-items-end ms-4 mt-4">
                                    <span id="bien_placa" class="badge bg-purple-lt badge-lg">Sin Registro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <div class="card border-0" style="box-shadow: 15px 15px 30px #bebebe,
                                                             -15px -15px 30px #ffffff;">
                            <div class="card-status-start bg-primary"></div>
                            <div class="card-header ">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar-popular mx-1 text-primary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20h14" /></svg>
                                    RESUMEN DEL VEHÍCULO
                                </h3>
                            </div>
                            <div class="card-body">
                            <div class="accordion" id="menuSecciones">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-car mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" /></svg>
                                            Identificación del Vehículo
                                        </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#menuSecciones">
                                        <div class="accordion-body">
                                            <p class="text-muted">Contiene los datos generales del vehículo, como ruta, tipo de movilidad, categoría, año de fabricación, carrocería y tipo de combustible.</p>
                                            <div class="d-flex justify-content-end">
                                                <a href="#identificacion"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>Ir a Identificación</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-manual-gearbox mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M12 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M12 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 8l0 8" /><path d="M12 8l0 8" /><path d="M19 8v2a2 2 0 0 1 -2 2h-12" /></svg>
                                            Características Técnicas
                                        </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#menuSecciones">
                                        <div class="accordion-body">
                                            <p class="text-muted">Incluye información técnica esencial como peso neto, carga útil, peso bruto, cantidad de ruedas, cilindros y ejes.</p>
                                            <div class="d-flex justify-content-end">
                                                <a href="#caracteristicas"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>Ir a Características</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-meeple mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 20h-5a1 1 0 0 1 -1 -1c0 -2 3.378 -4.907 4 -6c-1 0 -4 -.5 -4 -2c0 -2 4 -3.5 6 -4c0 -1.5 .5 -4 3 -4s3 2.5 3 4c2 .5 6 2 6 4c0 1.5 -3 2 -4 2c.622 1.093 4 4 4 6a1 1 0 0 1 -1 1h-5c-1 0 -2 -4 -3 -4s-2 4 -3 4z" /></svg>
                                            Capacidades e Información Mecánica
                                        </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#menuSecciones">
                                        <div class="accordion-body">
                                            <p class="text-muted">Contiene detalles mecánicos y de capacidad: número de motor, pasajeros permitidos, cantidad de asientos y otras características de uso.</p>
                                            <div class="d-flex justify-content-end">
                                                <a href="#capacidades" ><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>Ir a Capacidades</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mt-4">
                        <div class="card border-0" style="box-shadow: 15px 15px 30px #bebebe,
                                                             -15px -15px 30px #ffffff;">
                            <div class="card-status-start bg-primary"></div>
                            <div class="card-header">
                            <h3 class="card-title">
                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                                REGISTRO POR TIPOS DE VEHÍCULOS<span class="text-secondary"> (OBJETOS EN INVENTARIO)</span>
                            </h3>
                            </div>
                            <div id="contenidoDinamico" class="card-body my-3 mx-2">
                                <div id="alerta-carga" class=" alert-container my-3 ">
                                    <div class="success-alert">
                                        <div class="content-left">
                                            <div class="icon-bg">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-speakerphone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 8a3 3 0 0 1 0 6" /><path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" /><path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" /></svg>
                                            </div>
                                            <div class="text-content mx-2">
                                                <p class="title">¡Seleccione un Vehículo! :)</p>
                                                <p class="description">Para ver o editar los detalles del bien patrimonial, por favor seleccione un vehículo del menú desplegable ubicado en la parte superior izquierda de esta sección.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mySpinnerContainer">
                                    <div class="mySpinner"></div>
                                    <div class="myLoader">
                                        <p>Cargando </p>
                                        <div class="myWords">
                                        <span class="myWord">combustibles</span>
                                        <span class="myWord">vehículos</span>
                                        <span class="myWord">marcas</span>
                                        <span class="myWord">modelos</span>
                                        <span class="myWord">placas</span>
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
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="detalle.js"></script>
    <script type="text/javascript" src="identificacion.js"></script>
    <script type="text/javascript" src="caracteristica.js"></script>
    <script type="text/javascript" src="capacidad.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
