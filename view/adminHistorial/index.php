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
    <style>
    #lista-items {
    max-height: 600px;
    min-height: 600px;
    overflow-y: auto;
    scrollbar-width: none;        
    -ms-overflow-style: none;      
    }
    #lista-items::-webkit-scrollbar {
    display: none;                 
    }
    .icon-lg {
    width: 36px !important;
    height: 36px !important;
    }
    .stepper-box {
    background-color: white;
    border-radius: 12px;
    padding: 32px;
    width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .stepper-step {
    display: flex;
    margin-bottom: 32px;
    position: relative;
    }
    .stepper-step:last-child {
    margin-bottom: 0;
    }
    .stepper-line {
    position: absolute;
    left: 19px;
    top: 40px;
    bottom: -32px;
    width: 2px;
    background-color: #e2e8f0;
    z-index: 1;
    }
    .stepper-step:last-child .stepper-line {
    display: none;
    }
    .stepper-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    z-index: 2;
    }
    .stepper-completed .stepper-circle {
    background-color: #0f172a;
    color: white;
    }
    .stepper-active .stepper-circle {
    border: 2px solid #0f172a;
    color: #0f172a;
    }
    .stepper-pending .stepper-circle {
    border: 2px solid #e2e8f0;
    color: #94a3b8;
    }
    .stepper-content {
    flex: 1;
    }
    .stepper-title {
    font-weight: 600;
    margin-bottom: 4px;
    }
    .stepper-completed .stepper-title {
    color: #0f172a;
    }
    .stepper-active .stepper-title {
    color: #0f172a;
    }
    .stepper-pending .stepper-title {
    color: #94a3b8;
    }
    .stepper-status {
    font-size: 13px;
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    margin-top: 4px;
    }
    .stepper-completed .stepper-status {
    background-color: #dcfce7;
    color: #166534;
    }
    .stepper-active .stepper-status {
    background-color: #dbeafe;
    color: #1d4ed8;
    }
    .stepper-pending .stepper-status {
    background-color: #f1f5f9;
    color: #64748b;
    }
    .stepper-time {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
    }
    .stepper-controls {
    display: flex;
    justify-content: space-between;
    margin-top: 32px;
    }
    .stepper-button {
    padding: 8px 16px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background-color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    }
    .stepper-button-primary {
    background-color: #0f172a;
    color: white;
    border-color: #0f172a;
    }
    .icon-big {
    width: 50px;
    height:50px;
    }
    .hover-shadow-md:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.1) !important;
    }
    .collapse-icon {
    transition: transform 0.3s ease;
    }
    .list-group-item-activo {
        background-color: #e8eaeeff;        
    }

    </style>
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
                                                    🔍
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
                                <p class="text-muted">Seleccione un bien para ver su historial.</p>
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