<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usua_id_siin"])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../../public/css/estiloselect.css" rel="stylesheet"/>
    <link href="../../public/css/loader.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/botones.css" rel="stylesheet" />
    <link href="../../public/css/alerta.css" rel="stylesheet"/>
    <link href="../../public/css/documento.css" rel="stylesheet"/>
    <link href="../../public/css/iconos.css" rel="stylesheet"/>
    <title>MPCH::DocumentosFirmados</title>
</head>
<body>
  <?php require_once("../html/mainProfile.php"); ?>
  <div class="page-wrapper">
    <div class="page-header d-print-none">
      <div class="container-xl">
        <nav class="breadcrumb mb-3">
          <a href="../adminMain/">Inicio</a>
          <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
          <span class="breadcrumb-item active">Procesos</span>
          <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
          <span>Documentos Firmados</span>
        </nav>
        <div class="row g-2 mb-5 align-items-center">
          <div class="col">
            <h2 class="page-title">
              GESTIÓN DE DOCUMENTOS FIRMADOS
            </h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <button class="button2" id="add_button" 
              onclick=" nuevoregistro()">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 17h-8.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8.5" /><path d="M3 13h13.5" /><path d="M8 21h4.5" /><path d="M10 17l-.5 4" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                 Subir Documento
              </button>
            </div>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 mb-4">
                <div class="card border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                  <div class="card-status-start bg-primary"></div>
                  <div class="card-header">
                      <h3 class="card-title">
                      <i class="fa-solid fa-folder-open text-primary me-2"></i> LISTADO DE DOCUMENTOS SUBIDOS
                      </h3>
                  </div>
                  <div class="table-responsive m-4">
                      <div class="row ">
                        <div class="col-lg-2 mb-3">
                          <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio">
                        </div>
                        <div class="col-lg-2  mb-3">
                          <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin">
                        </div>
                        <div class="col-lg-2  mb-3">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-filter"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" /></svg>
                                </span>
                              <select id="filtro_tipo" class="form-select" style="width: 100%; padding-left: 40px;" placeholder="Filtrar Tipos">
                                  <option value="0">Todos</option>
                                  <option value="Asignacion">Asignacion</option>
                                  <option value="Desplazamiento">Desplazamiento</option>
                                  <option value="Baja">Baja</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                           <input type="text" id="buscar_documento" class="form-control mb-3" placeholder="Buscar documento...">
                        </div>
                        <div class="col-lg-2  mb-3">
                          <button class="btn btn-6 btn-outline-secundary" onclick="limpiarFiltros()">
                            <i class="fa-solid fa-eraser"></i>LIMPIAR FILTROS
                          </button>
                        </div>
                      </div>
                      <table id="documento_data" class="table card-table table-vcenter text-nowrap datatable" style="width: 99%;">
                        <thead>
                          <tr>
                            <th>Tipo</th>
                            <th>Área</th>
                            <th>Usuario</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
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
          <p class="title">Cargando documentos...</p>
          <p class="description">Espere mientras se obtiene la información.</p>
        </div>
      </div>
    </div>
  </div>
  <div id="page">
    <div id="container">
        <div id="ring"></div>
        <div id="ring"></div>
        <div id="ring"></div>
        <div id="ring"></div>
        <div style="display: flex; z-index:1000; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
          <img src="../../static/illustrations/logo_mpch.png" height="90" width="90" alt="Municipal logo " />
            <h3></h3>
          <h3 class="titulo">Guardando Documento...</h3>
        </div>
    </div>
  </div>
  <?php require_once("modalVerDocumento.php"); ?>
   <?php require_once("modalregistrar.php"); ?>
  <?php require_once("../html/footer.php"); ?>
  <?php require_once("../html/mainjs.php"); ?>
  <script type="text/javascript" src="carga.js"></script>
  <script type="text/javascript" src="documento.js"></script>
  <script type="text/javascript" src="arrastrar.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>
