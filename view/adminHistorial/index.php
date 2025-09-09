<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <title>MPCH::Historial</title>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/iconos.css" rel="stylesheet"/>
    <link href="../../public/css/inicio.css" rel="stylesheet"/>
    <link href="../../public/css/historial.css" rel="stylesheet"/>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper mb-5">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-3">
                    <a href="../adminMain/">Inicio</a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span class="breadcrumb-item active">Historial</span>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span>Historial de Movimientos</span>
                </nav>
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            CONSULTAR HISTORIAL DE MOVIMIENTOS DE BIENES PATRIMONIALES
                        </h2>
                    </div>
                </div>
                <div class="row">
                     <div class="col-lg-5 mb-2">
                        <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                            <div class="card-status-start bg-primary"></div>
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h3 class="card-title mb-0">
                                         <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-object-scan text-primary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M8 8m0 2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2z" /></svg>
                                         LISTADO DE BIENES PATRIMONIALES
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body" id="lista-items">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="mb-1">
                                            <div class="input-icon mb-1">
                                                <span class="input-icon-addon">
                                                   <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 18.004h-4.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                                                </span>
                                                <input type="text" id="buscadorBienes" class="form-control" placeholder="BUSCAR BIEN PATRIMONIAL ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul id="listaBienes" class="list-unstyled mb-0"> 
                                    
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-7">
                        <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                            <div class="card-status-start bg-primary"></div>
                            <div class="card-header">
                                <h3 class="card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram text-primary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg>
                                    SEGUIMIENTO DE MOVIMIENTOS PATRIMONIALES
                                </h3>
                            </div>
                            <div class="card-body" id="lista-items">
                                <div id="historialBien">
                                    <div class="hr-text text-primary title fs-3">SELECCIONE UN BIEN PATRIMONIAL</div>
                                    <div class="alert alert-info text-center mx-auto d-flex align-items-center justify-content-center" role="alert" style="max-width: 600px; gap: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-progress-help icon-alert mx-1 text-primary alert-icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 16v.01" />
                                            <path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                                            <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                            <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                            <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                            <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                            <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                        </svg>
                                        <div class="text-dark" style="text-align: justify; width: 100%;">
                                            Aquí se mostrará el historial completo de todos los <strong>movimientos registrados por el Sistema</strong>. Cada vez que un bien es desplazado, se registra automáticamente el <strong>nombre del responsable</strong> y el <strong>área correspondiente</strong>. Esto permite llevar un <strong>control detallado y actualizado de los bienes</strong>, facilitando su seguimiento y administración eficiente.
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <img id="cargando-detalle" 
                                            src="../../public/logo_mpch2.png" 
                                            alt="Cargando..." 
                                            class="img-fluid"
                                            style="max-width: 280px; height: auto; margin: 40px 0;">
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
    <script type="text/javascript" src="historialmov.js"></script>
</body>
</html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "view/404/");
}
?>